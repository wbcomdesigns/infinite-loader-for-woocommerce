<?php
/**
 * Provide a admin selectors tab view for the plugin.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/admin/partials
 */

$infinite_loader_selectors_setting = get_option( 'infinite_loader_admin_selectors_option' );
?>
<div class="wbcom-tab-content">
	<div class="wbcom-welcome-main-wrapper">
		<div class="wbcom-welcome-head">
			<h2 class="wbcom-welcome-title"><?php esc_html_e( 'Button Style', 'infinite-loader-for-woocommerce' ); ?></h2>
		</div><!-- .wbcom-welcome-head -->
	<div class="wbcom-wrapper-section">	
	<form method="post" action="options.php">
		<?php
		settings_fields( 'infinite_loader_admin_selectors_options' );
		do_settings_sections( 'infinite_loader_admin_selectors_options' );
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Products Container Selector', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="text" name="infinite_loader_admin_selectors_option[product_container]"  value="<?php echo ( isset( $infinite_loader_selectors_setting['product_container'] ) ) ? esc_attr( $infinite_loader_selectors_setting['product_container'] ) : 'ul.products'; ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Product Item Selector', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="text" name="infinite_loader_admin_selectors_option[product_item]" value="<?php echo ( isset( $infinite_loader_selectors_setting['product_item'] ) ) ? esc_attr( $infinite_loader_selectors_setting['product_item'] ) : 'li.product'; ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Pagination Selector', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="text" name="infinite_loader_admin_selectors_option[pagination]" value="<?php echo ( isset( $infinite_loader_selectors_setting['pagination'] ) ) ? esc_attr( $infinite_loader_selectors_setting['pagination'] ) : 'nav.woocommerce-pagination'; ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Next Page Selector', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="text" name="infinite_loader_admin_selectors_option[next_page]" value="<?php echo ( isset( $infinite_loader_selectors_setting['next_page'] ) ) ? esc_attr( $infinite_loader_selectors_setting['next_page'] ) : 'a.next.page-numbers'; ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="blogname"><?php esc_html_e( 'Previous Page Selector', 'infinite-loader-for-woocommerce' ); ?></label></th>
					<td>
						<input type="text" name="infinite_loader_admin_selectors_option[previous_page]" value="<?php echo ( isset( $infinite_loader_selectors_setting['previous_page'] ) ) ? esc_attr( $infinite_loader_selectors_setting['previous_page'] ) : 'a.prev.page-numbers'; ?>">
					</td>
				</tr>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
</div>
</div>

