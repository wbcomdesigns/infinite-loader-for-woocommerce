<?php
/**
 * Class to add reviews shortcode.
 *
 * @since    1.0.0
 * @author   Wbcom Designs
 * @package  BuddyPress_Member_Reviews
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wbcom_Paid_Plugin_Settings' ) ) {

	/**
	 * Class to serve AJAX Calls.
	 *
	 * @author   Wbcom Designs
	 * @since    1.0.0
	 */
	class Wbcom_Paid_Plugin_Settings {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'wbcom_admin_license_page' ), 999 );
			add_action( 'wbcom_add_header_menu', array( $this, 'wbcom_add_header_license_menu' ) );
		}

		/**
		 * Add license page to admin menu.
		 *
		 * @return void
		 */
		public function wbcom_admin_license_page() {
			add_submenu_page(
				'wbcomplugins',
				esc_html__( 'License', 'infinite-loader-for-woocommerce' ),
				esc_html__( 'License', 'infinite-loader-for-woocommerce' ),
				'manage_options',
				'wbcom-license-page',
				array( $this, 'wbcom_license_submenu_page_callback' )
			);
		}

		/**
		 * License submenu page callback.
		 *
		 * @return void
		 */
		public function wbcom_license_submenu_page_callback() {
			include 'templates/wbcom-license-page.php';
		}

		/**
		 * Add header license menu item.
		 *
		 * @return void
		 */
		public function wbcom_add_header_license_menu() {
			$license_page_active = 'wbcom-license-page' === filter_input( INPUT_GET, 'page' ) ? 'is_active' : '';
			?>
			<li class="wb_admin_nav_item <?php echo esc_attr( $license_page_active ); ?>">
				<a href="<?php echo esc_url( get_admin_url() ) . 'admin.php?page=wbcom-license-page'; ?>" id="wb_admin_nav_trigger_support">
					<svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M20 22H4C3.44772 22 3 21.5523 3 21V3C3 2.44772 3.44772 2 4 2H20C20.5523 2 21 2.44772 21 3V21C21 21.5523 20.5523 22 20 22ZM19 20V4H5V20H19ZM7 6H11V10H7V6ZM7 12H17V14H7V12ZM7 16H17V18H7V16ZM13 7H17V9H13V7Z"></path></svg>
					<h4><?php esc_html_e( 'License', 'infinite-loader-for-woocommerce' ); ?></h4>
				</a>
			</li>
			<?php
		}
	}

	// Instantiate the Wbcom Paid Plugin Settings.
	new Wbcom_Paid_Plugin_Settings();
}
