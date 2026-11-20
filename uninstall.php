<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Infinite_Loader_For_Woocommerce
 */

// If uninstall not called from WordPress, then exit.
//
// Core only includes this file from a capability-checked delete (single Delete
// link, AJAX delete or bulk delete), so no nonce or request check belongs here:
// core's AJAX delete sends its nonce as _ajax_nonce, which a check_admin_referer()
// gate rejects, leaving the plugin installed or its options orphaned.
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

/**
 * Remove every option, transient and cron event this plugin writes, for the current site.
 *
 * @return void
 */
function infinite_loader_for_woocommerce_uninstall_site() {
	// Settings (written by the activator and the settings screens).
	delete_option( 'infinite_loader_admin_general_option' );
	delete_option( 'infinite_loader_admin_button_option' );
	delete_option( 'infinite_loader_admin_previous_button_option' );
	delete_option( 'infinite_loader_admin_css_js_option' );

	// Licence: the SDK keys these by the plugin folder name.
	delete_option( 'infinite-loader-for-woocommerce_license_key' );
	delete_option( 'infinite-loader-for-woocommerce_license' );
	delete_option( 'infinite-loader-for-woocommerce_license_key_allow_tracking' );
	// Legacy hand-rolled licence options (removed in 1.3.5).
	delete_option( 'edd_wbcom_infinite_loader_license_key' );
	delete_option( 'edd_wbcom_infinite_loader_license_status' );

	// Preset free-licence activation.
	delete_option( 'infinite_loader_for_woocommerce_preset_activated' );
	delete_option( 'infinite_loader_for_woocommerce_preset_owner_managed' );

	// Transients.
	delete_transient( 'infinite_loader_activation_redirect' );
	delete_transient( 'infinite_loader_for_woocommerce_preset_activation_backoff' );
	delete_transient( 'edd_wbcom_infinite_loader_license_key_data' );

	// SDK weekly licence check, if it was ever scheduled.
	wp_clear_scheduled_hook( 'edd_sl_sdk_weekly_license_check_infinite-loader-for-woocommerce' );
}

if ( is_multisite() ) {
	foreach ( get_sites(
		array(
			'fields' => 'ids',
			'number' => 0,
		)
	) as $infinite_loader_blog_id ) {
		switch_to_blog( $infinite_loader_blog_id );
		infinite_loader_for_woocommerce_uninstall_site();
		restore_current_blog();
	}
} else {
	infinite_loader_for_woocommerce_uninstall_site();
}
