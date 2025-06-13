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

		if( empty( get_option('infinite_loader_admin_general_option' ) ) ) {
			$infinite_loader_set_default_general_options = array(
				'product_loading_type'   => 'pagination',
				'product_per_page'       => '8',
				'loading_image'          => 'fa-spinner',
				'rotate_image'           => 'yes',
				'do_not_update_url'      => 'no'
			);
			update_option( 'infinite_loader_admin_general_option', $infinite_loader_set_default_general_options );
		}
		
		if( empty( get_option( 'infinite_loader_admin_button_option' ) ) ) {
			$infinite_loader_set_default_load_more_btn_options = array(
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
			);
			update_option( 'infinite_loader_admin_button_option', $infinite_loader_set_default_load_more_btn_options );
		}
		
		if( empty( get_option( 'infinite_loader_admin_previous_button_option' ) ) ) {
			$infinite_loader_set_default_previous_btn_options = array(
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
			);
			update_option( 'infinite_loader_admin_previous_button_option', $infinite_loader_set_default_previous_btn_options );
		}

	
		if( empty( get_option( 'infinite_loader_admin_css_js_option' ) ) ) { 
			$infinite_loader_set_js_css_option = array(
			'enable_font_awesome' => 'yes',
		);
		update_option( 'infinite_loader_admin_css_js_option', $infinite_loader_set_js_css_option );
		}
		
	}

}
