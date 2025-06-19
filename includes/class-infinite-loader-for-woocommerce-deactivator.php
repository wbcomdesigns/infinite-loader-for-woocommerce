<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/includes
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/includes
 * @author     WBCOM Designs <admin@wbcomdesigns.com>
 */
class Infinite_Loader_For_Woocommerce_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// Clear any scheduled hooks
		wp_clear_scheduled_hook( 'infinite_loader_daily_cleanup' );
		
		// Clear plugin cache
		wp_cache_delete( 'infinite_loader_admin_general_option' );
		wp_cache_delete( 'infinite_loader_admin_button_option' );
		wp_cache_delete( 'infinite_loader_admin_previous_button_option' );
		wp_cache_delete( 'infinite_loader_admin_css_js_option' );
		
		// Flush rewrite rules
		flush_rewrite_rules();
	}
}