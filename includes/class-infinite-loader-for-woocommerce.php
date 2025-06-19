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

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
		$this->define_security_hooks();
	}

	/**
	 * Define plugin constants that are use entire plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_constants() {
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
		if ( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wbcom/wbcom-admin-settings.php' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wbcom/wbcom-admin-settings.php';
		}

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
		if ( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wbcom/wbcom-paid-plugin-settings.php' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wbcom/wbcom-paid-plugin-settings.php';
		}

		/** This file is responsible for the plugin license functionality. */
		if ( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'edd-license/edd-plugin-license.php' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'edd-license/edd-plugin-license.php';
		}

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
		$this->loader->add_filter( 'infinite_loader_for_woocommerce_load_more_button_style', $plugin_admin, 'infinite_loader_for_woocommerce_button_style', 10, 2 );
		$this->loader->add_filter( 'infinite_loader_for_woocommerce_load_previous_button_style', $plugin_admin, 'infinite_loader_for_woocommerce_previous_button_style', 10, 2 );
		$this->loader->add_action( 'in_admin_header', $plugin_admin, 'wbcom_hide_all_admin_notices_from_setting_page' );
		
		// Add AJAX handler
		$this->loader->add_action( 'template_redirect', $plugin_admin, 'handle_infinite_loader_ajax' );
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
		$this->loader->add_action( 'woocommerce_before_template_part', $plugin_public, 'infinite_loader_before_template_part', 1 );
		$this->loader->add_filter( 'loop_shop_per_page', $plugin_public, 'infinite_loader_set_product_per_page', 20 );
	}

	/**
	 * Register security hooks
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_security_hooks() {
		// Add Content Security Policy headers
		$this->loader->add_action( 'send_headers', $this, 'add_security_headers' );
		
		// Sanitize options on save
		$this->loader->add_filter( 'pre_update_option_infinite_loader_admin_css_js_option', $this, 'sanitize_css_js_option', 10, 2 );
		
		// Add rate limiting check
		$this->loader->add_action( 'init', $this, 'check_rate_limit' );
	}

	/**
	 * Add security headers
	 */
	public function add_security_headers() {
		// Only add headers on frontend where plugin is active
		if ( is_admin() ) {
			return;
		}
		
		// Check if we're on a WooCommerce page
		if ( ! is_shop() && ! is_product_category() && ! is_product_tag() && ! is_product_taxonomy() ) {
			return;
		}
		
		// Prevent XSS attacks
		header( 'X-XSS-Protection: 1; mode=block' );
		
		// Prevent clickjacking
		header( 'X-Frame-Options: SAMEORIGIN' );
		
		// Prevent MIME type sniffing
		header( 'X-Content-Type-Options: nosniff' );
		
		// Referrer Policy
		header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	}

	/**
	 * Sanitize CSS/JS option before saving
	 *
	 * @param mixed $new_value New option value.
	 * @param mixed $old_value Old option value.
	 * @return mixed Sanitized value.
	 */
	public function sanitize_css_js_option( $new_value, $old_value ) {
		if ( ! is_array( $new_value ) ) {
			return $old_value;
		}
		
		// Sanitize custom CSS - remove any script tags
		if ( isset( $new_value['custom_css'] ) ) {
			$new_value['custom_css'] = wp_strip_all_tags( $new_value['custom_css'] );
			
			// Remove any @import statements that could load external resources
			$new_value['custom_css'] = preg_replace( '/@import\s+(?:url\s*\(\s*)?["\']?[^"\')]+["\']?\s*\)?[^;]*;?/i', '', $new_value['custom_css'] );
			
			// Remove JavaScript URLs
			$new_value['custom_css'] = preg_replace( '/javascript\s*:/i', '', $new_value['custom_css'] );
			
			// Remove expression() which can execute JavaScript in older IE
			$new_value['custom_css'] = preg_replace( '/expression\s*\(/i', '', $new_value['custom_css'] );
		}
		
		// Sanitize JavaScript - remove potentially dangerous code
		$js_fields = array( 'before_update', 'after_update' );
		foreach ( $js_fields as $field ) {
			if ( isset( $new_value[ $field ] ) ) {
				$js = $new_value[ $field ];
				
				// Remove PHP tags
				$js = str_replace( array( '<?php', '<?', '?>' ), '', $js );
				
				// Remove script tags
				$js = preg_replace( '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $js );
				
				// Check for dangerous functions
				$dangerous_patterns = array(
					'/\beval\s*\(/i',
					'/\bnew\s+Function\s*\([^)]*\)/i',
					'/\bdocument\.write/i',
					'/\bdocument\.writeln/i',
					'/\binnerHTML\s*=/i',
					'/\bouterHTML\s*=/i',
					'/\bdocument\.cookie/i',
					'/\blocalStorage/i',
					'/\bsessionStorage/i',
					'/\bwindow\.location\s*=/i',
					'/\bdocument\.location\s*=/i',
					'/\bexecScript/i',
					'/\bsetTimeout\s*\(\s*["\']/',
					'/\bsetInterval\s*\(\s*["\']/',
				);
				
				foreach ( $dangerous_patterns as $pattern ) {
					if ( preg_match( $pattern, $js ) ) {
						// Log potential security issue
						error_log( 'Infinite Loader: Potentially dangerous JavaScript pattern detected: ' . $pattern );
						
						// Remove the dangerous code
						$js = preg_replace( $pattern, '/* Code removed for security */', $js );
					}
				}
				
				$new_value[ $field ] = $js;
			}
		}
		
		return $new_value;
	}

	/**
	 * Check rate limit for AJAX requests
	 */
	public function check_rate_limit() {
		// Only check for AJAX requests
		if ( ! isset( $_REQUEST['infinite_loader_ajax'] ) ) {
			return;
		}
		
		$user_ip = $this->get_client_ip();
		$transient_key = 'infinite_loader_rate_' . md5( $user_ip );
		$requests = get_transient( $transient_key );
		
		if ( false === $requests ) {
			$requests = 0;
		}
		
		$requests++;
		
		// Default rate limit: 30 requests per minute
		$rate_limit = apply_filters( 'infinite_loader_rate_limit', 30 );
		
		if ( $requests > $rate_limit ) {
			wp_die( 
				esc_html__( 'Rate limit exceeded. Please try again later.', 'infinite-loader-for-woocommerce' ), 
				esc_html__( 'Too Many Requests', 'infinite-loader-for-woocommerce' ),
				array( 'response' => 429 )
			);
		}
		
		set_transient( $transient_key, $requests, MINUTE_IN_SECONDS );
	}

	/**
	 * Get client IP address
	 *
	 * @return string Client IP address.
	 */
	private function get_client_ip() {
		$ip_keys = array( 'HTTP_CF_CONNECTING_IP', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' );
		
		foreach ( $ip_keys as $key ) {
			if ( array_key_exists( $key, $_SERVER ) === true ) {
				foreach ( explode( ',', $_SERVER[ $key ] ) as $ip ) {
					$ip = trim( $ip );
					
					if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== false ) {
						return $ip;
					}
				}
			}
		}
		
		return isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
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