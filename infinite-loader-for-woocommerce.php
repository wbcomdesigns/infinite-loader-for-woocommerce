<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wbcomdesigns.com/
 * @since             1.0.0
 * @package           Infinite_Loader_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Wbcom Designs – Infinite Loader for WooCommerce
 * Plugin URI:        https://wbcomdesigns.com/downloads/infinite-loader-for-woocommerce/
 * Description:       Streamline product browsing with AJAX-powered infinite scroll or a "Load More" button. Enhance user experience, reduce page loads, and keep customers engaged on your WooCommerce store.
 * Version:           1.3.5
 * Author:            Wbcom Designs
 * Author URI:        https://wbcomdesigns.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       infinite-loader-for-woocommerce
 * Domain Path:       /languages
 * Requires Plugins: woocommerce
 * Requires at least: 6.5
 * Tested up to:      7.1
 * Requires PHP:      8.1
 * WC requires at least: 3.0
 * WC tested up to:   11.2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'INFINITE_LOADER_FOR_WOOCOMMERCE_VERSION', '1.3.5' );

if ( ! defined( 'INFINITE_LOADER_FOR_WOOCOMMERCE_FILE' ) ) {
	define( 'INFINITE_LOADER_FOR_WOOCOMMERCE_FILE', __FILE__ );
}

