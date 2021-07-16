<?php
/**
 * Provide a admin button setting tab view for the plugin.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/admin/partials
 */

$infinite_loader_button_setting = get_option( 'infinite_loader_admin_button_option' );
?>
<div class="wbcom-tab-content">
	<form method="post" action="options.php">
		<?php
		settings_fields( 'infinite_loader_admin_button_options' );
		do_settings_sections( 'infinite_loader_admin_button_options' );
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Custom Class', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="text" name="infinite_loader_admin_button_option[custom_class]"  value="<?php echo ( isset( $infinite_loader_button_setting['custom_class'] ) ) ? esc_attr( $infinite_loader_button_setting['custom_class'] ) : ''; ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Text on button', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="text" name="infinite_loader_admin_button_option[button_text]"  placeholder="<?php esc_html_e( 'Load More', 'infinite-loader-for-woocommerce' ); ?>" value="<?php echo ( isset( $infinite_loader_button_setting['button_text'] ) ) ? esc_attr( $infinite_loader_button_setting['button_text'] ) : 'Load More'; ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Background color', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="color" name="infinite_loader_admin_button_option[background_color]" value="<?php echo ( isset( $infinite_loader_button_setting['background_color'] ) ) ? esc_attr( $infinite_loader_button_setting['background_color'] ) : '#ff0000'; ?>">
						<input type="button" value="Default" class="infinite_loader_default button">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Background color on mouse over', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="color" name="infinite_loader_admin_button_option[background_color_mouse_hover]" value="<?php echo ( isset( $infinite_loader_button_setting['background_color_mouse_hover'] ) ) ? esc_attr( $infinite_loader_button_setting['background_color_mouse_hover'] ) : '#ff0000'; ?>">
						<input type="button" value="Default" class="infinite_loader_default button">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Border color', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="color" name="infinite_loader_admin_button_option[border_color]" value="<?php echo ( isset( $infinite_loader_button_setting['border_color'] ) ) ? esc_attr( $infinite_loader_button_setting['border_color'] ) : '#ff0000'; ?>">
						<input type="button" value="Default" class="infinite_loader_default button">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Text color', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="color" name="infinite_loader_admin_button_option[text_color]" value="<?php echo ( isset( $infinite_loader_button_setting['text_color'] ) ) ? esc_attr( $infinite_loader_button_setting['text_color'] ) : '#ff0000'; ?>">
						<input type="button" value="Default" class="infinite_loader_default button">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Text color on Mouse over', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="color" name="infinite_loader_admin_button_option[text_color_mouse_over]" value="<?php echo ( isset( $infinite_loader_button_setting['text_color_mouse_over'] ) ) ? esc_attr( $infinite_loader_button_setting['text_color_mouse_over'] ) : '#ff0000'; ?>">
						<input type="button" value="Default" class="infinite_loader_default button">	
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Font Size', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="number" name="infinite_loader_admin_button_option[text_font_size]" value="<?php echo ( isset( $infinite_loader_button_setting['text_font_size'] ) ) ? esc_attr( $infinite_loader_button_setting['text_font_size'] ) : '22'; ?>">
					</td>
				</tr>
				<tr class="infinite-loader-padding-input">
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Paddings', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[padding_top]" value="<?php echo ( isset( $infinite_loader_button_setting['padding_top'] ) ) ? esc_attr( $infinite_loader_button_setting['padding_top'] ) : '22'; ?>">
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[padding_right]" value="<?php echo ( isset( $infinite_loader_button_setting['padding_right'] ) ) ? esc_attr( $infinite_loader_button_setting['padding_right'] ) : '22'; ?>">
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[padding_bottom]" value="<?php echo ( isset( $infinite_loader_button_setting['padding_bottom'] ) ) ? esc_attr( $infinite_loader_button_setting['padding_bottom'] ) : '22'; ?>">
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[padding_left]" value="<?php echo ( isset( $infinite_loader_button_setting['padding_left'] ) ) ? esc_attr( $infinite_loader_button_setting['padding_left'] ) : '22'; ?>">

					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Margin', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[margin_top]" value="<?php echo ( isset( $infinite_loader_button_setting['margin_top'] ) ) ? esc_attr( $infinite_loader_button_setting['margin_top'] ) : '22'; ?>">
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[margin_right]" value="<?php echo ( isset( $infinite_loader_button_setting['margin_right'] ) ) ? esc_attr( $infinite_loader_button_setting['margin_right'] ) : '22'; ?>">
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[margin_bottom]" value="<?php echo ( isset( $infinite_loader_button_setting['margin_bottom'] ) ) ? esc_attr( $infinite_loader_button_setting['margin_bottom'] ) : '22'; ?>">
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[margin_left]" value="<?php echo ( isset( $infinite_loader_button_setting['margin_left'] ) ) ? esc_attr( $infinite_loader_button_setting['margin_left'] ) : '22'; ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Border', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[border_top]" value="<?php echo ( isset( $infinite_loader_button_setting['border_top'] ) ) ? esc_attr( $infinite_loader_button_setting['border_top'] ) : '22'; ?>">
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[border_right]" value="<?php echo ( isset( $infinite_loader_button_setting['border_right'] ) ) ? esc_attr( $infinite_loader_button_setting['border_right'] ) : '22'; ?>">
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[border_bottom]" value="<?php echo ( isset( $infinite_loader_button_setting['border_bottom'] ) ) ? esc_attr( $infinite_loader_button_setting['border_bottom'] ) : '22'; ?>">
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[border_left]" value="<?php echo ( isset( $infinite_loader_button_setting['border_left'] ) ) ? esc_attr( $infinite_loader_button_setting['border_left'] ) : '22'; ?>">
										</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Border radius', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[border_radius_top]" value="<?php echo ( isset( $infinite_loader_button_setting['border_radius_top'] ) ) ? esc_attr( $infinite_loader_button_setting['border_radius_top'] ) : '22'; ?>">
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[border_radius_right]" value="<?php echo ( isset( $infinite_loader_button_setting['border_radius_right'] ) ) ? esc_attr( $infinite_loader_button_setting['border_radius_right'] ) : '22'; ?>">
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[border_radius_bottom]" value="<?php echo ( isset( $infinite_loader_button_setting['border_radius_bottom'] ) ) ? esc_attr( $infinite_loader_button_setting['border_radius_bottom'] ) : '22'; ?>">
						<input type="number" class="infinite-loader-style" name="infinite_loader_admin_button_option[border_radius_left]" value="<?php echo ( isset( $infinite_loader_button_setting['border_radius_left'] ) ) ? esc_attr( $infinite_loader_button_setting['border_radius_left'] ) : '22'; ?>">
										</td>
				</tr>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
</div>


