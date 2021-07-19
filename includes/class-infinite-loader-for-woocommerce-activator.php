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

		$infinite_loader_set_load_more_default_options = array(
			'button_text'                  => 'Load More',
			'background_color'             => '#1d76da',
			'background_color_mouse_hover' => '#0e4da0',
			'border_color'                 => '#1d76da',
			'text_color'                   => '#d6cccc',
			'text_color_mouse_over'        => '#d6cccc',
			'text_font_size'               => '22',
			'padding_top'                  => '18',
			'padding_right'                => '25',
			'padding_bottom'               => '18',
			'padding_left'                 => '25',
		);
		update_option( 'infinite_loader_admin_button_option', $infinite_loader_set_load_more_default_options );

		$infinite_loader_set_load_previous_default_options = array(
			'button_text'                  => 'Load Previous',
			'background_color'             => '#1d76da',
			'background_color_mouse_hover' => '#0e4da0',
			'border_color'                 => '#1d76da',
			'text_color'                   => '#d6cccc',
			'text_color_mouse_over'        => '#d6cccc',
			'text_font_size'               => '22',
			'padding_top'                  => '18',
			'padding_right'                => '25',
			'padding_bottom'               => '18',
			'padding_left'                 => '25',
		);
		update_option( 'infinite_loader_admin_previous_button_option', $infinite_loader_set_load_previous_default_options );
	}

}
