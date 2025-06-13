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
 * Plugin URI:        https://wbcomdesigns.com/
 * Description:       Streamline product browsing with AJAX-powered infinite scroll or a "Load More" button. Enhance user experience, reduce page loads, and keep customers engaged on your WooCommerce store.
 * Version:           1.2.2
 * Author:            Wbcom Designs
 * Author URI:        https://wbcomdesigns.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       infinite-loader-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'INFINITE_LOADER_FOR_WOOCOMMERCE_VERSION', '1.2.2' );

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

if ( ! function_exists( 'infinite_loader_for_woocommerce_check_woocommerce' ) ) {

	add_action( 'admin_init', 'infinite_loader_for_woocommerce_check_woocommerce' );

	/**
	 * Function check for woocommerce is installed and activate.
	 *
	 * @since    1.0.0
	 */
	function infinite_loader_for_woocommerce_check_woocommerce() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			add_action( 'admin_notices', 'infinite_loader_for_woocommerce_admin_notice' );
		} else {
			run_infinite_loader_for_woocommerce();
		}

	}
}

if ( ! function_exists( 'infinite_loader_for_woocommerce_admin_notice' ) ) {

	/**
	 * Admin notice if WooCommerce not found.
	 *
	 * @since    1.0.0
	 */
	function infinite_loader_for_woocommerce_admin_notice() {

		$infinite_loader_plugin = esc_html__( 'Infinite Loader for WooCommerce', 'infinite-loader-for-woocommerce' );
		$woo_plugin             = esc_html__( 'WooCommerce', 'infinite-loader-for-woocommerce' );
		$action                 = 'install-plugin';
		$slug                   = 'woocommerce';
		$plugin_install_link    = '<a href="' . wp_nonce_url(
			add_query_arg(
				array(
					'action' => $action,
					'plugin' => $slug,
				),
				admin_url( 'update.php' )
			),
			$action . '_' . $slug
		) . '">' . $woo_plugin . '</a>';
		echo '<div class="error"><p>';
		/* Translators: %1$s: Cart Notice for WooCommerce, %2$s: WooCommerce   */
		echo sprintf( esc_html__( '%1$s is ineffective now as it requires %2$s to be installed and active.', 'infinite-loader-for-woocommerce' ), '<strong>' . esc_html( $infinite_loader_plugin ) . '</strong>', '<strong>' . wp_kses_post( $plugin_install_link ) . '</strong>' );
		echo '</p></div>';
		if ( null !== filter_input( INPUT_GET, 'activate' ) ) {
			$activate = filter_input( INPUT_GET, 'activate' );
			unset( $activate );
		}
	}
}

/**
 * Redirect to plugin settings page after activated.
 *
 * @param string $plugin Contains the plugin path.
 */
function infinite_loader_plugin_redirect_to_welcome_page( $plugin ) {

	if ( plugin_basename( __FILE__ ) === $plugin && class_exists( 'WooCommerce' ) ) {
		if ( isset( $_REQUEST['action'] ) && $_REQUEST['action']  == 'activate' && isset( $_REQUEST['plugin'] ) && $_REQUEST['plugin'] == $plugin) {//phpcs:ignore
			wp_safe_redirect( admin_url( 'admin.php?page=infinite-loader-for-woocommerce-settings' ) );
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
	$plugin = new Infinite_Loader_For_Woocommerce();
	$plugin->run();

}
run_infinite_loader_for_woocommerce();
require plugin_dir_path( __FILE__ ) . 'wc-infinite-loader-update-checker/wc-infinite-loader-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;
$my_update_checker = PucFactory::buildUpdateChecker(
	'https://demos.wbcomdesigns.com/exporter/free-plugins/infinite-loader-for-woocommerce.json',
	__FILE__, // Full path to the main plugin file or functions.php.
	'infinite-loader-for-woocommerce'
);