if ( ! defined( 'INFINITE_LOADER_FOR_WOOCOMMERCE_PLUGIN_PATH' ) ) {
	define( 'INFINITE_LOADER_FOR_WOOCOMMERCE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'INFINITE_LOADER_FOR_WOOCOMMERCE_PLUGIN_URL' ) ) {
	define( 'INFINITE_LOADER_FOR_WOOCOMMERCE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

/*
 * EDD download id on store.wbcomdesigns.com (verified against the store's
 * get_version response: item_id 1629838 => "Infinite Loader for WooCommerce").
 */
if ( ! defined( 'INFINITE_LOADER_FOR_WOOCOMMERCE_EDD_ITEM_ID' ) ) {
	define( 'INFINITE_LOADER_FOR_WOOCOMMERCE_EDD_ITEM_ID', 1629838 );
}

/*
 * Preset, unlimited-activation licence key for the FREE download. This is how
 * every free, non-wordpress.org Wbcom plugin authorises updates with zero
 * customer setup (see BuddyWoo / Jetonomy). Licence state only authorises
 * update downloads; it never gates any feature.
 *
 * Unlimited-activation, lifetime key for download 1629838, validated against the
 * store (edd_action=check_license => item "Infinite Loader for WooCommerce",
 * expires "lifetime", license_limit 0; activate_license => "valid").
 */
if ( ! defined( 'INFINITE_LOADER_FOR_WOOCOMMERCE_FREE_LICENSE_KEY' ) ) {
	define( 'INFINITE_LOADER_FOR_WOOCOMMERCE_FREE_LICENSE_KEY', '1e7cb1353087c12ff3add1e7f0930351' );
}

/*
 * The shared Wbcom settings shell. Every Wbcom plugin bundles a copy and
 * registers its version; the loader keeps whichever is newest, and that single
 * copy renders the menu for all of them. Guarded so a build that dropped the
 * directory degrades to no settings screen rather than a fatal.
 */
if ( file_exists( INFINITE_LOADER_FOR_WOOCOMMERCE_PLUGIN_PATH . 'lib/wbcom-settings/loader.php' ) ) {
	require_once INFINITE_LOADER_FOR_WOOCOMMERCE_PLUGIN_PATH . 'lib/wbcom-settings/loader.php';
	wbcom_settings_register( '1.0.3', INFINITE_LOADER_FOR_WOOCOMMERCE_PLUGIN_PATH . 'lib/wbcom-settings/class-wbcom-settings-page.php' );
}

// ---------------------------------------------------------------------------
// EDD Software Licensing SDK — automatic updates for this free, self-hosted
// plugin. The old hand-rolled edd-license/ wrapper was removed: its licence
// form was hooked to the deleted wbcom_add_plugin_license_code action and its
// redirect target (wbcom-license-page) no longer existed, so the key could not
// be entered anywhere while a red notice nagged on every admin page. The SDK
// (vendored at libs/edd-sl-sdk, the portfolio's single update mechanism) needs
// no custom screen, and the preset free key below pre-activates it so updates
// work with zero customer setup. Mirrors BuddyWoo / BuddyNext / Jetonomy.
// ---------------------------------------------------------------------------
add_action(
	'edd_sl_sdk_registry',
	static function ( $registry ): void {
		$registry->register(
			array(
				'id'      => 'infinite-loader-for-woocommerce',
				'url'     => 'https://wbcomdesigns.com',
				'item_id' => INFINITE_LOADER_FOR_WOOCOMMERCE_EDD_ITEM_ID,
				'version' => INFINITE_LOADER_FOR_WOOCOMMERCE_VERSION,
				'file'    => INFINITE_LOADER_FOR_WOOCOMMERCE_FILE,
				'license' => INFINITE_LOADER_FOR_WOOCOMMERCE_FREE_LICENSE_KEY,
			)
		);
	}
);

// Load the vendored SDK only when the package is COMPLETE. A partial build that
// keeps the entry file but drops libs/edd-sl-sdk/src or the SDK's own
// vendor/autoload.php (which edd-sl-sdk.php require_once's unconditionally)
// would fatal on load, so guard on all three and degrade to "updates disabled"
// with a soft admin notice instead of a white screen — licensing only gates
// updates, never features.
if ( file_exists( INFINITE_LOADER_FOR_WOOCOMMERCE_PLUGIN_PATH . 'libs/edd-sl-sdk/edd-sl-sdk.php' )
	&& file_exists( INFINITE_LOADER_FOR_WOOCOMMERCE_PLUGIN_PATH . 'libs/edd-sl-sdk/src/Versions.php' )
	&& file_exists( INFINITE_LOADER_FOR_WOOCOMMERCE_PLUGIN_PATH . 'libs/edd-sl-sdk/vendor/autoload.php' ) ) {
	require_once INFINITE_LOADER_FOR_WOOCOMMERCE_PLUGIN_PATH . 'libs/edd-sl-sdk/edd-sl-sdk.php';
} elseif ( is_admin() ) {
	add_action(
		'admin_notices',
		static function () {
			echo '<div class="notice notice-warning"><p>'
				. esc_html__( 'Infinite Loader for WooCommerce: the bundled licensing and update SDK is incomplete, so automatic updates are turned off. Reinstall the plugin from a complete package to restore them. Every other feature works normally.', 'infinite-loader-for-woocommerce' )
				. '</p></div>';
		}
	);
}

// Auto-activate the preset free key once per site so store-authorised downloads
// work without the customer touching anything. Skips entirely until the preset
// key is set. Backs off for 12h after any attempt so an install that cannot
// reach the store never repeats a blocking request on every admin pageview.
add_action(
	'admin_init',
	static function (): void {
		$preset_key = INFINITE_LOADER_FOR_WOOCOMMERCE_FREE_LICENSE_KEY;
		if ( '' === $preset_key ) {
			return;
		}

		// Owner opt-out for air-gapped / privacy-strict installs.
		if ( defined( 'INFINITE_LOADER_FOR_WOOCOMMERCE_NO_LICENSE_PHONE_HOME' ) && INFINITE_LOADER_FOR_WOOCOMMERCE_NO_LICENSE_PHONE_HOME ) {
			return;
		}

		if ( get_option( 'infinite_loader_for_woocommerce_preset_activated' ) ) {
			return;
		}
		if ( get_transient( 'infinite_loader_for_woocommerce_preset_activation_backoff' ) ) {
			return;
		}
		set_transient( 'infinite_loader_for_woocommerce_preset_activation_backoff', 1, 12 * HOUR_IN_SECONDS );

		// Store the key where the SDK reads it.
		update_option( 'infinite-loader-for-woocommerce_license_key', $preset_key, false );

		$response = wp_remote_post(
			'https://wbcomdesigns.com',
			array(
				'timeout' => 5,
				'body'    => array(
					'edd_action' => 'activate_license',
					'license'    => $preset_key,
					'item_id'    => INFINITE_LOADER_FOR_WOOCOMMERCE_EDD_ITEM_ID,
					'url'        => home_url(),
				),
			)
		);

		if ( ! is_wp_error( $response ) ) {
			$body = json_decode( wp_remote_retrieve_body( $response ), true );
			if ( 'valid' === ( $body['license'] ?? '' ) ) {
				update_option( 'infinite_loader_for_woocommerce_preset_activated', 1, false );
			}
		}
	}
);

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-infinite-loader-for-woocommerce-activator.php
 */
function activate_infinite_loader_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-infinite-loader-for-woocommerce-activator.php';
	Infinite_Loader_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-infinite-loader-for-woocommerce-deactivator.php
 */
function deactivate_infinite_loader_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-infinite-loader-for-woocommerce-deactivator.php';
	Infinite_Loader_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_infinite_loader_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_infinite_loader_for_woocommerce' );

/**
 * Check if WooCommerce is active
 */
if ( ! function_exists( 'infinite_loader_for_woocommerce_check_woocommerce' ) ) {

	add_action( 'plugins_loaded', 'infinite_loader_for_woocommerce_check_woocommerce' );

	/**
	 * Function check for woocommerce is installed and activate.
	 *
	 * @since    1.0.0
	 */
	function infinite_loader_for_woocommerce_check_woocommerce() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			add_action( 'admin_notices', 'infinite_loader_for_woocommerce_admin_notice' );
			return;
		}

		// Check WooCommerce version.
		if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0', '<' ) ) {
			add_action( 'admin_notices', 'infinite_loader_for_woocommerce_version_notice' );
			return;
		}

		run_infinite_loader_for_woocommerce();
	}
}

