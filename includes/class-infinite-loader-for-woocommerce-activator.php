<?php
/**
 * Fired during plugin activation
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
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/includes
 * @author     WBCOM Designs <admin@wbcomdesigns.com>
 */
class Infinite_Loader_For_Woocommerce_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// Check if WooCommerce is active
		if ( ! class_exists( 'WooCommerce' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( 
				esc_html__( 'Infinite Loader for WooCommerce requires WooCommerce to be installed and activated.', 'infinite-loader-for-woocommerce' ),
				esc_html__( 'Plugin Activation Error', 'infinite-loader-for-woocommerce' ),
				array( 'back_link' => true )
			);
		}

		// Use atomic operations for option creation
   		 $infinite_loader_default_options = self::infinite_loader_get_default_options();

		foreach ( $infinite_loader_default_options as $option_name => $default_values ) {
			$existing_option = get_option( $option_name );
			
			if ( false === $existing_option ) {
				// Option doesn't exist, create it
				add_option( $option_name, $default_values );
			} else {
				// Option exists, merge with defaults for new keys
				$merged_options = array_merge( $default_values, $existing_option );
				update_option( $option_name, $merged_options );
			}
		}

		// Set activation flag for welcome redirect
    	set_transient( 'infinite_loader_activation_redirect', true, 30 );
		
	}

	/**
	 * Get default option values
	 *
	 * @return array Default options
	 */
	private static function infinite_loader_get_default_options() {
		return array(
			'infinite_loader_admin_general_option' => array(
				'product_loading_type' => 'pagination',
				'product_per_page'     => '8',
				'loading_image'        => 'fa-spinner',
				'rotate_image'         => 'yes',
				'do_not_update_url'    => 'no',
				'enable_font_awesome'  => 'yes',
			),
			'infinite_loader_admin_button_option' => array(
				'button_text'                  => 'Load More',
				'background_color'             => '#1d76da',
				'background_color_mouse_hover' => '#0e4da0',
				'border_color'                 => '#1d76da',
				'text_color'                   => '#ffffff',
				'text_color_mouse_hover'       => '#ffffff',
				'text_font_size'               => '16',
				'padding_top'                  => '13',
				'padding_right'                => '30',
				'padding_bottom'               => '13',
				'padding_left'                 => '30',
				'border_radius_top'            => '50',
				'border_radius_right'          => '50',
				'border_radius_bottom'         => '50',
				'border_radius_left'           => '50',
				'border_top'                   => '1',
				'border_right'                 => '1',
				'border_bottom'                => '1',
				'border_left'                  => '1',
			),
			'infinite_loader_admin_previous_button_option' => array(
				'button_text'                  => 'Load Previous',
				'background_color'             => '#1d76da',
				'background_color_mouse_hover' => '#0e4da0',
				'border_color'                 => '#1d76da',
				'text_color'                   => '#ffffff',
				'text_color_mouse_hover'       => '#ffffff',
				'text_font_size'               => '16',
				'padding_top'                  => '13',
				'padding_right'                => '30',
				'padding_bottom'               => '13',
				'padding_left'                 => '30',
				'margin_bottom'                => '20',
				'border_radius_top'            => '50',
				'border_radius_right'          => '50',
				'border_radius_bottom'         => '50',
				'border_radius_left'           => '50',
				'border_top'                   => '1',
				'border_right'                 => '1',
				'border_bottom'                => '1',
				'border_left'                  => '1',
			),
		);
	}
}