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
 * Version:           1.2.2
 * Author:            Wbcom Designs
 * Author URI:        https://wbcomdesigns.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       infinite-loader-for-woocommerce
 * Domain Path:       /languages
 * Requires Plugins: woocommerce
 * Requires at least: 5.0
 * Tested up to:      6.4
 * WC requires at least: 3.0
 * WC tested up to:   8.5
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
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
		
		// Check WooCommerce version
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
			/* translators: 1: Plugin name 2: WooCommerce */
			printf(
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
		// Check nonce for security
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
	$plugin = new Infinite_Loader_For_Woocommerce();
	$plugin->run();
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
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );