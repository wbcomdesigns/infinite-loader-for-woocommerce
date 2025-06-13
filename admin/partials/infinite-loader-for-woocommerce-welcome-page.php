<?php
/**
 * This file is used for rendering and saving plugin welcome settings.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
	// Exit if accessed directly.
}
?>
<div class="wbcom-tab-content">
	<div class="wbcom-welcome-main-wrapper">
		<div class="wbcom-welcome-head">
			<p class="wbcom-welcome-description"><?php esc_html_e( 'Streamline product browsing with AJAX-powered infinite scroll or a "Load More" button. Enhance user experience, reduce page loads, and keep customers engaged on your WooCommerce store.', 'infinite-loader-for-woocommerce' ); ?></p>
		</div><!-- .wbcom-welcome-head -->
		<div class="wbcom-welcome-content">
			<div class="wbcom-welcome-support-info">
				<h3><?php esc_html_e( 'Help &amp; Support Resources', 'infinite-loader-for-woocommerce' ); ?></h3>
				<p><?php esc_html_e( 'If you need assistance, here are some helpful resources. Our documentation is a great place to start, and our support team is available if you require further help.', 'infinite-loader-for-woocommerce' ); ?></p>
				<div class="wbcom-support-info-wrap">
					<div class="wbcom-support-info-widgets">
						<div class="wbcom-support-inner">
						<h3><span class="dashicons dashicons-book"></span><?php esc_html_e( 'Documentation', 'infinite-loader-for-woocommerce' ); ?></h3>
						<p><?php esc_html_e( 'Explore our detailed guide on Infinite Loader for WooCommerce to understand all the features and how to make the most of them.', 'infinite-loader-for-woocommerce' ); ?></p>
						<a href="<?php echo esc_url( 'https://docs.wbcomdesigns.com/doc_category/infinite-loader-for-woocommerce/' ); ?>" class="button button-primary button-welcome-support" target="_blank"><?php esc_html_e( 'Read Documentation', 'infinite-loader-for-woocommerce' ); ?></a>
						</div>
					</div>

					<div class="wbcom-support-info-widgets">
						<div class="wbcom-support-inner">
						<h3><span class="dashicons dashicons-sos"></span><?php esc_html_e( 'Support Center', 'infinite-loader-for-woocommerce' ); ?></h3>
						<p><?php esc_html_e( 'Our support team is here to assist you with any questions or issues. Feel free to contact us anytime through our support center.', 'infinite-loader-for-woocommerce' ); ?></p>
						<a href="<?php echo esc_url( 'https://wbcomdesigns.com/support/' ); ?>" class="button button-primary button-welcome-support" target="_blank"><?php esc_html_e( 'Get Support', 'infinite-loader-for-woocommerce' ); ?></a>
					</div>
					</div>
					<div class="wbcom-support-info-widgets">
						<div class="wbcom-support-inner">
						<h3><span class="dashicons dashicons-admin-comments"></span><?php esc_html_e( 'Share Your Feedback', 'infinite-loader-for-woocommerce' ); ?></h3>
						<p><?php esc_html_e( 'We’d love to hear about your experience with the plugin. Your feedback and suggestions help us improve future updates.', 'infinite-loader-for-woocommerce' ); ?></p>
						<a href="<?php echo esc_url( 'https://wbcomdesigns.com/submit-review/' ); ?>" class="button button-primary button-welcome-support" target="_blank"><?php esc_html_e( 'Send Feedback', 'infinite-loader-for-woocommerce' ); ?></a>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- .wbcom-welcome-main-wrapper -->
</div><!-- .wbcom-tab-content -->
