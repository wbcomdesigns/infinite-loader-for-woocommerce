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

$infinite_loader_css_js_setting       = get_option( 'infinite_loader_admin_css_js_option' );
$infinite_loader_custom_css           = isset( $infinite_loader_css_js_setting['custom_css'] ) ? $infinite_loader_css_js_setting['custom_css'] : '';
$infinite_loader_before_update        = isset( $infinite_loader_css_js_setting['before_update'] ) ? $infinite_loader_css_js_setting['before_update'] : '';
$infinite_loader_after_update         = isset( $infinite_loader_css_js_setting['after_update'] ) ? $infinite_loader_css_js_setting['after_update'] : '';
$custom_css_value                     = '';
$before_update_value                  = '';
$after_update_value                   = '';
if ( ! empty( $infinite_loader_custom_css ) ) {
	$custom_css_value = $infinite_loader_custom_css;
}
if ( ! empty( $infinite_loader_before_update ) ) {
	$before_update_value = $infinite_loader_before_update;
}
if ( ! empty( $infinite_loader_after_update ) ) {
	$after_update_value = $infinite_loader_after_update;
}
?>
<div class="wbcom-tab-content">
	<div class="wbcom-welcome-main-wrapper">
		<div class="wbcom-admin-title-section">
			<h3><?php esc_html_e( 'Custom CSS and Javascript Settings', 'infinite-loader-for-woocommerce' ); ?></h3>
		</div><!-- .wbcom-welcome-head -->
		<div class="wbcom-admin-option-wrap wbcom-admin-option-wrap-view">
			<form method="post" action="options.php">
				<?php
				settings_fields( 'infinite_loader_admin_css_js_options' );
				do_settings_sections( 'infinite_loader_admin_css_js_options' );
				?>
				<div class="form-table">
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Custom CSS', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Add your custom CSS styles to customize the button appearance.', 'infinite-loader-for-woocommerce' ); ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<?php echo '<textarea name="infinite_loader_admin_css_js_option[custom_css]" id="infinite-loader-css-js-area">' . esc_textarea( $custom_css_value ) . '</textarea>'; ?>
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'JavaScript Before Update', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Add custom JavaScript code that will run before the page updates.', 'infinite-loader-for-woocommerce' ); ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<?php echo '<textarea name="infinite_loader_admin_css_js_option[before_update]" id="infinite-loader-css-js-area">' . esc_textarea( $before_update_value ) . '</textarea>'; ?>
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'JavaScript After Update', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Add custom JavaScript code that will run after the page updates.', 'infinite-loader-for-woocommerce' ); ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<?php echo '<textarea name="infinite_loader_admin_css_js_option[after_update]" id="infinite-loader-css-js-area">' . esc_textarea( $after_update_value ) . '</textarea>'; ?>
						</div>
					</div>
				</div>
				<?php submit_button(); ?>
			</form>
		</div>
	</div>
</div>
