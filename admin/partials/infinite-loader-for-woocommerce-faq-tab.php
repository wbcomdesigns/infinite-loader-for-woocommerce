<?php
/**
 * Provide a admin area view for the plugin FAQ section
 *
 * This file is used to markup the admin-facing FAQ section of the plugin.
 *
 * @link       https://wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    infinite-loader-for-woocommerce
 * @subpackage infinite-loader-for-woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

Wbcom_Settings_Page::card_open(
	__( 'Frequently Asked Questions', 'infinite-loader-for-woocommerce' ),
	__( 'Answers to the most common questions about Infinite Loader for WooCommerce.', 'infinite-loader-for-woocommerce' )
);
?>
<details class="wbcom-faq__item">
	<summary><?php esc_html_e( 'Does this plugin require WooCommerce?', 'infinite-loader-for-woocommerce' ); ?></summary>
	<p><?php esc_html_e( 'Yes, this plugin requires WooCommerce to be installed and activated.', 'infinite-loader-for-woocommerce' ); ?></p>
</details>

<details class="wbcom-faq__item">
	<summary><?php esc_html_e( 'What is "Products Loading Type"?', 'infinite-loader-for-woocommerce' ); ?></summary>
	<p><?php esc_html_e( 'This setting lets you choose how products load on your shop page using AJAX. You can select from:', 'infinite-loader-for-woocommerce' ); ?></p>
	<ol>
		<li><?php esc_html_e( 'Load More Button: Users click a load more button to load more products.', 'infinite-loader-for-woocommerce' ); ?></li>
		<li><?php esc_html_e( 'Infinite Loading: Products automatically load as users scroll down.', 'infinite-loader-for-woocommerce' ); ?></li>
		<li><?php esc_html_e( 'Pagination: Products are split across multiple pages with navigation controls.', 'infinite-loader-for-woocommerce' ); ?></li>
	</ol>
</details>

<details class="wbcom-faq__item">
	<summary><?php esc_html_e( 'What does "Keep the address bar unchanged" mean?', 'infinite-loader-for-woocommerce' ); ?></summary>
	<p><?php esc_html_e( 'Enabling this option stops the browser from changing the URL when new products are loaded dynamically. This is useful for maintaining clean URLs and avoiding unnecessary reloads.', 'infinite-loader-for-woocommerce' ); ?></p>
</details>

<details class="wbcom-faq__item">
	<summary><?php esc_html_e( 'How do I add custom CSS?', 'infinite-loader-for-woocommerce' ); ?></summary>
	<p><?php esc_html_e( 'Follow the steps below to apply custom CSS to the Load More / Load Previous buttons:', 'infinite-loader-for-woocommerce' ); ?></p>
	<ol>
		<li><?php esc_html_e( 'Navigate to Plugin Settings > Button Style > Custom CSS Class.', 'infinite-loader-for-woocommerce' ); ?></li>
		<li><?php esc_html_e( 'Add a custom class for the button in the field provided.', 'infinite-loader-for-woocommerce' ); ?></li>
		<li><?php esc_html_e( 'Navigate to Plugin Settings > JavaScript/CSS > Custom CSS.', 'infinite-loader-for-woocommerce' ); ?></li>
		<li><?php esc_html_e( 'Add your custom CSS in the field provided and save the changes.', 'infinite-loader-for-woocommerce' ); ?></li>
	</ol>
	<p><strong><?php esc_html_e( 'Note: You can add custom CSS for the Load Previous button in the same way.', 'infinite-loader-for-woocommerce' ); ?></strong></p>
</details>
<?php
Wbcom_Settings_Page::card_close();
