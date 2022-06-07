<?php
/**
 * Provide a admin genral tab view for the plugin.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/admin/partials
 */

$infinite_loader_genral_setting = get_option( 'infinite_loader_admin_general_option' );

$infinite_loader_selected_icon = isset( $infinite_loader_genral_setting['loading_image'] ) ? esc_attr( $infinite_loader_genral_setting['loading_image'] ) : '';
?>
<div class="wbcom-tab-content">
	<div class="wbcom-welcome-main-wrapper">
		<div class="wbcom-welcome-head">
			<h2 class="wbcom-welcome-title"><?php esc_html_e( 'General Setting', 'infinite-loader-for-woocommerce' ); ?></h2>
		</div><!-- .wbcom-welcome-head -->
	<div class="wbcom-wrapper-section">
	<form method="post" action="options.php">
		<?php
		settings_fields( 'infinite_loader_admin_general_options' );
		do_settings_sections( 'infinite_loader_admin_general_options' );
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="infinity-loader-shop-tab">
							<?php esc_html_e( 'Products Loading Type', 'infinite-loader-for-woocommerce' ); ?>
						</label>
					</th>
					<td>
						<label class="infinity-loader-switch">
							<select id="infinity-loader-loading-type" name="infinite_loader_admin_general_option[product_loading_type]">
								<option value="none" <?php selected( $infinite_loader_genral_setting['product_loading_type'], 'none' ); ?>><?php esc_html_e( 'None', 'infinite-loader-for-woocommerce' ); ?></option>
								<option value="infinity-scroll" <?php selected( $infinite_loader_genral_setting['product_loading_type'], 'infinity-scroll' ); ?>><?php esc_html_e( 'Infinity Scroll', 'infinite-loader-for-woocommerce' ); ?></option>
								<option value="load-more-button" <?php selected( $infinite_loader_genral_setting['product_loading_type'], 'load-more-button' ); ?>><?php esc_html_e( 'Load More Button', 'infinite-loader-for-woocommerce' ); ?></option>
								<option value="pagination" <?php selected( $infinite_loader_genral_setting['product_loading_type'], 'pagination' ); ?>><?php esc_html_e( 'AJAX Pagination', 'infinite-loader-for-woocommerce' ); ?></option>
								<option value="load-more-button-and-ajax-pagination" <?php selected( $infinite_loader_genral_setting['product_loading_type'], 'load-more-button-and-ajax-pagination' ); ?>><?php esc_html_e( 'Load More Button + AJAX Pagination', 'infinite-loader-for-woocommerce' ); ?></option>
							</select>
							<div class="infinity-loader-slider bupr-round"></div>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Products per page', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="number" name="infinite_loader_admin_general_option[product_per_page]" placeholder="<?php esc_html_e( 'Products per page', 'infinite-loader-for-woocommerce' ); ?>" value="<?php echo ( isset( $infinite_loader_genral_setting['product_per_page'] ) ) ? esc_attr( $infinite_loader_genral_setting['product_per_page'] ) : ''; ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Loading Image', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<?php
						echo '<div class="infinite_loader_select_fontawesome">';
						echo Infinite_Loader_For_Woocommerce_Admin::infinite_loader_icon_popup(); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo '<input type="hidden" name="infinite_loader_admin_general_option[loading_image]" value="' . esc_attr( $infinite_loader_selected_icon ) . '" readonly class="infinite_icon_value"/>
        						<span class="infinite_selected_icon"><i class="fa ' . esc_attr( $infinite_loader_selected_icon ) . '"></i></span>
        						<input type="button" class="infinite_select_icon button" value="' . esc_html__( 'Font Awesome', 'infinite-loader-for-woocommerce' ) . '"/> ';
						echo '<input type="button" class="infinite_remove_icon button" value="' . esc_html__( 'Remove', 'infinite-loader-for-woocommerce' ) . '"/>';
						echo '</div>';

						?>
						<label>
							<input type="checkbox" name="infinite_loader_admin_general_option[rotate_image]" value="yes" <?php ( isset( $infinite_loader_genral_setting['rotate_image'] ) ) ? checked( $infinite_loader_genral_setting['rotate_image'], 'yes' ) : ''; ?>>
							<span><?php esc_html_e( 'Rotate image on load', 'infinite-loader-for-woocommerce' ); ?></span>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Buffer Pixels', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="number" name="infinite_loader_admin_general_option[buffer_pixels]" placeholder="<?php esc_html_e( 'Buffer Pixels', 'infinite-loader-for-woocommerce' ); ?>" value="<?php echo ( isset( $infinite_loader_genral_setting['buffer_pixels'] ) ) ? esc_attr( $infinite_loader_genral_setting['buffer_pixels'] ) : ''; ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( "Don't update url when next page shown", 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="checkbox" name="infinite_loader_admin_general_option[do_not_update_url]" value="yes" <?php ( isset( $infinite_loader_genral_setting['do_not_update_url'] ) ) ? checked( $infinite_loader_genral_setting['do_not_update_url'], 'yes' ) : ''; ?>>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'JavaScript and CSS is used on WooCommerce pages only', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="checkbox" name="infinite_loader_admin_general_option[js_css_use_use_wc_page]" value="yes" <?php ( isset( $infinite_loader_genral_setting['js_css_use_use_wc_page'] ) ) ? checked( $infinite_loader_genral_setting['js_css_use_use_wc_page'], 'yes' ) : ''; ?>>
					</td>
				</tr>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
</div>
</div>
