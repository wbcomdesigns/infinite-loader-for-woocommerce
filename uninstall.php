<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Infinite_Loader_For_Woocommerce
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Check user capabilities.
if ( ! current_user_can( 'activate_plugins' ) ) {
	return;
}

// Check if it's the correct plugin.
$infinite_loader_plugin = isset( $_REQUEST['plugin'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['plugin'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$infinite_loader_action = isset( $_REQUEST['action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

if ( 'infinite-loader-for-woocommerce/infinite-loader-for-woocommerce.php' !== $infinite_loader_plugin || 'delete-plugin' !== $infinite_loader_action ) {
	return;
}

// Security check.
check_admin_referer( 'delete-plugin' );

// For Single site.
if ( ! is_multisite() ) {
	// Delete plugin options.
	delete_option( 'infinite_loader_admin_general_option' );
	delete_option( 'infinite_loader_admin_button_option' );
	delete_option( 'infinite_loader_admin_previous_button_option' );
	delete_option( 'infinite_loader_admin_css_js_option' );
	delete_option( 'infinite_loader_license_key' );
	delete_option( 'infinite_loader_license_status' );

	// Delete transients.
	delete_transient( 'infinite_loader_license_data' );

	// Clear any cached data.
	wp_cache_flush();
} else {
	// For Multisite.
	global $wpdb;

	// Get all blog ids.
	$infinite_loader_blog_ids         = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
	$infinite_loader_original_blog_id = get_current_blog_id();

	foreach ( $infinite_loader_blog_ids as $infinite_loader_blog_id ) {
		switch_to_blog( $infinite_loader_blog_id );

		// Delete plugin options.
		delete_option( 'infinite_loader_admin_general_option' );
		delete_option( 'infinite_loader_admin_button_option' );
		delete_option( 'infinite_loader_admin_previous_button_option' );
		delete_option( 'infinite_loader_admin_css_js_option' );
		delete_option( 'infinite_loader_license_key' );
		delete_option( 'infinite_loader_license_status' );

		// Delete transients.
		delete_transient( 'infinite_loader_license_data' );
	}

	switch_to_blog( $infinite_loader_original_blog_id );

	// Clear any cached data.
	wp_cache_flush();
}
