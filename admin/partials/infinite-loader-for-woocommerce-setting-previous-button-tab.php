<?php
/**
 * Provide a admin previous button style tab view for the plugin.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/admin/partials
 */

$infinite_loader_previous_button_setting = get_option( 'infinite_loader_admin_previous_button_option' );
?>
<div class="wbcom-tab-content">
	<div class="wbcom-welcome-main-wrapper">
		<div class="wbcom-admin-title-section">
			<h3><?php esc_html_e( 'Previous Button Style Settings', 'infinite-loader-for-woocommerce' ); ?></h3>
		</div><!-- .wbcom-welcome-head -->
		<div class="wbcom-admin-option-wrap wbcom-admin-option-wrap-view">
			<form method="post" action="options.php">
				<?php
				settings_fields( 'infinite_loader_admin_previous_button_options' );
				do_settings_sections( 'infinite_loader_admin_previous_button_options' );
				?>
				<div class="form-table">
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Custom CSS Class', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Add a custom CSS class to apply additional styling to the Load Previous button.', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="text" id="infinite_loader_default_custom_class"  class="infinite_loader_btn_settings" data-style="custom_css" name="infinite_loader_admin_previous_button_option[custom_class]"  value="<?php echo ( isset( $infinite_loader_previous_button_setting['custom_class'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['custom_class'] ) : ''; ?>">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Preview', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Preview how the Load Previous button will appear with your current design settings.', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<div class='infinite-loader-btn-preview-td'>
								<div class="infinite-loader-btn-preview-block"><?php echo Infinite_Loader_For_Woocommerce_Admin::infinite_loader_for_woocommerce_display_load_previous_button(); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
							</div>					
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Load Previous Button Text', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Enter the text you want to display on the Load Previous button (e.g., “Load Previous”, “View Earlier Products”).', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="text" id="infinite_loader_default_previous_botton_text" class="infinite_loader_btn_settings" data-default="Load Previous" data-style="text" name="infinite_loader_admin_previous_button_option[button_text]"  placeholder="<?php esc_html_e( 'Load Previous', 'infinite-loader-for-woocommerce' ); ?>" value="<?php echo ( isset( $infinite_loader_previous_button_setting['button_text'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['button_text'] ) : 'Load Previous'; ?>">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Background Color', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Select the background color for the Load Previous button.', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="color" id="infinite_loader_default_bg_color" class="bg_btn_color" data-default="#1d76da" name="infinite_loader_admin_previous_button_option[background_color]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['background_color'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['background_color'] ) : ''; ?>">
							<input type="button" id="infinite-loader-default-color" value="Default" class="button">	
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Hover Background Color', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Choose the background color that appears when hovering over the Load Previous button.', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="color" id="infinite_loader_default_bg_color_mouse_hover" class="bg_btn_color_hover" name="infinite_loader_admin_previous_button_option[background_color_mouse_hover]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['background_color_mouse_hover'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['background_color_mouse_hover'] ) : ''; ?>">
							<input type="button" value="Default" class="button" id="infinite-loader-default-bg-color-mouse-hover">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Border Color', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Set the border color of the Load Previous button.', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="color"  class="btn_border_color" data-default="#000" data-color="#000" id="infinite_loader_default_border_color" name="infinite_loader_admin_previous_button_option[border_color]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['border_color'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['border_color'] ) : ''; ?>">
							<input type="button" value="Default" class="button" id="infinite-loader-default-border-color">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Text Color', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Choose the text color for the Load Previous button.', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="color" id="infinite_loader_default_text_color" class="txt_btn_color" name="infinite_loader_admin_previous_button_option[text_color]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['text_color'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['text_color'] ) : '#fff'; ?>">
							<input type="button" value="Default" class="button" id="infinite-loader-default-text-color">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Hover Text Color', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Define the text color shown when the button is hovered over.', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="color" id="infinite_loader_default_text_color_mouse_hover" class="txt_btn_color_hover" name="infinite_loader_admin_previous_button_option[text_color_mouse_hover]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['text_color_mouse_hover'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['text_color_mouse_hover'] ) : '#000'; ?>">
							<input type="button" value="Default" class="button" id="infinite-loader-default-text-color-mouse-hover">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Font Size', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Set the font size of the Load Previous button text (in pixels).', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="number"  id="infinite-loader_set-default-font-size" class="infinite_loader_btn_settings" data-style="font-size" data-type="px" data-default="16"  name="infinite_loader_admin_previous_button_option[text_font_size]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['text_font_size'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['text_font_size'] ) : '16'; ?>">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap infinite-loader-padding-input">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Padding', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Adjust the internal spacing of the button (Top, Right, Bottom, Left in pixels).', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="number" id="infinite-loader_set-default-padding-top" class="infinite-loader-style infinite_loader_btn_settings" data-style="padding-top" data-type="px" data-default="13" name="infinite_loader_admin_previous_button_option[padding_top]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['padding_top'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['padding_top'] ) : '13'; ?>">
							<input type="number" id="infinite-loader_set-default-padding-right" class="infinite-loader-style infinite_loader_btn_settings" data-style="padding-right" data-type="px" data-default="30" name="infinite_loader_admin_previous_button_option[padding_right]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['padding_right'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['padding_right'] ) : '30'; ?>">
							<input type="number" id="infinite-loader_set-default-padding-bottom" class="infinite-loader-style infinite_loader_btn_settings" data-style="padding-bottom" data-type="px" data-default="13" name="infinite_loader_admin_previous_button_option[padding_bottom]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['padding_bottom'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['padding_bottom'] ) : '13'; ?>">
							<input type="number" id="infinite-loader_set-default-padding-left" class="infinite-loader-style infinite_loader_btn_settings" data-style="padding-left" data-type="px" data-default="30" name="infinite_loader_admin_previous_button_option[padding_left]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['padding_left'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['padding_left'] ) : '30'; ?>">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Margin', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Set the external spacing around the button (Top, Right, Bottom, Left in pixels).', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="number" id="infinite-loader_set-default-margin-top" class="infinite-loader-style infinite_loader_btn_settings" data-style="margin-top" data-type="px" data-default="" name="infinite_loader_admin_previous_button_option[margin_top]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['margin_top'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['margin_top'] ) : ''; ?>">
							<input type="number" id="infinite-loader_set-default-margin-right" class="infinite-loader-style infinite_loader_btn_settings" data-style="margin-right" data-type="px" data-default="" name="infinite_loader_admin_previous_button_option[margin_right]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['margin_right'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['margin_right'] ) : ''; ?>">
							<input type="number" id="infinite-loader_set-default-margin-bottom" class="infinite-loader-style infinite_loader_btn_settings" data-style="margin-bottom" data-type="px" data-default="20" name="infinite_loader_admin_previous_button_option[margin_bottom]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['margin_bottom'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['margin_bottom'] ) : '20'; ?>">
							<input type="number" id="infinite-loader_set-default-margin-left" class="infinite-loader-style infinite_loader_btn_settings" data-style="margin-left" data-type="px" data-default="" name="infinite_loader_admin_previous_button_option[margin_left]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['margin_left'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['margin_left'] ) : ''; ?>">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Border Width', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Specify the width of the button\'s border (in pixels).', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-style="border-top" data-type="px" data-default="1" data-field="border" id="infinite-loader_set-default-border-top"  name="infinite_loader_admin_previous_button_option[border_top]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['border_top'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['border_top'] ) : '1'; ?>">
							<input type="number"  class="infinite-loader-style infinite_loader_btn_settings" data-style="border-right" data-type="px" data-default="1" data-field="border" id="infinite-loader_set-default-border-right" name="infinite_loader_admin_previous_button_option[border_right]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['border_right'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['border_right'] ) : '1'; ?>">
							<input type="number"  class="infinite-loader-style infinite_loader_btn_settings" data-style="border-bottom" data-type="px" data-default="1" data-field="border" id="infinite-loader_set-default-border-bottom" name="infinite_loader_admin_previous_button_option[border_bottom]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['border_bottom'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['border_bottom'] ) : '1'; ?>">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-style="border-left" data-type="px" data-default="1" data-field="border" id="infinite-loader_set-default-border-left" name="infinite_loader_admin_previous_button_option[border_left]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['border_left'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['border_left'] ) : '1'; ?>">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Border Radius', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Adjust the corner roundness of the button (in pixels).
', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="number" id="infinite-loader_set-default-border-radius-top" class="infinite-loader-style infinite_loader_btn_settings" data-type="px" data-style="border-top-left-radius"  data-default="50"  name="infinite_loader_admin_previous_button_option[border_radius_top]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['border_radius_top'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['border_radius_top'] ) : '50'; ?>">
							<input type="number" id="infinite-loader_set-default-border-radius-right" class="infinite-loader-style infinite_loader_btn_settings" data-type="px" data-style="border-top-right-radius"  data-default="50"  name="infinite_loader_admin_previous_button_option[border_radius_right]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['border_radius_right'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['border_radius_right'] ) : '50'; ?>">
							<input type="number" id="infinite-loader_set-default-border-radius-bottom" class="infinite-loader-style infinite_loader_btn_settings" data-type="px" data-style="border-bottom-left-radius"  data-default="50" name="infinite_loader_admin_previous_button_option[border_radius_bottom]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['border_radius_bottom'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['border_radius_bottom'] ) : '50'; ?>">
							<input type="number" id="infinite-loader_set-default-border-radius-left" class="infinite-loader-style infinite_loader_btn_settings" data-type="px" data-style="border-bottom-right-radius"  data-default="50" name="infinite_loader_admin_previous_button_option[border_radius_left]" value="<?php echo ( isset( $infinite_loader_previous_button_setting['border_radius_left'] ) ) ? esc_attr( $infinite_loader_previous_button_setting['border_radius_left'] ) : '50'; ?>">
						</div>
					</div>
					<div class="wbcom-settings-section-options">
						<input type="button" value="Set all to default" class="infinite-loader-set-load-more-options button">
					</div>
				</div>
				<?php submit_button(); ?>
			</form>
		</div>
	</div>
</div>
