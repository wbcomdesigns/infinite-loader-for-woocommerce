<?php
/**
 * Provide a admin button style tab view for the plugin.
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
	<div class="wbcom-welcome-main-wrapper">
		<div class="wbcom-admin-title-section">
			<h3><?php esc_html_e( 'Button Style Settings', 'infinite-loader-for-woocommerce' ); ?></h3>
		</div><!-- .wbcom-welcome-head -->
		<div class="wbcom-admin-option-wrap wbcom-admin-option-wrap-view">
			<form method="post" action="options.php">
				<?php
				settings_fields( 'infinite_loader_admin_button_options' );
				do_settings_sections( 'infinite_loader_admin_button_options' );
				?>
				<div class="form-table">
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Custom CSS Class', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Add a custom CSS class to apply additional styling to the Load More button.', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="text" class="infinite_loader_btn_settings" data-style="custom_css" id="infinite_loader_default_custom_class" name="infinite_loader_admin_button_option[custom_class]"  value="<?php echo ( isset( $infinite_loader_button_setting['custom_class'] ) ) ? esc_attr( $infinite_loader_button_setting['custom_class'] ) : ''; ?>">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Preview', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Preview how the Load More button will appear with your current settings.', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<div class='infinite-loader-btn-preview-td'>
								<div class='infinite-loader-btn-preview-block'><?php echo Infinite_Loader_For_Woocommerce_Admin::infinite_loader_for_woocommerce_display_load_more_button(); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
							</div>					
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Load More Button Text', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Enter the text to display on the Load More button (e.g., “Load More”, “View More”).', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="text" class="infinite_loader_btn_settings" data-default="Load More" data-style="text"  id="infinite_loader_default_load_more_botton_text" name="infinite_loader_admin_button_option[button_text]"  placeholder="<?php esc_html_e( 'Load More', 'infinite-loader-for-woocommerce' ); ?>" value="<?php echo ( isset( $infinite_loader_button_setting['button_text'] ) ) ? esc_attr( $infinite_loader_button_setting['button_text'] ) : 'Load More'; ?>">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Background Color', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Select the background color of the Load More button.', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="color" id="infinite_loader_default_bg_color" class="bg_btn_color" data-default="#1d76da" name="infinite_loader_admin_button_option[background_color]" value="<?php echo ( isset( $infinite_loader_button_setting['background_color'] ) ) ? esc_attr( $infinite_loader_button_setting['background_color'] ) : ''; ?>">
							<input type="button" id="infinite-loader-default-color" value="Default" class="button">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Hover Background Color', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Choose the background color that appears when hovering over the button.', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="color" id="infinite_loader_default_bg_color_mouse_hover" class="bg_btn_color_hover" name="infinite_loader_admin_button_option[background_color_mouse_hover]" value="<?php echo ( isset( $infinite_loader_button_setting['background_color_mouse_hover'] ) ) ? esc_attr( $infinite_loader_button_setting['background_color_mouse_hover'] ) : ''; ?>">
							<input type="button" value="Default" class="button" id="infinite-loader-default-bg-color-mouse-hover">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Border Color', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Set the border color of the Load More button.', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="color" class="btn_border_color" data-default="#000" data-color="#000" id="infinite_loader_default_border_color" name="infinite_loader_admin_button_option[border_color]" value="<?php echo ( isset( $infinite_loader_button_setting['border_color'] ) ) ? esc_attr( $infinite_loader_button_setting['border_color'] ) : ''; ?>">
							<input type="button" value="Default" class="button" id="infinite-loader-default-border-color">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Text Color', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Choose the text color for the Load More button.', 'infinite-loader-for-woocommerce' ) ?></p>

						</div>
						<div class="wbcom-settings-section-options">
							<input type="color" id="infinite_loader_default_text_color" class="txt_btn_color" name="infinite_loader_admin_button_option[text_color]" value="<?php echo ( isset( $infinite_loader_button_setting['text_color'] ) ) ? esc_attr( $infinite_loader_button_setting['text_color'] ) : '#fff'; ?>">
							<input type="button" value="Default" class="button" id="infinite-loader-default-text-color">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Hover Text Color', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Set the text color when the button is hovered over.', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="color" id="infinite_loader_default_text_color_mouse_hover" class="txt_btn_color_hover" name="infinite_loader_admin_button_option[text_color_mouse_hover]" value="<?php echo ( isset( $infinite_loader_button_setting['text_color_mouse_hover'] ) ) ? esc_attr( $infinite_loader_button_setting['text_color_mouse_hover'] ) : ''; ?>">
							<input type="button" value="Default" class="button" id="infinite-loader-default-text-color-mouse-hover">	
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Font Size', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Define the font size of the button text (in pixels).', 'infinite-loader-for-woocommerce' ) ?></p>

						</div>
						<div class="wbcom-settings-section-options">
							<input type="number" class="infinite_loader_btn_settings" data-style="font-size" data-type="px" data-default="16"  id="infinite-loader_set-default-font-size" name="infinite_loader_admin_button_option[text_font_size]" value="<?php echo ( isset( $infinite_loader_button_setting['text_font_size'] ) ) ? esc_attr( $infinite_loader_button_setting['text_font_size'] ) : '16'; ?>">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap infinite-loader-padding-input">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Padding', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Set the inner spacing of the button (Top, Right, Bottom, Left in pixels).', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
						<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-style="padding-top" data-type="px" data-default="13" id="infinite-loader_set-default-padding-top"  name="infinite_loader_admin_button_option[padding_top]" value="<?php echo ( isset( $infinite_loader_button_setting['padding_top'] ) ) ? esc_attr( $infinite_loader_button_setting['padding_top'] ) : '13'; ?>">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-style="padding-right" data-type="px" data-default="30"  id="infinite-loader_set-default-padding-right"  name="infinite_loader_admin_button_option[padding_right]" value="<?php echo ( isset( $infinite_loader_button_setting['padding_right'] ) ) ? esc_attr( $infinite_loader_button_setting['padding_right'] ) : '30'; ?>">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-style="padding-bottom" data-type="px" data-default="13" id="infinite-loader_set-default-padding-bottom"  name="infinite_loader_admin_button_option[padding_bottom]" value="<?php echo ( isset( $infinite_loader_button_setting['padding_bottom'] ) ) ? esc_attr( $infinite_loader_button_setting['padding_bottom'] ) : '13'; ?>">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-style="padding-left" data-type="px" data-default="30"  id="infinite-loader_set-default-padding-left"  name="infinite_loader_admin_button_option[padding_left]" value="<?php echo ( isset( $infinite_loader_button_setting['padding_left'] ) ) ? esc_attr( $infinite_loader_button_setting['padding_left'] ) : '30'; ?>">

						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Margin', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Set the outer spacing of the button (Top, Right, Bottom, Left in pixels).', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-style="margin-top" data-type="px" data-default=""  id="infinite-loader_set-default-margin-top" name="infinite_loader_admin_button_option[margin_top]" value="<?php echo ( isset( $infinite_loader_button_setting['margin_top'] ) ) ? esc_attr( $infinite_loader_button_setting['margin_top'] ) : ''; ?>">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-style="margin-right" data-type="px" data-default=""  id="infinite-loader_set-default-margin-right"  name="infinite_loader_admin_button_option[margin_right]" value="<?php echo ( isset( $infinite_loader_button_setting['margin_right'] ) ) ? esc_attr( $infinite_loader_button_setting['margin_right'] ) : ''; ?>">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-style="margin-bottom" data-type="px" data-default="" id="infinite-loader_set-default-margin-bottom"  name="infinite_loader_admin_button_option[margin_bottom]" value="<?php echo ( isset( $infinite_loader_button_setting['margin_bottom'] ) ) ? esc_attr( $infinite_loader_button_setting['margin_bottom'] ) : ''; ?>">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-style="margin-left" data-type="px" data-default=""  id="infinite-loader_set-default-margin-left"  name="infinite_loader_admin_button_option[margin_left]" value="<?php echo ( isset( $infinite_loader_button_setting['margin_left'] ) ) ? esc_attr( $infinite_loader_button_setting['margin_left'] ) : ''; ?>">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Border Width', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Specify the thickness of the button\'s border (in pixels).', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-field="border" data-style="border-top" data-type="px" data-default="1"  id="infinite-loader_set-default-border-top"  name="infinite_loader_admin_button_option[border_top]" value="<?php echo ( isset( $infinite_loader_button_setting['border_top'] ) ) ? esc_attr( $infinite_loader_button_setting['border_top'] ) : '1'; ?>">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-field="border" data-style="border-right" data-type="px" data-default="1"  id="infinite-loader_set-default-border-right"  name="infinite_loader_admin_button_option[border_right]" value="<?php echo ( isset( $infinite_loader_button_setting['border_right'] ) ) ? esc_attr( $infinite_loader_button_setting['border_right'] ) : '1'; ?>">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-field="border" data-style="border-bottom" data-type="px" data-default="1"  id="infinite-loader_set-default-border-bottom"  name="infinite_loader_admin_button_option[border_bottom]" value="<?php echo ( isset( $infinite_loader_button_setting['border_bottom'] ) ) ? esc_attr( $infinite_loader_button_setting['border_bottom'] ) : '1'; ?>">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-field="border" data-style="border-left" data-type="px" data-default="1"  id="infinite-loader_set-default-border-left"  name="infinite_loader_admin_button_option[border_left]" value="<?php echo ( isset( $infinite_loader_button_setting['border_left'] ) ) ? esc_attr( $infinite_loader_button_setting['border_left'] ) : '1'; ?>">
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Button Border Radius', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Adjust the roundness of the button corners (in pixels).', 'infinite-loader-for-woocommerce' ) ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-type="px" data-style="border-top-left-radius"  data-default="50" id="infinite-loader_set-default-border-radius-top"  name="infinite_loader_admin_button_option[border_radius_top]" value="<?php echo ( isset( $infinite_loader_button_setting['border_radius_top'] ) ) ? esc_attr( $infinite_loader_button_setting['border_radius_top'] ) : '50'; ?>">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-type="px" data-style="border-top-right-radius" data-default="50" id="infinite-loader_set-default-border-radius-right" name="infinite_loader_admin_button_option[border_radius_right]" value="<?php echo ( isset( $infinite_loader_button_setting['border_radius_right'] ) ) ? esc_attr( $infinite_loader_button_setting['border_radius_right'] ) : '50'; ?>">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-type="px" data-style="border-bottom-left-radius"  data-default="50" id="infinite-loader_set-default-border-radius-bottom" name="infinite_loader_admin_button_option[border_radius_bottom]" value="<?php echo ( isset( $infinite_loader_button_setting['border_radius_bottom'] ) ) ? esc_attr( $infinite_loader_button_setting['border_radius_bottom'] ) : '50'; ?>">
							<input type="number" class="infinite-loader-style infinite_loader_btn_settings" data-type="px" data-style="border-bottom-right-radius"  data-default="50" id="infinite-loader_set-default-border-radius-left" name="infinite_loader_admin_button_option[border_radius_left]" value="<?php echo ( isset( $infinite_loader_button_setting['border_radius_left'] ) ) ? esc_attr( $infinite_loader_button_setting['border_radius_left'] ) : '50'; ?>">
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
