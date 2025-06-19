<?php
/**
 * Provide a admin area view for the plugin FAQ section
 *
 * This file is used to markup the admin-facing FAQ section of the plugin.
 * All styles have been moved to admin/css/infinite-loader-for-woocommerce-admin.css
 *
 * @link       https://wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    infinite-loader-for-woocommerce
 * @subpackage infinite-loader-for-woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="wbcom-tab-content">      
	<div class="wbcom-faq-admin-setting">
		<div class="wbcom-admin-title-section">
			<h3><?php esc_html_e( 'Frequently Asked Questions', 'infinite-loader-for-woocommerce' ); ?></h3>
			<p class="description">
				<?php esc_html_e( 'Find answers to the most common questions about the Infinite Loader for WooCommerce plugin.', 'infinite-loader-for-woocommerce' ); ?>
			</p>
		</div>

		<div class="wbcom-faq-admin-settings-block">
			<div id="wbcom-faq-settings-section" class="wbcom-faq-table">
				
				<!-- Basic Requirements -->
				<div class="wbcom-faq-section-row">
					<div class="wbcom-faq-admin-row">
						<button class="wbcom-faq-accordion">
							<span class="faq-icon">🛒</span>
							<?php esc_html_e( 'Does this plugin require WooCommerce?', 'infinite-loader-for-woocommerce' ); ?>
						</button>
						<div class="wbcom-faq-panel">
							<p><?php esc_html_e( 'Yes, this plugin requires WooCommerce to be installed and activated.', 'infinite-loader-for-woocommerce' ); ?></p>
							<p><strong><?php esc_html_e( 'Minimum Requirements:', 'infinite-loader-for-woocommerce' ); ?></strong></p>
							<ul>
								<li><?php esc_html_e( 'WordPress 5.0 or higher', 'infinite-loader-for-woocommerce' ); ?></li>
								<li><?php esc_html_e( 'WooCommerce 3.0 or higher', 'infinite-loader-for-woocommerce' ); ?></li>
								<li><?php esc_html_e( 'PHP 7.4 or higher', 'infinite-loader-for-woocommerce' ); ?></li>
							</ul>
						</div>
					</div>
				</div>

				<!-- Setup Instructions -->
				<div class="wbcom-faq-section-row">
					<div class="wbcom-faq-admin-row">
						<button class="wbcom-faq-accordion">
							<span class="faq-icon">⚙️</span>
							<?php esc_html_e( 'What is "Products Loading Type" ?', 'infinite-loader-for-woocommerce' ); ?>
						</button>
						<div class="wbcom-faq-panel">
							<p><?php esc_html_e( 'This setting allows you to choose how products are loaded on your shop page using ajax. You can select from:', 'infinite-loader-for-woocommerce' ); ?></p>
							<ol>
								<li><?php esc_html_e( 'Load More Button: Users click a load more button to load more products.', 'infinite-loader-for-woocommerce' ); ?></li>
								<li><?php esc_html_e( 'Infinite Loading: Products automatically load as users scroll down.', 'infinite-loader-for-woocommerce' ); ?></li>
								<li><?php esc_html_e( 'Pagination: Products are split across multiple pages with navigation controls.', 'infinite-loader-for-woocommerce' ); ?></li>
							</ol>
						</div>
					</div>
				</div>

				<!-- File Types -->
				<div class="wbcom-faq-section-row">
					<div class="wbcom-faq-admin-row">
						<button class="wbcom-faq-accordion">
							<span class="faq-icon">📄</span>
							<?php esc_html_e( 'What does "Prevent URL Update on Page Load" mean?', 'infinite-loader-for-woocommerce' ); ?>
						</button>
						<div class="wbcom-faq-panel">
							<p><?php esc_html_e( 'Enabling this option stops the browser from changing the URL when new products are loaded dynamically. This is useful for maintaining clean URLs and avoiding unnecessary reloads.', 'infinite-loader-for-woocommerce' ); ?></p>
						</div>
					</div>
				</div>

				<!-- Download Functionality -->
				<div class="wbcom-faq-section-row">
					<div class="wbcom-faq-admin-row">
						<button class="wbcom-faq-accordion">
							<span class="faq-icon">⬇️</span>
							<?php esc_html_e( 'How to add custom css?', 'infinite-loader-for-woocommerce' ); ?>
						</button>
						<div class="wbcom-faq-panel">
							<p><?php esc_html_e( 'Follow the below steps to apply custom css to the Load More/Load Previous Buttons :', 'infinite-loader-for-woocommerce' ); ?></p>
							<ol>
								<li><?php esc_html_e( 'Navigate to Plugin Settings > Button Style > Custom CSS Class.', 'infinite-loader-for-woocommerce' ); ?></li>
								<li><?php esc_html_e( 'Add a custom class for the button in the field provided.', 'infinite-loader-for-woocommerce' ); ?></li>
								<li><?php esc_html_e( 'Navigate to Plugin Settings > Javascript/CSS > Custom CSS.', 'infinite-loader-for-woocommerce' ); ?></li>
								<li><?php esc_html_e( 'Add your custom css in the field provided and save the changes.', 'infinite-loader-for-woocommerce' ); ?></li>
							</ol>
							<p><strong><?php esc_html_e( 'Note : Similarly you can add the custom css for the Load Previous Button.', 'infinite-loader-for-woocommerce' ); ?></strong></p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>