/**
 * Admin notice if WooCommerce not found.
 *
 * @since    1.0.0
 */
function infinite_loader_for_woocommerce_admin_notice() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	$infinite_loader_plugin = esc_html__( 'Infinite Loader for WooCommerce', 'infinite-loader-for-woocommerce' );
	$woo_plugin             = esc_html__( 'WooCommerce', 'infinite-loader-for-woocommerce' );

	$install_url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'install-plugin',
				'plugin' => 'woocommerce',
			),
			admin_url( 'update.php' )
		),
		'install-plugin_woocommerce'
	);

	?>
	<div class="notice notice-error">
		<p>
			<?php
			printf(
				/* translators: 1: Plugin name, 2: WooCommerce. */
				esc_html__( '%1$s requires %2$s to be installed and active.', 'infinite-loader-for-woocommerce' ),
				'<strong>' . esc_html( $infinite_loader_plugin ) . '</strong>',
				'<strong>' . esc_html( $woo_plugin ) . '</strong>'
			);

			if ( current_user_can( 'install_plugins' ) ) {
				echo ' <a href="' . esc_url( $install_url ) . '">' . esc_html__( 'Install WooCommerce', 'infinite-loader-for-woocommerce' ) . '</a>';
			}
			?>
		</p>
	</div>
	<?php
}

/**
 * Admin notice for WooCommerce version.
 *
 * @since    1.0.0
 */
function infinite_loader_for_woocommerce_version_notice() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}
	?>
	<div class="notice notice-error">
		<p>
			<?php
			esc_html_e( 'Infinite Loader for WooCommerce requires WooCommerce 3.0 or higher. Please update WooCommerce.', 'infinite-loader-for-woocommerce' );
			?>
		</p>
	</div>
	<?php
}

/**
 * Redirect to plugin settings page after activated.
 *
 * @param string $plugin Contains the plugin path.
 */
function infinite_loader_plugin_redirect_to_welcome_page( $plugin ) {
	if ( plugin_basename( __FILE__ ) === $plugin && class_exists( 'WooCommerce' ) ) {
		// Check nonce for security.
		$nonce_verified = isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'activate-plugin_' . $plugin );

		$redirect = $nonce_verified &&
					isset( $_REQUEST['action'] ) && 'activate' === $_REQUEST['action'] &&
					isset( $_REQUEST['plugin'] ) && $_REQUEST['plugin'] === $plugin;

		if ( $redirect && ! isset( $_REQUEST['activate-multi'] ) ) {
			wp_safe_redirect(
				add_query_arg(
					array( 'page' => 'infinite-loader-for-woocommerce-settings' ),
					admin_url( 'admin.php' )
				)
			);
			exit;
		}
	}
}
add_action( 'activated_plugin', 'infinite_loader_plugin_redirect_to_welcome_page' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-infinite-loader-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_infinite_loader_for_woocommerce() {
	// The constructor registers every hook directly with WordPress.
	new Infinite_Loader_For_Woocommerce();
}

/**
 * Add plugin action links
 *
 * @param array $links Plugin action links.
 * @return array Modified plugin action links.
 */
function infinite_loader_for_woocommerce_plugin_action_links( $links ) {
	$settings_link = sprintf(
		'<a href="%s">%s</a>',
		esc_url( admin_url( 'admin.php?page=infinite-loader-for-woocommerce-settings' ) ),
		esc_html__( 'Settings', 'infinite-loader-for-woocommerce' )
	);

	array_unshift( $links, $settings_link );

	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'infinite_loader_for_woocommerce_plugin_action_links' );

/**
 * Declare HPOS compatibility
 */
add_action(
	'before_woocommerce_init',
	function () {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}
);