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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$infinite_loader_general_setting = get_option( 'infinite_loader_admin_general_option', array() );

$infinite_loader_selected_icon = isset( $infinite_loader_general_setting['loading_image'] ) ? esc_attr( $infinite_loader_general_setting['loading_image'] ) : '';
$infinite_loader_loading_type  = isset( $infinite_loader_general_setting['product_loading_type'] ) ? $infinite_loader_general_setting['product_loading_type'] : 'load-more-button';
$infinite_loader_per_page      = isset( $infinite_loader_general_setting['product_per_page'] ) ? $infinite_loader_general_setting['product_per_page'] : 8;
$infinite_loader_font_awesome  = isset( $infinite_loader_general_setting['enable_font_awesome'] ) && 'yes' === $infinite_loader_general_setting['enable_font_awesome'];
$infinite_loader_rotate_image  = isset( $infinite_loader_general_setting['rotate_image'] ) && 'yes' === $infinite_loader_general_setting['rotate_image'];
$infinite_loader_keep_url      = isset( $infinite_loader_general_setting['do_not_update_url'] ) && 'yes' === $infinite_loader_general_setting['do_not_update_url'];

/*
 * The loading-image row only applies when Font Awesome is on, so it is hidden
 * until then. The class is what the script toggles.
 */
$infinite_loader_image_row_class = $infinite_loader_font_awesome ? '' : ' is-hidden';
?>
<form method="post" action="options.php">
	<?php
	settings_fields( 'infinite_loader_admin_general_options' );
	Wbcom_Settings_Page::card_open( __( 'General Settings', 'infinite-loader-for-woocommerce' ) );
	?>
	<div class="wbcom-field">
		<label for="infinity-loader-loading-type"><?php esc_html_e( 'Products Loading Type', 'infinite-loader-for-woocommerce' ); ?></label>
		<p class="description" id="infinity-loader-loading-type-desc"><?php esc_html_e( 'How shoppers move through the product list on your shop page.', 'infinite-loader-for-woocommerce' ); ?></p>
		<select id="infinity-loader-loading-type"
				class="wbcom-select infinite-loader-field"
				name="infinite_loader_admin_general_option[product_loading_type]"
				aria-describedby="infinity-loader-loading-type-desc">
			<option value="load-more-button" <?php selected( $infinite_loader_loading_type, 'load-more-button' ); ?>>
				<?php esc_html_e( 'Load More button - shoppers click to see more', 'infinite-loader-for-woocommerce' ); ?>
			</option>
			<option value="infinity-scroll" <?php selected( $infinite_loader_loading_type, 'infinity-scroll' ); ?>>
				<?php esc_html_e( 'Infinite scroll - more products load automatically', 'infinite-loader-for-woocommerce' ); ?>
			</option>
			<option value="pagination" <?php selected( $infinite_loader_loading_type, 'pagination' ); ?>>
				<?php esc_html_e( 'Pagination - numbered pages, no AJAX', 'infinite-loader-for-woocommerce' ); ?>
			</option>
		</select>
	</div>

	<div class="wbcom-field">
		<label for="infinite-loader-product-per-page"><?php esc_html_e( 'Products Per Page', 'infinite-loader-for-woocommerce' ); ?></label>
		<p class="description" id="infinite-loader-product-per-page-desc"><?php esc_html_e( 'How many products load at a time. Between 1 and 100.', 'infinite-loader-for-woocommerce' ); ?></p>
		<input type="number"
				id="infinite-loader-product-per-page"
				class="wbcom-input infinite-loader-field"
				name="infinite_loader_admin_general_option[product_per_page]"
				min="1"
				max="100"
				step="1"
				inputmode="numeric"
				aria-describedby="infinite-loader-product-per-page-desc"
				placeholder="8"
				value="<?php echo esc_attr( $infinite_loader_per_page ); ?>">
	</div>

	<div class="wbcom-field wbcom-field-group">
		<div class="wbcom-field-info">
			<label for="infinite_loader_enable_font_awesome"><?php esc_html_e( 'Enable Font Awesome', 'infinite-loader-for-woocommerce' ); ?></label>
			<p class="description" id="infinite-loader-font-awesome-desc"><?php esc_html_e( 'Loads the bundled Font Awesome icons so you can pick a loading spinner below.', 'infinite-loader-for-woocommerce' ); ?></p>
		</div>
		<div class="wbcom-field-control">
			<label class="wbcom-toggle">
				<input type="checkbox"
						name="infinite_loader_admin_general_option[enable_font_awesome]"
						id="infinite_loader_enable_font_awesome"
						aria-describedby="infinite-loader-font-awesome-desc"
						value="yes" <?php checked( $infinite_loader_font_awesome ); ?>>
				<span class="wbcom-toggle-slider"></span>
			</label>
		</div>
	</div>

	<div class="wbcom-field infinite_loader_image_wrapper<?php echo esc_attr( $infinite_loader_image_row_class ); ?>">
		<label for="infinite-loader-loading-image"><?php esc_html_e( 'Loading Image', 'infinite-loader-for-woocommerce' ); ?></label>
		<p class="description"><?php esc_html_e( 'The icon shown while more products are loading. Pick one, or keep the default spinner.', 'infinite-loader-for-woocommerce' ); ?></p>
		<div class="infinite_loader_select_fontawesome">
			<?php
			echo Infinite_Loader_For_Woocommerce_Admin::infinite_loader_icon_popup(); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
			<span class="infinite_selected_icon" aria-hidden="true"><i class="fa <?php echo esc_attr( $infinite_loader_selected_icon ); ?>"></i></span>
			<span class="infinite-loader-icon-name">
				<?php
				echo '' !== $infinite_loader_selected_icon
					? esc_html( $infinite_loader_selected_icon )
					: esc_html__( 'Default spinner', 'infinite-loader-for-woocommerce' );
				?>
			</span>
			<input type="hidden"
					id="infinite-loader-loading-image"
					name="infinite_loader_admin_general_option[loading_image]"
					value="<?php echo esc_attr( $infinite_loader_selected_icon ); ?>"
					readonly
					class="infinite_icon_value"/>
			<input type="button" class="infinite_select_icon button" value="<?php esc_attr_e( 'Choose icon', 'infinite-loader-for-woocommerce' ); ?>"/>
			<input type="button" class="infinite_default_icon button" value="<?php esc_attr_e( 'Use default', 'infinite-loader-for-woocommerce' ); ?>"/>
		</div>

		<label class="infinite-loader-check" for="infinite-loader-rotate-image">
			<input type="checkbox"
					id="infinite-loader-rotate-image"
					name="infinite_loader_admin_general_option[rotate_image]"
					value="yes" <?php checked( $infinite_loader_rotate_image ); ?>>
			<span><?php esc_html_e( 'Spin the icon while loading', 'infinite-loader-for-woocommerce' ); ?></span>
		</label>
	</div>

	<div class="wbcom-field wbcom-field-group">
		<div class="wbcom-field-info">
			<label for="infinite-loader-do-not-update-url"><?php esc_html_e( 'Keep the address bar unchanged', 'infinite-loader-for-woocommerce' ); ?></label>
			<p class="description" id="infinite-loader-url-desc"><?php esc_html_e( 'By default the address bar follows the shopper as they load more, so the Back button returns them where they were. Turn this on to leave the address bar alone.', 'infinite-loader-for-woocommerce' ); ?></p>
		</div>
		<div class="wbcom-field-control">
			<label class="wbcom-toggle">
				<input type="checkbox"
						id="infinite-loader-do-not-update-url"
						name="infinite_loader_admin_general_option[do_not_update_url]"
						aria-describedby="infinite-loader-url-desc"
						value="yes" <?php checked( $infinite_loader_keep_url ); ?>>
				<span class="wbcom-toggle-slider"></span>
			</label>
		</div>
	</div>
	<?php
	Wbcom_Settings_Page::card_close();
	submit_button();
	?>
</form>
