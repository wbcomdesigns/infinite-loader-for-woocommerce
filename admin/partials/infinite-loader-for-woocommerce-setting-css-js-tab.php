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

$infinite_loader_css_js_setting = get_option( 'infinite_loader_admin_css_js_option' );

$infinite_loader_font_awesome_version = isset( $infinite_loader_css_js_setting['font_awesome_version'] ) ? $infinite_loader_css_js_setting['font_awesome_version'] : '';
?>
<div class="wbcom-tab-content">
	<form method="post" action="options.php">
		<?php
		settings_fields( 'infinite_loader_admin_css_js_options' );
		do_settings_sections( 'infinite_loader_admin_css_js_options' );
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Disable Font Awesome', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="checkbox" name="infinite_loader_admin_css_js_option[disable_font_awesome]"  value="yes" <?php ( isset( $infinite_loader_css_js_setting['disable_font_awesome'] ) ) ? checked( $infinite_loader_css_js_setting['disable_font_awesome'], 'yes' ) : ''; ?>>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="infinity-loader-shop-tab">
							<?php esc_html_e( 'Font Awesome Version', 'infinite-loader-for-woocommerce' ); ?>
						</label>
					</th>
					<td>
						<label class="infinity-loader-switch">
							<select id="infinity-loader-loading-type" name="infinite_loader_admin_css_js_option[font_awesome_version]">
								<option value="fontawesome4" <?php selected( $infinite_loader_font_awesome_version, 'fontawesome5' ); ?>><?php esc_html_e( 'Font Awesome 4', 'infinite-loader-for-woocommerce' ); ?></option>
								<option value="fontawesome5" <?php selected( $infinite_loader_font_awesome_version, 'fontawesome5' ); ?>><?php esc_html_e( 'Font Awesome 5', 'infinite-loader-for-woocommerce' ); ?></option>
							</select>
							<div class="infinity-loader-slider bupr-round"></div>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Custom CSS ', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<?php echo '<textarea name="infinite_loader_admin_css_js_option[custom_css]" id="infinite-loader-css-js-area">' . esc_textarea( 'value=" ' . ( isset( $infinite_loader_css_js_setting['custom_css'] ) ) ? $infinite_loader_css_js_setting['custom_css'] : '' . ' " ' ) . '</textarea>'; ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Before Update ', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<?php echo '<textarea name="infinite_loader_admin_css_js_option[before_update]" id="infinite-loader-css-js-area">' . esc_textarea( 'value=" ' . ( isset( $infinite_loader_css_js_setting['before_update'] ) ) ? $infinite_loader_css_js_setting['before_update'] : '' . ' " ' ) . '</textarea>'; ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'After Update ', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<?php echo '<textarea name="infinite_loader_admin_css_js_option[after_update]" id="infinite-loader-css-js-area">' . esc_textarea( 'value=" ' . ( isset( $infinite_loader_css_js_setting['after_update'] ) ) ? $infinite_loader_css_js_setting['after_update'] : '' . ' " ' ) . '</textarea>'; ?>
					</td>
				</tr>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
</div>


