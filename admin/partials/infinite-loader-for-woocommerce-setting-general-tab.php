<?php
/**
 * Provide a admin general tab view for the plugin.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/admin/partials
 */

$infinite_loader_general_setting = get_option( 'infinite_loader_admin_general_option' );

$infinite_loader_selected_icon = isset( $infinite_loader_general_setting['loading_image'] ) ? esc_attr( $infinite_loader_general_setting['loading_image'] ) : '';
?>
<div class="wbcom-tab-content">
	<div class="wbcom-welcome-main-wrapper">
		<div class="wbcom-admin-title-section">
			<h3><?php esc_html_e( 'General Settings', 'infinite-loader-for-woocommerce' ); ?></h3>
		</div><!-- .wbcom-welcome-head -->
		<div class="wbcom-admin-option-wrap wbcom-admin-option-wrap-view">
			<form method="post" action="options.php">
				<?php
				settings_fields( 'infinite_loader_admin_general_options' );
				do_settings_sections( 'infinite_loader_admin_general_options' );
				?>
				<div class="form-table">
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="infinity-loader-shop-tab">
								<?php esc_html_e( 'Products Loading Type', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e('Select how products are displayed and loaded on your shop page.', 'infinite-loader-for-woocommerce'); ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<label class="infinity-loader-switch">
								<select id="infinity-loader-loading-type" name="infinite_loader_admin_general_option[product_loading_type]">
									<option value="infinity-scroll" <?php isset($infinite_loader_general_setting['product_loading_type']) ? selected( $infinite_loader_general_setting['product_loading_type'], 'infinity-scroll' ): ''; ?>><?php esc_html_e( 'Infinity Scroll', 'infinite-loader-for-woocommerce' ); ?></option>
									<option value="load-more-button" <?php isset($infinite_loader_general_setting['product_loading_type']) ? selected( $infinite_loader_general_setting['product_loading_type'], 'load-more-button' ): ''; ?>><?php esc_html_e( 'Load More Button', 'infinite-loader-for-woocommerce' ); ?></option>
									<option value="pagination" <?php isset($infinite_loader_general_setting['product_loading_type']) ? selected( $infinite_loader_general_setting['product_loading_type'], 'pagination' ): ''; ?>><?php esc_html_e( 'Pagination', 'infinite-loader-for-woocommerce' ); ?></option>
								</select>
								<div class="infinity-loader-slider bupr-round"></div>
							</label>
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading"><label for="blogname"><?php esc_html_e( 'Products Per Page', 'infinite-loader-for-woocommerce' ); ?></label>
							<p class="description"><?php esc_html_e('Specify the number of products to display per page.', 'infinite-loader-for-woocommerce'); ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="number" name="infinite_loader_admin_general_option[product_per_page]" placeholder="<?php esc_html_e( 'Products per page', 'infinite-loader-for-woocommerce' ); ?>" value="<?php echo ( isset( $infinite_loader_general_setting['product_per_page'] ) ) ? esc_attr( $infinite_loader_general_setting['product_per_page'] ) : ''; ?>">
						</div>
					</div>
					<?php 
					$infinite_loader_css_js_setting = get_option( 'infinite_loader_admin_css_js_option' );
					$infinite_loader_css_js_enable  = isset( $infinite_loader_css_js_setting['enable_font_awesome'] ) ? $infinite_loader_css_js_setting['enable_font_awesome'] : '';

					$infinite_loading_image_section = '';
					if( ! $infinite_loader_css_js_enable ) {
						$infinite_loading_image_section = 'display :none';
					} ?>
					<div class="wbcom-settings-section-wrap" style="<?php echo esc_attr( $infinite_loading_image_section ); ?>">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Loading Image', 'infinite-loader-for-woocommerce' ); ?>
							</label>
							<p class="description"><?php esc_html_e('Select the loading animation icon that appears while new products are being loaded.', 'infinite-loader-for-woocommerce'); ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<?php
							echo '<div class="infinite_loader_select_fontawesome">';
							echo Infinite_Loader_For_Woocommerce_Admin::infinite_loader_icon_popup(); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							echo '<input type="hidden" name="infinite_loader_admin_general_option[loading_image]" value="' . esc_attr( $infinite_loader_selected_icon ) . '" readonly class="infinite_icon_value"/>
									<span class="infinite_selected_icon"><i class="fa ' . esc_attr( $infinite_loader_selected_icon ) . '"></i></span>
									<input type="button" class="infinite_select_icon button" value="' . esc_html__( 'Font Awesome', 'infinite-loader-for-woocommerce' ) . '"/> ';
							echo '<input type="button" class="infinite_default_icon button" value="' . esc_html__( 'Default', 'infinite-loader-for-woocommerce' ) . '"/>';
							echo '</div>';

							?>
							<label>
								<input type="checkbox" name="infinite_loader_admin_general_option[rotate_image]" value="yes" <?php ( isset( $infinite_loader_general_setting['rotate_image'] ) ) ? checked( $infinite_loader_general_setting['rotate_image'], 'yes' ) : ''; ?>>
								<span><?php esc_html_e( 'Rotate image while loading', 'infinite-loader-for-woocommerce' ); ?></span>
							</label>
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading"><label for="blogname"><?php esc_html_e( "Prevent URL Update on Page Load", 'infinite-loader-for-woocommerce' ); ?></label>
						<p class="description"><?php esc_html_e('Enable this setting to prevent the page URL from changing when new products are loaded.', 'infinite-loader-for-woocommerce'); ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="checkbox" name="infinite_loader_admin_general_option[do_not_update_url]" value="yes" <?php ( isset( $infinite_loader_general_setting['do_not_update_url'] ) ) ? checked( $infinite_loader_general_setting['do_not_update_url'], 'yes' ) : ''; ?>>
						</div>
					</div>
				</div>
				<?php submit_button(); ?>
			</form>
		</div>
	</div>
</div>
