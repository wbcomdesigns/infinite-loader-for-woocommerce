<div class="wrap">
	<div class="wbcom-bb-plugins-offer-wrapper">
		<div id="wb_admin_logo">
		</div>
	</div>
	<div class="wbcom-wrap wbcom-plugin-wrapper">
		<div class="wbcom_admin_header-wrapper">
			<div id="wb_admin_plugin_name">
				<?php esc_html_e( 'Infinite Loader for WooCommerce', 'infinite-loader-for-woocommerce' ); ?>
				<?php /* translators: %s: */ ?>
				<span><?php printf( esc_html__( 'Version %s', 'infinite-loader-for-woocommerce' ), INFINITE_LOADER_FOR_WOOCOMMERCE_VERSION );//phpcs:ignore ?></span>
			</div>
			<?php echo do_shortcode( '[wbcom_admin_setting_header]' ); ?>
		</div>
		<div class="wbcom-all-addons-plugins-wrap">
		<h4 class="wbcom-support-section"><?php esc_html_e( 'Plugin License', 'infinite-loader-for-woocommerce' ); ?></h4>
		<div class="wb-plugins-license-tables-wrap">
			<div class="wbcom-license-support-wrapp">
			<table class="form-table wb-license-form-table desktop-license-headings">
				<thead>
					<tr>
						<th class="wb-product-th"><?php esc_html_e( 'Product', 'infinite-loader-for-woocommerce' ); ?></th>
						<th class="wb-version-th"><?php esc_html_e( 'Version', 'infinite-loader-for-woocommerce' ); ?></th>
						<th class="wb-key-th"><?php esc_html_e( 'Key', 'infinite-loader-for-woocommerce' ); ?></th>
						<th class="wb-status-th"><?php esc_html_e( 'Status', 'infinite-loader-for-woocommerce' ); ?></th>
						<th class="wb-action-th"><?php esc_html_e( 'Action', 'infinite-loader-for-woocommerce' ); ?></th>
					</tr>
				</thead>
			</table>
			<?php do_action( 'wbcom_add_plugin_license_code' ); ?>
			<table class="form-table wb-license-form-table">
				<tfoot>
					<tr>
						<th class="wb-product-th"><?php esc_html_e( 'Product', 'infinite-loader-for-woocommerce' ); ?></th>
						<th class="wb-version-th"><?php esc_html_e( 'Version', 'infinite-loader-for-woocommerce' ); ?></th>
						<th class="wb-key-th"><?php esc_html_e( 'Key', 'infinite-loader-for-woocommerce' ); ?></th>
						<th class="wb-status-th"><?php esc_html_e( 'Status', 'infinite-loader-for-woocommerce' ); ?></th>
						<th class="wb-action-th"><?php esc_html_e( 'Action', 'infinite-loader-for-woocommerce' ); ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	</div>
	</div><!-- .wbcom-wrap -->
</div><!-- .wrap -->
