<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/admin
 * @author     WBCOM Designs <admin@wbcomdesigns.com>
 */
class Infinite_Loader_For_Woocommerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Infinite_Loader_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Infinite_Loader_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/infinite-loader-for-woocommerce-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'infinity-loader-selectize', plugin_dir_url( __FILE__ ) . 'css/selectize.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Infinite_Loader_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Infinite_Loader_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/infinite-loader-for-woocommerce-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'infinity-loader-selectize-min', plugin_dir_url( __FILE__ ) . 'js/selectize.min.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Actions performed on loading admin_menu.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @author   Wbcom Designs
	 */
	public function infinite_loader_for_woocommerce_add_submenu_page_admin_settings() {
		if ( empty( $GLOBALS['admin_page_hooks']['wbcomplugins'] ) ) {
			add_menu_page( esc_html__( 'WB Plugins', 'infinite-loader-for-woocommerce' ), esc_html__( 'WB Plugins', 'infinite-loader-for-woocommerce' ), 'manage_options', 'wbcomplugins', array( $this, 'infinite_loader_for_woocommerce_admin_options_page' ), 'dashicons-lightbulb', 59 );
			add_submenu_page( 'wbcomplugins', esc_html__( 'General', 'infinite-loader-for-woocommerce' ), esc_html__( 'General', 'infinite-loader-for-woocommerce' ), 'manage_options', 'wbcomplugins' );

		}
		add_submenu_page( 'wbcomplugins', esc_html__( 'Infinite Loader for WooCommerce', 'infinite-loader-for-woocommerce' ), esc_html__( 'Infinite Loader for WooCommerce', 'infinite-loader-for-woocommerce' ), 'manage_options', 'infinite-loader-for-woocommerce-settings', array( $this, 'infinite_loader_for_woocommerce_admin_options_page' ) );
	}

	/**
	 * Actions performed to create a submenu page content.
	 *
	 * @since    1.0.0
	 * @access public
	 */
	public function infinite_loader_for_woocommerce_admin_options_page() {
		global $allowedposttags;
		$tab = filter_input( INPUT_GET, 'tab' ) ? filter_input( INPUT_GET, 'tab' ) : 'infinite-loader-for-woocommerce-welcome';
		?>
	<div class="wrap">
		<hr class="wp-header-end">
		<div class="wbcom-wrap">
			<div class="bupr-header">
				<?php echo do_shortcode( '[wbcom_admin_setting_header]' ); ?>
				<h1 class="wbcom-plugin-heading">
					<?php esc_html_e( 'Infinite Loader for WooCommerce Settings', 'infinite-loader-for-woocommerce' ); ?>
				</h1>
			</div>
			<div class="wbcom-admin-settings-page">
				<?php
				settings_errors();
				$this->infinite_loader_for_woocommerce_plugin_settings_tabs();
				settings_fields( $tab );
				do_settings_sections( $tab );
				?>
			</div>
		</div>
	</div>
		<?php
	}

	/**
	 * Actions performed to create tabs on the sub menu page.
	 */
	public function infinite_loader_for_woocommerce_plugin_settings_tabs() {
		$current_tab = filter_input( INPUT_GET, 'tab' ) ? filter_input( INPUT_GET, 'tab' ) : 'infinite-loader-for-woocommerce-welcome';
		// xprofile setup tab.
		echo '<div class="wbcom-tabs-section"><div class="nav-tab-wrapper"><div class="wb-responsive-menu"><span>' . esc_html( 'Menu' ) . '</span><input class="wb-toggle-btn" type="checkbox" id="wb-toggle-btn"><label class="wb-toggle-icon" for="wb-toggle-btn"><span class="wb-icon-bars"></span></label></div><ul>';
		foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab === $tab_key ? 'nav-tab-active' : '';
			echo '<li><a class="nav-tab ' . esc_attr( $active ) . '" id="' . esc_attr( $tab_key ) . '-tab" href="?page=infinite-loader-for-woocommerce-settings' . '&tab=' . esc_attr( $tab_key ) . '">' . esc_attr( $tab_caption ) . '</a></li>';
		}
		echo '</div></ul></div>';
	}

	/**
	 * Actions performed on loading plugin settings
	 *
	 * @since    1.0.9
	 * @access   public
	 * @author   Wbcom Designs
	 */
	public function infinite_loader_for_woocommerce_init_plugin_settings() {

		$this->plugin_settings_tabs['infinite-loader-for-woocommerce-welcome'] = esc_html__( 'Welcome', 'infinite-loader-for-woocommerce' );
		register_setting( 'infinite_loader_for_woocommerce_admin_welcome_options', 'infinite_loader_for_woocommerce_admin_welcome_options' );
		add_settings_section( 'infinite-loader-for-woocommerce-welcome', ' ', array( $this, 'infinite_loader_for_woocommerce_admin_welcome_content' ), 'infinite-loader-for-woocommerce-welcome' );

		$this->plugin_settings_tabs['infinite-loader-for-woocommerce-general'] = esc_html__( 'General', 'infinite-loader-for-woocommerce' );
		register_setting( 'infinite_loader_admin_general_options', 'infinite_loader_admin_general_option' );
		add_settings_section( 'infinite-loader-for-woocommerce-general', ' ', array( $this, 'infinite_loader_for_woocommerce_admin_general_content' ), 'infinite-loader-for-woocommerce-general' );

		$this->plugin_settings_tabs['infinite-loader-for-woocommerce-button'] = esc_html__( 'Button Setting', 'infinite-loader-for-woocommerce' );
		register_setting( 'infinite_loader_admin_button_options', 'infinite_loader_admin_button_option' );
		add_settings_section( 'infinite-loader-for-woocommerce-button', ' ', array( $this, 'infinite_loader_for_woocommerce_admin_button_content' ), 'infinite-loader-for-woocommerce-button' );

		$this->plugin_settings_tabs['infinite-loader-for-woocommerce-previous-button'] = esc_html__( 'Previous Button Setting', 'infinite-loader-for-woocommerce' );
		register_setting( 'infinite_loader_admin_previous_button_options', 'infinite_loader_admin_previous_button_option' );
		add_settings_section( 'infinite-loader-for-woocommerce-previous-button', ' ', array( $this, 'infinite_loader_for_woocommerce_admin_previous_button_content' ), 'infinite-loader-for-woocommerce-previous-button' );

		$this->plugin_settings_tabs['infinite-loader-for-woocommerce-selectors'] = esc_html__( 'Selectors', 'infinite-loader-for-woocommerce' );
		register_setting( 'infinite_loader_admin_selectors_options', 'infinite_loader_admin_selectors_option' );
		add_settings_section( 'infinite-loader-for-woocommerce-selectors', ' ', array( $this, 'infinite_loader_for_woocommerce_admin_selectors_content' ), 'infinite-loader-for-woocommerce-selectors' );

		$this->plugin_settings_tabs['infinite-loader-for-woocommerce-css-js'] = esc_html__( 'JavaScript/CSS', 'infinite-loader-for-woocommerce' );
		register_setting( 'infinite_loader_admin_css_js_options', 'infinite_loader_admin_css_js_option' );
		add_settings_section( 'infinite-loader-for-woocommerce-css-js', ' ', array( $this, 'infinite_loader_for_woocommerce_admin_js_css_content' ), 'infinite-loader-for-woocommerce-css-js' );

	}

	/**
	 * Include infinite loader for woocommerce admin welcome setting tab content file.
	 */
	public function infinite_loader_for_woocommerce_admin_welcome_content() {
		include 'partials/infinite-loader-for-woocommerce-welcome-page.php';
	}

	/**
	 * Include infinite loader for woocommerce admin genral setting tab content file.
	 */
	public function infinite_loader_for_woocommerce_admin_general_content() {
		include 'partials/infinite-loader-for-woocommerce-setting-general-tab.php';
	}

	/**
	 * Include infinite loader for woocommerce admin button setting tab content file.
	 */
	public function infinite_loader_for_woocommerce_admin_button_content() {
		include 'partials/infinite-loader-for-woocommerce-setting-button-tab.php';
	}

	/**
	 * Include infinite loader for woocommerce admin previous button setting tab content file.
	 */
	public function infinite_loader_for_woocommerce_admin_previous_button_content() {
		include 'partials/infinite-loader-for-woocommerce-setting-previous-button-tab.php';
	}

	/**
	 * Include infinite loader for woocommerce admin selectors setting tab content file.
	 */
	public function infinite_loader_for_woocommerce_admin_selectors_content() {
		include 'partials/infinite-loader-for-woocommerce-setting-selectors-tab.php';
	}

	/**
	 * Include infinite loader for woocommerce admin javascript/css setting tab content file.
	 */
	public function infinite_loader_for_woocommerce_admin_js_css_content() {
		include 'partials/infinite-loader-for-woocommerce-setting-css-js-tab.php';
	}
}
