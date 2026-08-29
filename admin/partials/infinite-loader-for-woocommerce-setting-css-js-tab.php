<?php
/**
 * Provide a admin javascript/css tab view for the plugin.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/admin/partials
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$infinite_loader_css_js_setting = get_option( 'infinite_loader_admin_css_js_option', array() );
$custom_css_value               = isset( $infinite_loader_css_js_setting['custom_css'] ) ? $infinite_loader_css_js_setting['custom_css'] : '';
$before_update_value            = isset( $infinite_loader_css_js_setting['before_update'] ) ? $infinite_loader_css_js_setting['before_update'] : '';
$after_update_value             = isset( $infinite_loader_css_js_setting['after_update'] ) ? $infinite_loader_css_js_setting['after_update'] : '';
?>
<form method="post" action="options.php">
	<?php
	settings_fields( 'infinite_loader_admin_css_js_options' );
	Wbcom_Settings_Page::card_open( __( 'Custom CSS and JavaScript', 'infinite-loader-for-woocommerce' ) );
	?>
	<div class="wbcom-field">
		<label for="infinite-loader-custom-css"><?php esc_html_e( 'Custom CSS', 'infinite-loader-for-woocommerce' ); ?></label>
		<p class="description"><?php esc_html_e( 'Add your custom CSS styles to customize the button appearance.', 'infinite-loader-for-woocommerce' ); ?></p>
		<textarea class="wbcom-textarea infinite-loader-code-area" name="infinite_loader_admin_css_js_option[custom_css]" id="infinite-loader-custom-css"><?php echo esc_textarea( $custom_css_value ); ?></textarea>
	</div>
	<div class="wbcom-field">
		<label for="infinite-loader-before-update"><?php esc_html_e( 'JavaScript Before Update', 'infinite-loader-for-woocommerce' ); ?></label>
		<p class="description"><?php esc_html_e( 'Add custom JavaScript code that will run before the page updates.', 'infinite-loader-for-woocommerce' ); ?></p>
		<textarea class="wbcom-textarea infinite-loader-code-area" name="infinite_loader_admin_css_js_option[before_update]" id="infinite-loader-before-update"><?php echo esc_textarea( $before_update_value ); ?></textarea>
	</div>
	<div class="wbcom-field">
		<label for="infinite-loader-after-update"><?php esc_html_e( 'JavaScript After Update', 'infinite-loader-for-woocommerce' ); ?></label>
		<p class="description"><?php esc_html_e( 'Add custom JavaScript code that will run after the page updates.', 'infinite-loader-for-woocommerce' ); ?></p>
		<textarea class="wbcom-textarea infinite-loader-code-area" name="infinite_loader_admin_css_js_option[after_update]" id="infinite-loader-after-update"><?php echo esc_textarea( $after_update_value ); ?></textarea>
	</div>
	<?php
	Wbcom_Settings_Page::card_close();
	submit_button();
	?>
</form>
