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
			<h2 class="wbcom-welcome-title"><?php esc_html_e( 'Infinite Loader for Woocommerce', 'infinite-loader-for-woocommerce' ); ?></h2>
			<p class="wbcom-welcome-description"><?php esc_html_e( 'Infinite Loader for Woocommerce Plugin will help to integrate WooCommerce with Buddypress.  You can sell your physical or digital products using WooCommerce on your social community website. This plugin allows you to manage your order directly from your profile page.', 'infinite-loader-for-woocommerce' ); ?></p>
		</div><!-- .wbcom-welcome-head -->

		<div class="wbcom-welcome-content">

			<div class="wbcom-video-link-wrapper">

			</div>

			<div class="wbcom-welcome-support-info">
				<h3><?php esc_html_e( 'Help &amp; Support Resources', 'infinite-loader-for-woocommerce' ); ?></h3>
				<p><?php esc_html_e( 'Here are all the resources you may need to get help from us. Documentation is usually the best place to start. Should you require help anytime, our customer care team is available to assist you at the support center.', 'infinite-loader-for-woocommerce' ); ?></p>
				<hr>

				<div class="three-col">

					<div class="col">
						<h3><span class="dashicons dashicons-book"></span><?php esc_html_e( 'Documentation', 'infinite-loader-for-woocommerce' ); ?></h3>
						<p><?php esc_html_e( 'We have prepared an extensive guide on Infinite Loader for Woocommerce to learn all aspects of the plugin. You will find most of your answers here.', 'infinite-loader-for-woocommerce' ); ?></p>
						<a href="<?php echo esc_url( 'https://wbcomdesigns.com/docs/woo-addons/infinite-loader-for-woocommerce/' ); ?>" class="button button-primary button-welcome-support" target="_blank"><?php esc_html_e( 'Read Documentation', 'infinite-loader-for-woocommerce' ); ?></a>
					</div>

					<div class="col">
						<h3><span class="dashicons dashicons-sos"></span><?php esc_html_e( 'Support Center', 'infinite-loader-for-woocommerce' ); ?></h3>
						<p><?php esc_html_e( 'We strive to offer the best customer care via our support center. Once your theme is activated, you can ask us for help anytime.', 'infinite-loader-for-woocommerce' ); ?></p>
						<a href="<?php echo esc_url( 'https://wbcomdesigns.com/support/' ); ?>" class="button button-primary button-welcome-support" target="_blank"><?php esc_html_e( 'Get Support', 'infinite-loader-for-woocommerce' ); ?></a>
					</div>

					<div class="col">
						<h3><span class="dashicons dashicons-admin-comments"></span><?php esc_html_e( 'Got Feedback?', 'infinite-loader-for-woocommerce' ); ?></h3>
						<p><?php esc_html_e( 'We want to hear about your experience with the plugin. We would also love to hear any suggestions you may for future updates.', 'infinite-loader-for-woocommerce' ); ?></p>
						<a href="<?php echo esc_url( 'https://wbcomdesigns.com/contact/' ); ?>" class="button button-primary button-welcome-support" target="_blank"><?php esc_html_e( 'Send Feedback', 'infinite-loader-for-woocommerce' ); ?></a>
					</div>

				</div>

			</div>
		</div>
	</div><!-- .wbcom-welcome-main-wrapper -->
</div><!-- .wbcom-tab-content -->
