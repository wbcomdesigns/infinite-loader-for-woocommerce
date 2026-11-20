<?php
/**
 * One-time activation of the baked-in free licence key, so update downloads work with zero setup.
 *
 * Runs inline on admin_init, at most once per retry window, and never stops retrying on its own (a preset
 * licence needs zero owner action). Model: BuddyWoo 1.5.6 PresetActivation::run() / request_within_budget().
 *
 * - One 5s time budget is shared by the updates host and the fallback. When the fallback is skipped because the
 *   first host used the whole budget, its unearned SDK pause is cleared and the next attempt comes in 30 minutes:
 *   that lands inside the SDK's one-hour pause of the first host, so it goes straight to the fallback.
 * - A run where every host is paused by the SDK sends nothing; it comes back a minute after the earliest pause ends.
 * - The preset key never overwrites a key the owner entered: once a non-preset key or a valid licence is present
 *   the activation stops for good, and the preset key is written only after a valid reply.
 *
 * @package Infinite_Loader_For_Woocommerce
 * @since   1.3.5
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether the owner manages the licence (their own key, or a valid licence status). Latches once true.
 * Reads options that can change during a request, so the result is not stable between calls.
 *
 * @phpstan-impure
 *
 * @return bool
 */
function infinite_loader_for_woocommerce_preset_owner_managed() {
	if ( get_option( 'infinite_loader_for_woocommerce_preset_owner_managed' ) ) {
		return true;
	}
	// The SDK keys both options by the plugin folder name.
	$slug   = basename( dirname( INFINITE_LOADER_FOR_WOOCOMMERCE_FILE ) );
	$key    = (string) get_option( $slug . '_license_key', '' );
	$status = get_option( $slug . '_license' );
	$valid  = is_object( $status ) && 'valid' === ( $status->license ?? '' );
	if ( ( '' !== $key && INFINITE_LOADER_FOR_WOOCOMMERCE_FREE_LICENSE_KEY !== $key ) || $valid ) {
		update_option( 'infinite_loader_for_woocommerce_preset_owner_managed', 1, false );
		return true;
	}
	return false;
}

/**
 * One activation attempt, when one is due. Hooked to admin_init.
 *
 * @return void
 */
function infinite_loader_for_woocommerce_preset_activation() {
	// Owner opt-out for air-gapped / privacy-strict installs.
	if ( defined( 'INFINITE_LOADER_FOR_WOOCOMMERCE_NO_LICENSE_PHONE_HOME' ) && INFINITE_LOADER_FOR_WOOCOMMERCE_NO_LICENSE_PHONE_HOME ) {
		return;
	}
	$backoff = 'infinite_loader_for_woocommerce_preset_activation_backoff';
	if ( get_option( 'infinite_loader_for_woocommerce_preset_activated' ) || get_transient( $backoff ) || infinite_loader_for_woocommerce_preset_owner_managed() ) {
		return;
	}

	// Every host inside the SDK's one-hour pause: nothing would be sent, so wait for the earliest pause to end.
	$hosts  = array( INFINITE_LOADER_FOR_WOOCOMMERCE_LICENCE_HOST, 'https://wbcomdesigns.com' );
	$paused = array();
	foreach ( $hosts as $host ) {
		$paused[] = (int) get_option( 'eddsdk_failed_request_' . md5( $host ), 0 ); // The SDK's pause option.
	}
	if ( min( $paused ) > time() ) {
		set_transient( $backoff, 1, min( $paused ) - time() + MINUTE_IN_SECONDS );
		return;
	}

	// One 5s budget across both hosts (the SDK's own timeout is 15s each, and this runs on an admin page).
	$deadline = microtime( true ) + 5;
	$skipped  = array();
	$cap      = static function ( $args ) use ( $deadline ) {
		$args['timeout'] = max( 0.5, min( (float) ( $args['timeout'] ?? 5 ), $deadline - microtime( true ) ) );
		return $args;
	};
	$gate     = static function ( $pre, $args, $url ) use ( $deadline, &$skipped ) {
		if ( false === $pre && ( $deadline - microtime( true ) ) < 0.5 ) {
			$skipped[] = wp_parse_url( $url, PHP_URL_SCHEME ) . '://' . wp_parse_url( $url, PHP_URL_HOST );
			return new WP_Error( 'infinite_loader_budget_spent', 'Licence request time budget spent.' );
		}
		return $pre;
	};
	add_filter( 'http_request_args', $cap );
	add_filter( 'pre_http_request', $gate, PHP_INT_MAX, 3 );
	$reply = infinite_loader_for_woocommerce_licence_request(
		array(
			'edd_action' => 'activate_license',
			'license'    => INFINITE_LOADER_FOR_WOOCOMMERCE_FREE_LICENSE_KEY,
			'item_id'    => INFINITE_LOADER_FOR_WOOCOMMERCE_EDD_ITEM_ID,
		)
	);
	remove_filter( 'pre_http_request', $gate, PHP_INT_MAX );
	remove_filter( 'http_request_args', $cap );

	// A host skipped for lack of time was never tried: do not leave it paused by the SDK for an hour.
	foreach ( array_unique( $skipped ) as $host ) {
		delete_option( 'eddsdk_failed_request_' . md5( $host ) );
	}

	if ( is_object( $reply ) && 'valid' === ( $reply->license ?? '' ) ) {
		// Re-check right before the write: the owner may have saved their own key while the request ran.
		if ( infinite_loader_for_woocommerce_preset_owner_managed() ) {
			return;
		}
		update_option( basename( dirname( INFINITE_LOADER_FOR_WOOCOMMERCE_FILE ) ) . '_license_key', INFINITE_LOADER_FOR_WOOCOMMERCE_FREE_LICENSE_KEY, false );
		update_option( 'infinite_loader_for_woocommerce_preset_activated', 1, false );
		return;
	}

	set_transient( $backoff, 1, $skipped ? 30 * MINUTE_IN_SECONDS : 12 * HOUR_IN_SECONDS );
}
add_action( 'admin_init', 'infinite_loader_for_woocommerce_preset_activation' );
