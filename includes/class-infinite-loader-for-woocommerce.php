<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/includes
 * @author     WBCOM Designs <admin@wbcomdesigns.com>
 */
class Infinite_Loader_For_Woocommerce {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Infinite_Loader_For_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'INFINITE_LOADER_FOR_WOOCOMMERCE_VERSION' ) ) {
			$this->version = INFINITE_LOADER_FOR_WOOCOMMERCE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'infinite-loader-for-woocommerce';
		$this->define_constants();
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Define plugin constants that are use entire plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function define_constants() {
		
		$this->define( 'INFINITE_LOADER_FOR_WOOCOMMERCE_VERSION', '1.2.2' );
		$this->define( 'INFINITE_LOADER_FOR_WOOCOMMERCE_FILE', __FILE__ );
		$this->define( 'INFINITE_LOADER_FOR_WOOCOMMERCE_URL', plugin_dir_url( dirname( __FILE__ ) ) );
		$this->define( 'INFINITE_LOADER_FOR_WOOCOMMERCE_PATH', plugin_dir_path( dirname( __FILE__ ) ) );
		$this->define( 'INFINITE_LOADER_FOR_WOOCOMMERCE_TEMPLATE_PATH', plugin_dir_path( dirname( __FILE__ ) ) . '/templates/' );
	}

	/**
	 * Define constant if not already defined
	 *
	 * @since 1.0.0
	 *
	 * @param string      $name Name.
	 * @param string|bool $value Value.
	 *
	 * @return void
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Infinite_Loader_For_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Infinite_Loader_For_Woocommerce_I18n. Defines internationalization functionality.
	 * - Infinite_Loader_For_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - Infinite_Loader_For_Woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-infinite-loader-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-infinite-loader-for-woocommerce-i18n.php';

		/**
		* The class responsible add wrapper of admin settings.
		*/
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wbcom/wbcom-admin-settings.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-infinite-loader-for-woocommerce-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-infinite-loader-for-woocommerce-public.php';

		/** This file adds the plugin license module UI. */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wbcom/wbcom-paid-plugin-settings.php';

		/** This file is responsible for the plugin license functionality. */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'edd-license/edd-plugin-license.php';

		$this->loader = new Infinite_Loader_For_Woocommerce_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Infinite_Loader_For_Woocommerce_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Infinite_Loader_For_Woocommerce_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Infinite_Loader_For_Woocommerce_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'infinite_loader_for_woocommerce_add_submenu_page_admin_settings' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'infinite_loader_for_woocommerce_init_plugin_settings' );
		$this->loader->add_action( 'infinite_loader_load_more_buttom_preview', $plugin_admin, 'section_btn_custom_class' );
		$this->loader->add_filter( 'infinite_loader_for_woocommerce_load_more_button_style', $plugin_admin, 'infinite_loader_for_woocommerce_button_style' );
		$this->loader->add_filter( 'infinite_loader_for_woocommerce_load_previous_button_style', $plugin_admin, 'infinite_loader_for_woocommerce_previous_button_style' );
		$this->loader->add_action( 'in_admin_header', $plugin_admin, 'wbcom_hide_all_admin_notices_from_setting_page' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Infinite_Loader_For_Woocommerce_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'infinite_loader_for_woocommerce_display_custom_css' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'infinite_loader_add_load_more_hover_css' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'infinite_loader_add_previous_hover_css' );
		$this->loader->add_action( 'init', $plugin_public, 'infinite_loader_for_woocommerce_enqueue_fontawesome_file' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'infinite_loader_add_css_js_for_loading_products' );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'infinite_loader_for_woo_scroll_top_button' );
		$this->loader->add_filter( 'infinite_loader_for_woocommerce_load_more_button_styles', $plugin_public, 'infinite_loader_for_woocommerce_button_styles' );
		$this->loader->add_action( 'woocommerce_before_template_part', $plugin_public, 'infinite_loader_before_template_part', 1 );
		$this->loader->add_filter( 'loop_shop_per_page', $plugin_public, 'infinite_loader_set_product_per_page', 20 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Infinite_Loader_For_Woocommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
