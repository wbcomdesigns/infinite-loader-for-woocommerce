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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
	 * Plugin_settings_tabs
	 *
	 * @since  1.0.0
	 * @access public
	 * @var mixed     $plugin_settings_tabs    The settings Tabs.
	 */
	public $plugin_settings_tabs;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $plugin_name The name of this plugin.
	 * @param    string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Verify admin request
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function verify_admin_request() {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'infinite-loader-for-woocommerce' ) );
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		if ( ! is_admin() ) {
			return;
		}

		$wbcom_setting_page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		
		if ( 'infinite-loader-for-woocommerce-settings' === $wbcom_setting_page || 'wbcomplugins' === $wbcom_setting_page ) {
			$extension = is_rtl() ? '.rtl.css' : '.css';
			$path      = is_rtl() ? '/rtl' : '';
			
			if ( ! defined( 'SCRIPT_DEBUG' ) || ! SCRIPT_DEBUG ) {
				$extension = is_rtl() ? '.rtl.css' : '.min.css';
				$path      = is_rtl() ? '/rtl' : '/min';
			}

			wp_enqueue_style( 
				$this->plugin_name, 
				plugin_dir_url( __FILE__ ) . 'css' . $path . '/infinite-loader-for-woocommerce-admin' . $extension, 
				array(), 
				$this->version, 
				'all' 
			);
			
			wp_enqueue_style( 
				'infinity-loader-select2', 
				plugin_dir_url( __FILE__ ) . 'css/vendor/select2.min.css', 
				array(), 
				$this->version, 
				'all' 
			);
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if ( ! is_admin() ) {
			return;
		}

		$wbcom_setting_page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		
		if ( 'infinite-loader-for-woocommerce-settings' === $wbcom_setting_page ) {
			$extension = '.js';
			$path      = '';
			
			if ( ! defined( 'SCRIPT_DEBUG' ) || ! SCRIPT_DEBUG ) {
				$extension = '.min.js';
				$path      = '/min';
			}

			wp_enqueue_script( 
				$this->plugin_name, 
				plugin_dir_url( __FILE__ ) . 'js' . $path . '/infinite-loader-for-woocommerce-admin' . $extension, 
				array( 'jquery', 'wp-color-picker' ), 
				$this->version, 
				false 
			);
			
			wp_enqueue_script( 
				'infinity-loader-select2-min', 
				plugin_dir_url( __FILE__ ) . 'js/vendor/select2.min.js', 
				array( 'jquery' ), 
				$this->version, 
				false 
			);
			
			wp_enqueue_script( 
				'admin-js', 
				plugin_dir_url( __FILE__ ) . 'js' . $path . '/admin' . $extension, 
				array( 'jquery', 'wp-color-picker' ), 
				$this->version, 
				false 
			);
			
			// Add color picker
			wp_enqueue_style( 'wp-color-picker' );
		}
	}

	/**
	 * Hide all notices from the setting page.
	 *
	 * @return void
	 */
	public function wbcom_hide_all_admin_notices_from_setting_page() {
		$wbcom_pages_array  = array( 'wbcomplugins', 'wbcom-plugins-page', 'wbcom-support-page', 'infinite-loader-for-woocommerce-settings' );
		$wbcom_setting_page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( in_array( $wbcom_setting_page, $wbcom_pages_array, true ) ) {
			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );
		}
	}

	/**
	 * Actions performed on loading admin_menu.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @author   Wbcom Designs
	 */
	public function infinite_loader_for_woocommerce_add_submenu_page_admin_settings() {
		if ( empty( $GLOBALS['admin_page_hooks']['wbcomplugins'] ) && class_exists( 'WooCommerce' ) ) {
			add_menu_page( 
				esc_html__( 'WB Plugins', 'infinite-loader-for-woocommerce' ), 
				esc_html__( 'WB Plugins', 'infinite-loader-for-woocommerce' ), 
				'manage_woocommerce', 
				'wbcomplugins', 
				array( $this, 'infinite_loader_for_woocommerce_admin_options_page' ), 
				'dashicons-lightbulb', 
				59 
			);
			
			add_submenu_page( 
				'wbcomplugins', 
				esc_html__( 'General', 'infinite-loader-for-woocommerce' ), 
				esc_html__( 'General', 'infinite-loader-for-woocommerce' ), 
				'manage_woocommerce', 
				'wbcomplugins' 
			);
		}
		
		add_submenu_page( 
			'wbcomplugins', 
			esc_html__( 'Infinite Loader for WooCommerce', 'infinite-loader-for-woocommerce' ), 
			esc_html__( 'Infinite Loader for WooCommerce', 'infinite-loader-for-woocommerce' ), 
			'manage_woocommerce', 
			'infinite-loader-for-woocommerce-settings', 
			array( $this, 'infinite_loader_for_woocommerce_admin_options_page' ) 
		);
	}

	/**
	 * Actions performed to create a submenu page content.
	 *
	 * @since    1.0.0
	 * @access public
	 */
	public function infinite_loader_for_woocommerce_admin_options_page() {
		$this->verify_admin_request();
		
		$tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'infinite-loader-for-woocommerce-welcome'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		?>
		<div class="wrap">
			<div class="wbcom-bb-plugins-offer-wrapper">
				<div id="wb_admin_logo"></div>
			</div>		
			<div class="wbcom-wrap">
				<div class="blpro-header">
					<div class="wbcom_admin_header-wrapper">
						<div id="wb_admin_plugin_name">
							<?php esc_html_e( 'Infinite Loader for WooCommerce', 'infinite-loader-for-woocommerce' ); ?>
							<?php /* translators: %s: Version number */ ?>
							<span><?php printf( esc_html__( 'Version %s', 'infinite-loader-for-woocommerce' ), esc_html( INFINITE_LOADER_FOR_WOOCOMMERCE_VERSION ) ); ?></span>
						</div>
						<?php echo do_shortcode( '[wbcom_admin_setting_header]' ); ?>
					</div>
				</div>
				<div class="wbcom-admin-settings-page wb-infinite-loader">
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
		$current_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'infinite-loader-for-woocommerce-welcome'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		
		echo '<div class="wbcom-tabs-section"><div class="nav-tab-wrapper"><div class="wb-responsive-menu"><span>' . esc_html( 'Menu' ) . '</span><input class="wb-toggle-btn" type="checkbox" id="wb-toggle-btn"><label class="wb-toggle-icon" for="wb-toggle-btn"><span class="wb-icon-bars"></span></label></div><ul>';
		
		foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab === $tab_key ? 'nav-tab-active' : '';
			echo '<li><a class="nav-tab ' . esc_attr( $active ) . '" id="' . esc_attr( $tab_key ) . '-tab" href="?page=infinite-loader-for-woocommerce-settings&tab=' . esc_attr( $tab_key ) . '">' . esc_html( $tab_caption ) . '</a></li>';
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
		register_setting( 'infinite_loader_admin_general_options', 'infinite_loader_admin_general_option', array( $this, 'validate_general_settings' ) );
		add_settings_section( 'infinite-loader-for-woocommerce-general', ' ', array( $this, 'infinite_loader_for_woocommerce_admin_general_content' ), 'infinite-loader-for-woocommerce-general' );

		$this->plugin_settings_tabs['infinite-loader-for-woocommerce-button'] = esc_html__( 'Button Style', 'infinite-loader-for-woocommerce' );
		register_setting( 'infinite_loader_admin_button_options', 'infinite_loader_admin_button_option', array( $this, 'validate_button_settings' ) );
		add_settings_section( 'infinite-loader-for-woocommerce-button', ' ', array( $this, 'infinite_loader_for_woocommerce_admin_button_content' ), 'infinite-loader-for-woocommerce-button' );

		$this->plugin_settings_tabs['infinite-loader-for-woocommerce-previous-button'] = esc_html__( 'Previous Button Style', 'infinite-loader-for-woocommerce' );
		register_setting( 'infinite_loader_admin_previous_button_options', 'infinite_loader_admin_previous_button_option', array( $this, 'validate_button_settings' ) );
		add_settings_section( 'infinite-loader-for-woocommerce-previous-button', ' ', array( $this, 'infinite_loader_for_woocommerce_admin_previous_button_content' ), 'infinite-loader-for-woocommerce-previous-button' );

		$this->plugin_settings_tabs['infinite-loader-for-woocommerce-css-js'] = esc_html__( 'JavaScript/CSS', 'infinite-loader-for-woocommerce' );
		register_setting( 'infinite_loader_admin_css_js_options', 'infinite_loader_admin_css_js_option', array( $this, 'validate_css_js_settings' ) );
		add_settings_section( 'infinite-loader-for-woocommerce-css-js', ' ', array( $this, 'infinite_loader_for_woocommerce_admin_js_css_content' ), 'infinite-loader-for-woocommerce-css-js' );

		$this->plugin_settings_tabs['infinite-loader-for-woocommerce-faq'] = esc_html__( 'FAQ', 'infinite-loader-for-woocommerce' );
		register_setting( 'infinite_loader_for_woocommerce_admin_faq_options', 'infinite_loader_for_woocommerce_admin_faq_options' );
		add_settings_section( 'infinite-loader-for-woocommerce-faq', ' ', array( $this, 'infinite_loader_for_woocommerce_admin_faq_content' ), 'infinite-loader-for-woocommerce-faq' );
	}

	/**
	 * Validate general settings
	 *
	 * @param  array $input Input data.
	 * @return array        Validated data.
	 */
	public function validate_general_settings( $input ) {
		$validated = array();
		
		// Validate product loading type
		$allowed_types = array( 'infinity-scroll', 'load-more-button', 'pagination' );
		$validated['product_loading_type'] = isset( $input['product_loading_type'] ) && in_array( $input['product_loading_type'], $allowed_types, true ) 
			? $input['product_loading_type'] 
			: 'pagination';
		
		// Validate products per page
		$validated['product_per_page'] = isset( $input['product_per_page'] ) ? absint( $input['product_per_page'] ) : 8;
		if ( $validated['product_per_page'] < 1 ) {
			$validated['product_per_page'] = 8;
		} elseif ( $validated['product_per_page'] > 100 ) {
			$validated['product_per_page'] = 100;
		}
		
		// Validate checkboxes
		$validated['enable_font_awesome'] = isset( $input['enable_font_awesome'] ) && 'yes' === $input['enable_font_awesome'] ? 'yes' : '';
		$validated['rotate_image'] = isset( $input['rotate_image'] ) && 'yes' === $input['rotate_image'] ? 'yes' : '';
		$validated['do_not_update_url'] = isset( $input['do_not_update_url'] ) && 'yes' === $input['do_not_update_url'] ? 'yes' : '';
		
		// Validate loading image
		$validated['loading_image'] = isset( $input['loading_image'] ) ? sanitize_text_field( $input['loading_image'] ) : 'fa-spinner';
		
		return $validated;
	}

	/**
	 * Validate button settings
	 *
	 * @param  array $input Input data.
	 * @return array        Validated data.
	 */
	public function validate_button_settings( $input ) {
		$validated = array();
		
		// Text fields
		$validated['custom_class'] = isset( $input['custom_class'] ) ? sanitize_html_class( $input['custom_class'] ) : '';
		$validated['button_text'] = isset( $input['button_text'] ) ? sanitize_text_field( $input['button_text'] ) : 'Load More';
		
		// Colors
		$validated['background_color'] = isset( $input['background_color'] ) ? $this->sanitize_hex_color( $input['background_color'] ) : '#1d76da';
		$validated['background_color_mouse_hover'] = isset( $input['background_color_mouse_hover'] ) ? $this->sanitize_hex_color( $input['background_color_mouse_hover'] ) : '#0e4da0';
		$validated['border_color'] = isset( $input['border_color'] ) ? $this->sanitize_hex_color( $input['border_color'] ) : '#1d76da';
		$validated['text_color'] = isset( $input['text_color'] ) ? $this->sanitize_hex_color( $input['text_color'] ) : '#ffffff';
		$validated['text_color_mouse_hover'] = isset( $input['text_color_mouse_hover'] ) ? $this->sanitize_hex_color( $input['text_color_mouse_hover'] ) : '#ffffff';
		
		// Dimensions
		$dimension_fields = array(
			'text_font_size', 'padding_top', 'padding_right', 'padding_bottom', 'padding_left',
			'margin_top', 'margin_right', 'margin_bottom', 'margin_left',
			'border_top', 'border_right', 'border_bottom', 'border_left',
			'border_radius_top', 'border_radius_right', 'border_radius_bottom', 'border_radius_left'
		);
		
		foreach ( $dimension_fields as $field ) {
			$validated[ $field ] = isset( $input[ $field ] ) ? absint( $input[ $field ] ) : 0;
			$validated[ $field ] = min( 999, $validated[ $field ] );
		}
		
		return $validated;
	}

	/**
	 * Validate CSS/JS settings
	 *
	 * @param  array $input Input data.
	 * @return array        Validated data.
	 */
	public function validate_css_js_settings( $input ) {
		$validated = array();
		
		// Allow basic CSS but strip any script tags
		$validated['custom_css'] = isset( $input['custom_css'] ) ? wp_strip_all_tags( $input['custom_css'] ) : '';
		
		// For JavaScript, we need to be more careful
		$validated['before_update'] = isset( $input['before_update'] ) ? $this->sanitize_javascript( $input['before_update'] ) : '';
		$validated['after_update'] = isset( $input['after_update'] ) ? $this->sanitize_javascript( $input['after_update'] ) : '';
		
		return $validated;
	}

	/**
	 * Sanitize JavaScript code
	 *
	 * @param  string $js JavaScript code.
	 * @return string     Sanitized JavaScript.
	 */
	private function sanitize_javascript( $js ) {
		// Remove PHP tags
		$js = str_replace( array( '<?php', '<?', '?>' ), '', $js );
		
		// Remove script tags
		$js = preg_replace( '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $js );
		
		return $js;
	}

	/**
	 * Sanitize hex color
	 *
	 * @param  string $color Hex color.
	 * @return string        Sanitized hex color.
	 */
	private function sanitize_hex_color( $color ) {
		if ( '' === $color ) {
			return '';
		}
		
		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}
		
		return '';
	}

	/**
	 * Include infinite loader for woocommerce admin welcome setting tab content file.
	 */
	public function infinite_loader_for_woocommerce_admin_welcome_content() {
		$this->verify_admin_request();
		include 'partials/infinite-loader-for-woocommerce-welcome-page.php';
	}

	/**
	 * Include infinite loader for woocommerce admin general setting tab content file.
	 */
	public function infinite_loader_for_woocommerce_admin_general_content() {
		$this->verify_admin_request();
		include 'partials/infinite-loader-for-woocommerce-setting-general-tab.php';
	}

	/**
	 * Include infinite loader for woocommerce admin button style tab content file.
	 */
	public function infinite_loader_for_woocommerce_admin_button_content() {
		$this->verify_admin_request();
		include 'partials/infinite-loader-for-woocommerce-setting-button-tab.php';
	}

	/**
	 * Include infinite loader for woocommerce admin previous button style tab content file.
	 */
	public function infinite_loader_for_woocommerce_admin_previous_button_content() {
		$this->verify_admin_request();
		include 'partials/infinite-loader-for-woocommerce-setting-previous-button-tab.php';
	}

	/**
	 * Include infinite loader for woocommerce admin javascript/css setting tab content file.
	 */
	public function infinite_loader_for_woocommerce_admin_js_css_content() {
		$this->verify_admin_request();
		include 'partials/infinite-loader-for-woocommerce-setting-css-js-tab.php';
	}

	/**
	 * Include infinite loader for woocommerce admin faq setting tab content file.
	 */
	public function infinite_loader_for_woocommerce_admin_faq_content() {
		$this->verify_admin_request();
		include 'partials/infinite-loader-for-woocommerce-faq-tab.php';
	}

	/**
	 * Display load more preview button.
	 */
	public static function infinite_loader_for_woocommerce_display_load_more_button() {
		$infinite_loader_button_setting  = get_option( 'infinite_loader_admin_button_option', array() );
		$infinite_loader_lm_custom_class = self::infinite_loader_get_option_value( $infinite_loader_button_setting, 'custom_class' );
		$infinite_loader_lm_button_text  = self::infinite_loader_get_option_value( $infinite_loader_button_setting, 'button_text', 'Load More' );

		$infinite_loader_load_more_button  = '<div class="infinite_loader_btn_load infinite_loader_btn_setting">';
		$infinite_loader_load_more_button .= '<a class="infinite_button ' . esc_attr( $infinite_loader_lm_custom_class ) . '" style="';
		$infinite_loader_load_more_button .= esc_attr( apply_filters( 'infinite_loader_for_woocommerce_load_more_button_style', '', $infinite_loader_button_setting ) );
		$infinite_loader_load_more_button .= '" href="#load_next_page">' . esc_html( $infinite_loader_lm_button_text ) . '</a>';
		$infinite_loader_load_more_button .= '</div>';
		
		return $infinite_loader_load_more_button;
	}

	/**
	 * Display load previous preview button.
	 */
	public static function infinite_loader_for_woocommerce_display_load_previous_button() {
		$infinite_loader_previous_button_setting  = get_option( 'infinite_loader_admin_previous_button_option', array() );
		$infinite_loader_prev_button_custom_class = self::infinite_loader_get_option_value( $infinite_loader_previous_button_setting, 'custom_class' );
		$infinite_loader_prev_button_text         = self::infinite_loader_get_option_value( $infinite_loader_previous_button_setting, 'button_text', 'Load Previous' );

		$infinite_loader_previous_button  = '<div class="infinite_loader_btn_load infinite_loader_prev_btn_setting">';
		$infinite_loader_previous_button .= '<a class="infinite_button ' . esc_attr( $infinite_loader_prev_button_custom_class ) . '" style="';
		$infinite_loader_previous_button .= esc_attr( apply_filters( 'infinite_loader_for_woocommerce_load_previous_button_style', '', $infinite_loader_previous_button_setting ) );
		$infinite_loader_previous_button .= '" href="#load_previous_page">' . esc_html( $infinite_loader_prev_button_text ) . '</a>';
		$infinite_loader_previous_button .= '</div>';
		
		return $infinite_loader_previous_button;
	}

	/**
	 * The Function is responsible for the load more button style.
	 *
	 * @param  string $style   Current style.
	 * @param  array  $setting Button settings.
	 * @return string          Button style.
	 */
	public function infinite_loader_for_woocommerce_button_style( $style, $setting = array() ) {
		$infinite_loader_button_setting = ! empty( $setting ) ? $setting : get_option( 'infinite_loader_admin_button_option', array() );

		if ( empty( $infinite_loader_button_setting ) ) {
			return '';
		}

		$styles = array();
		
		// Font size
		$font_size = self::infinite_loader_get_dimension_value( $infinite_loader_button_setting, 'text_font_size', '16' );
		$styles[] = 'font-size: ' . $font_size . 'px';
		
		// Colors
		$text_color = self::infinite_loader_get_option_value( $infinite_loader_button_setting, 'text_color', '#ffffff' );
		$bg_color = self::infinite_loader_get_option_value( $infinite_loader_button_setting, 'background_color', '#1d76da' );
		$border_color = self::infinite_loader_get_option_value( $infinite_loader_button_setting, 'border_color', '#1d76da' );
		
		$styles[] = 'color: ' . $text_color;
		$styles[] = 'background-color: ' . $bg_color;
		
		// Padding
		$padding_fields = array( 'padding_top', 'padding_right', 'padding_bottom', 'padding_left' );
		$padding_defaults = array( '13', '30', '13', '30' );
		
		foreach ( $padding_fields as $index => $field ) {
			$value = self::infinite_loader_get_dimension_value( $infinite_loader_button_setting, $field, $padding_defaults[ $index ] );
			$styles[] = str_replace( '_', '-', $field ) . ': ' . $value . 'px';
		}
		
		// Margin
		$margin_fields = array( 'margin_top', 'margin_right', 'margin_bottom', 'margin_left' );
		
		foreach ( $margin_fields as $field ) {
			$value = self::infinite_loader_get_dimension_value( $infinite_loader_button_setting, $field, '0' );
			$styles[] = str_replace( '_', '-', $field ) . ': ' . $value . 'px';
		}
		
		// Border
		$border_fields = array( 'border_top', 'border_right', 'border_bottom', 'border_left' );
		
		foreach ( $border_fields as $field ) {
			$width = self::infinite_loader_get_dimension_value( $infinite_loader_button_setting, $field, '1' );
			$side = str_replace( 'border_', '', $field );
			$styles[] = 'border-' . $side . ': ' . $width . 'px solid ' . $border_color;
		}
		
		// Border radius
		$radius_map = array(
			'border_radius_top' => 'border-top-left-radius',
			'border_radius_right' => 'border-top-right-radius',
			'border_radius_bottom' => 'border-bottom-right-radius',
			'border_radius_left' => 'border-bottom-left-radius'
		);
		
		foreach ( $radius_map as $field => $css_property ) {
			$value = self::infinite_loader_get_dimension_value( $infinite_loader_button_setting, $field, '50' );
			$styles[] = $css_property . ': ' . $value . 'px';
		}
		
		return implode( '; ', $styles );
	}

	/**
	 * The Function is responsible for the load previous button style.
	 *
	 * @param  string $style   Current style.
	 * @param  array  $setting Button settings.
	 * @return string          Button style.
	 */
	public function infinite_loader_for_woocommerce_previous_button_style( $style, $setting = array() ) {
		// Use the same logic as load more button
		return $this->infinite_loader_for_woocommerce_button_style( $style, $setting );
	}

	/**
	 * Safely get option value with default fallback
	 *
	 * @param array  $options Option array.
	 * @param string $key     Option key.
	 * @param mixed  $default Default value.
	 * @return mixed Option value or default.
	 */
	private static function infinite_loader_get_option_value( $options, $key, $default = '' ) {
		if ( ! is_array( $options ) ) {
			return $default;
		}
		
		return isset( $options[ $key ] ) && '' !== $options[ $key ] ? $options[ $key ] : $default;
	}

	/**
	 * Get button dimension value with validation
	 *
	 * @param array  $settings Button settings.
	 * @param string $key      Setting key.
	 * @param string $default  Default value.
	 * @return string Validated dimension value.
	 */
	private static function infinite_loader_get_dimension_value( $settings, $key, $default = '0' ) {
		$value = self::infinite_loader_get_option_value( $settings, $key, $default );
		
		// Ensure numeric value
		if ( ! is_numeric( $value ) ) {
			return $default;
		}
		
		$numeric_value = absint( $value );
		
		// Limit reasonable range (0-999px)
		return (string) min( 999, max( 0, $numeric_value ) );
	}

	/**
	 * This function contains the icons in array.
	 *
	 * @return array Icon lists.
	 */
	public function infinite_loader_icon_lists() {
		return array(
			'fa-glass',
			'fa-music',
			'fa-search',
			'fa-envelope-o',
			'fa-heart',
			'fa-star',
			'fa-star-o',
			'fa-user',
			'fa-film',
			'fa-th-large',
			'fa-th',
			'fa-th-list',
			'fa-check',
			'fa-times',
			'fa-search-plus',
			'fa-search-minus',
			'fa-power-off',
			'fa-signal',
			'fa-cog',
			'fa-trash-o',
			'fa-home',
			'fa-file-o',
			'fa-clock-o',
			'fa-road',
			'fa-download',
			'fa-arrow-circle-o-down',
			'fa-arrow-circle-o-up',
			'fa-inbox',
			'fa-play-circle-o',
			'fa-repeat',
			'fa-refresh',
			'fa-list-alt',
			'fa-lock',
			'fa-flag',
			'fa-headphones',
			'fa-volume-off',
			'fa-volume-down',
			'fa-volume-up',
			'fa-qrcode',
			'fa-barcode',
			'fa-tag',
			'fa-tags',
			'fa-book',
			'fa-bookmark',
			'fa-print',
			'fa-camera',
			'fa-font',
			'fa-bold',
			'fa-italic',
			'fa-text-height',
			'fa-text-width',
			'fa-align-left',
			'fa-align-center',
			'fa-align-right',
			'fa-align-justify',
			'fa-list',
			'fa-outdent',
			'fa-indent',
			'fa-video-camera',
			'fa-picture-o',
			'fa-pencil',
			'fa-map-marker',
			'fa-adjust',
			'fa-tint',
			'fa-pencil-square-o',
			'fa-share-square-o',
			'fa-check-square-o',
			'fa-arrows',
			'fa-step-backward',
			'fa-fast-backward',
			'fa-backward',
			'fa-play',
			'fa-pause',
			'fa-stop',
			'fa-forward',
			'fa-fast-forward',
			'fa-step-forward',
			'fa-eject',
			'fa-chevron-left',
			'fa-chevron-right',
			'fa-plus-circle',
			'fa-minus-circle',
			'fa-times-circle',
			'fa-check-circle',
			'fa-question-circle',
			'fa-info-circle',
			'fa-crosshairs',
			'fa-times-circle-o',
			'fa-check-circle-o',
			'fa-ban',
			'fa-arrow-left',
			'fa-arrow-right',
			'fa-arrow-up',
			'fa-arrow-down',
			'fa-share',
			'fa-expand',
			'fa-compress',
			'fa-plus',
			'fa-minus',
			'fa-asterisk',
			'fa-exclamation-circle',
			'fa-gift',
			'fa-leaf',
			'fa-fire',
			'fa-eye',
			'fa-eye-slash',
			'fa-exclamation-triangle',
			'fa-plane',
			'fa-calendar',
			'fa-random',
			'fa-comment',
			'fa-magnet',
			'fa-chevron-up',
			'fa-chevron-down',
			'fa-retweet',
			'fa-shopping-cart',
			'fa-folder',
			'fa-folder-open',
			'fa-arrows-v',
			'fa-arrows-h',
			'fa-bar-chart',
			'fa-twitter-square',
			'fa-facebook-square',
			'fa-camera-retro',
			'fa-key',
			'fa-cogs',
			'fa-comments',
			'fa-thumbs-o-up',
			'fa-thumbs-o-down',
			'fa-star-half',
			'fa-heart-o',
			'fa-sign-out',
			'fa-linkedin-square',
			'fa-thumb-tack',
			'fa-external-link',
			'fa-sign-in',
			'fa-trophy',
			'fa-github-square',
			'fa-upload',
			'fa-lemon-o',
			'fa-phone',
			'fa-square-o',
			'fa-bookmark-o',
			'fa-phone-square',
			'fa-twitter',
			'fa-facebook',
			'fa-github',
			'fa-unlock',
			'fa-credit-card',
			'fa-rss',
			'fa-hdd-o',
			'fa-bullhorn',
			'fa-bell',
			'fa-certificate',
			'fa-hand-o-right',
			'fa-hand-o-left',
			'fa-hand-o-up',
			'fa-hand-o-down',
			'fa-arrow-circle-left',
			'fa-arrow-circle-right',
			'fa-arrow-circle-up',
			'fa-arrow-circle-down',
			'fa-globe',
			'fa-wrench',
			'fa-tasks',
			'fa-filter',
			'fa-briefcase',
			'fa-arrows-alt',
			'fa-users',
			'fa-link',
			'fa-cloud',
			'fa-flask',
			'fa-scissors',
			'fa-files-o',
			'fa-paperclip',
			'fa-floppy-o',
			'fa-square',
			'fa-bars',
			'fa-list-ul',
			'fa-list-ol',
			'fa-strikethrough',
			'fa-underline',
			'fa-table',
			'fa-magic',
			'fa-truck',
			'fa-pinterest',
			'fa-pinterest-square',
			'fa-google-plus-square',
			'fa-google-plus',
			'fa-money',
			'fa-caret-down',
			'fa-caret-up',
			'fa-caret-left',
			'fa-caret-right',
			'fa-columns',
			'fa-sort',
			'fa-sort-desc',
			'fa-sort-asc',
			'fa-envelope',
			'fa-linkedin',
			'fa-undo',
			'fa-gavel',
			'fa-tachometer',
			'fa-comment-o',
			'fa-comments-o',
			'fa-bolt',
			'fa-sitemap',
			'fa-umbrella',
			'fa-clipboard',
			'fa-lightbulb-o',
			'fa-exchange',
			'fa-cloud-download',
			'fa-cloud-upload',
			'fa-user-md',
			'fa-stethoscope',
			'fa-suitcase',
			'fa-bell-o',
			'fa-coffee',
			'fa-cutlery',
			'fa-file-text-o',
			'fa-building-o',
			'fa-hospital-o',
			'fa-ambulance',
			'fa-medkit',
			'fa-fighter-jet',
			'fa-beer',
			'fa-h-square',
			'fa-plus-square',
			'fa-angle-double-left',
			'fa-angle-double-right',
			'fa-angle-double-up',
			'fa-angle-double-down',
			'fa-angle-left',
			'fa-angle-right',
			'fa-angle-up',
			'fa-angle-down',
			'fa-desktop',
			'fa-laptop',
			'fa-tablet',
			'fa-mobile',
			'fa-circle-o',
			'fa-quote-left',
			'fa-quote-right',
			'fa-spinner',
			'fa-circle',
			'fa-reply',
			'fa-github-alt',
			'fa-folder-o',
			'fa-folder-open-o',
			'fa-smile-o',
			'fa-frown-o',
			'fa-meh-o',
			'fa-gamepad',
			'fa-keyboard-o',
			'fa-flag-o',
			'fa-flag-checkered',
			'fa-terminal',
			'fa-code',
			'fa-reply-all',
			'fa-star-half-o',
			'fa-location-arrow',
			'fa-crop',
			'fa-code-fork',
			'fa-chain-broken',
			'fa-question',
			'fa-info',
			'fa-exclamation',
			'fa-superscript',
			'fa-subscript',
			'fa-eraser',
			'fa-puzzle-piece',
			'fa-microphone',
			'fa-microphone-slash',
			'fa-shield',
			'fa-calendar-o',
			'fa-fire-extinguisher',
			'fa-rocket',
			'fa-maxcdn',
			'fa-chevron-circle-left',
			'fa-chevron-circle-right',
			'fa-chevron-circle-up',
			'fa-chevron-circle-down',
			'fa-html5',
			'fa-css3',
			'fa-anchor',
			'fa-unlock-alt',
			'fa-bullseye',
			'fa-ellipsis-h',
			'fa-ellipsis-v',
			'fa-rss-square',
			'fa-play-circle',
			'fa-ticket',
			'fa-minus-square',
			'fa-minus-square-o',
			'fa-level-up',
			'fa-level-down',
			'fa-check-square',
			'fa-pencil-square',
			'fa-external-link-square',
			'fa-share-square',
			'fa-compass',
			'fa-caret-square-o-down',
			'fa-caret-square-o-up',
			'fa-caret-square-o-right',
			'fa-eur',
			'fa-gbp',
			'fa-usd',
			'fa-inr',
			'fa-jpy',
			'fa-rub',
			'fa-krw',
			'fa-btc',
			'fa-file',
			'fa-file-text',
			'fa-sort-alpha-asc',
			'fa-sort-alpha-desc',
			'fa-sort-amount-asc',
			'fa-sort-amount-desc',
			'fa-sort-numeric-asc',
			'fa-sort-numeric-desc',
			'fa-thumbs-up',
			'fa-thumbs-down',
			'fa-youtube-square',
			'fa-youtube',
			'fa-xing',
			'fa-xing-square',
			'fa-youtube-play',
			'fa-dropbox',
			'fa-stack-overflow',
			'fa-instagram',
			'fa-flickr',
			'fa-adn',
			'fa-bitbucket',
			'fa-bitbucket-square',
			'fa-tumblr',
			'fa-tumblr-square',
			'fa-long-arrow-down',
			'fa-long-arrow-up',
			'fa-long-arrow-left',
			'fa-long-arrow-right',
			'fa-apple',
			'fa-windows',
			'fa-android',
			'fa-linux',
			'fa-dribbble',
			'fa-skype',
			'fa-foursquare',
			'fa-trello',
			'fa-female',
			'fa-male',
			'fa-gittip',
			'fa-sun-o',
			'fa-moon-o',
			'fa-archive',
			'fa-bug',
			'fa-vk',
			'fa-weibo',
			'fa-renren',
			'fa-pagelines',
			'fa-stack-exchange',
			'fa-arrow-circle-o-right',
			'fa-arrow-circle-o-left',
			'fa-caret-square-o-left',
			'fa-dot-circle-o',
			'fa-wheelchair',
			'fa-vimeo-square',
			'fa-try',
			'fa-plus-square-o',
			'fa-space-shuttle',
			'fa-slack',
			'fa-envelope-square',
			'fa-wordpress',
			'fa-openid',
			'fa-university',
			'fa-graduation-cap',
			'fa-yahoo',
			'fa-google',
			'fa-reddit',
			'fa-reddit-square',
			'fa-stumbleupon-circle',
			'fa-stumbleupon',
			'fa-delicious',
			'fa-digg',
			'fa-pied-piper',
			'fa-pied-piper-alt',
			'fa-drupal',
			'fa-joomla',
			'fa-language',
			'fa-fax',
			'fa-building',
			'fa-child',
			'fa-paw',
			'fa-spoon',
			'fa-cube',
			'fa-cubes',
			'fa-behance',
			'fa-behance-square',
			'fa-steam',
			'fa-steam-square',
			'fa-recycle',
			'fa-car',
			'fa-taxi',
			'fa-tree',
			'fa-spotify',
			'fa-deviantart',
			'fa-soundcloud',
			'fa-database',
			'fa-file-pdf-o',
			'fa-file-word-o',
			'fa-file-excel-o',
			'fa-file-powerpoint-o',
			'fa-file-image-o',
			'fa-file-archive-o',
			'fa-file-audio-o',
			'fa-file-video-o',
			'fa-file-code-o',
			'fa-vine',
			'fa-codepen',
			'fa-jsfiddle',
			'fa-life-ring',
			'fa-circle-o-notch',
			'fa-rebel',
			'fa-empire',
			'fa-git-square',
			'fa-git',
			'fa-hacker-news',
			'fa-tencent-weibo',
			'fa-qq',
			'fa-weixin',
			'fa-paper-plane',
			'fa-paper-plane-o',
			'fa-history',
			'fa-circle-thin',
			'fa-header',
			'fa-paragraph',
			'fa-sliders',
			'fa-share-alt',
			'fa-share-alt-square',
			'fa-bomb',
			'fa-futbol-o',
			'fa-tty',
			'fa-binoculars',
			'fa-plug',
			'fa-slideshare',
			'fa-twitch',
			'fa-yelp',
			'fa-newspaper-o',
			'fa-wifi',
			'fa-calculator',
			'fa-paypal',
			'fa-google-wallet',
			'fa-cc-visa',
			'fa-cc-mastercard',
			'fa-cc-discover',
			'fa-cc-amex',
			'fa-cc-paypal',
			'fa-cc-stripe',
			'fa-bell-slash',
			'fa-bell-slash-o',
			'fa-trash',
			'fa-copyright',
			'fa-at',
			'fa-eyedropper',
			'fa-paint-brush',
			'fa-birthday-cake',
			'fa-area-chart',
			'fa-pie-chart',
			'fa-line-chart',
			'fa-lastfm',
			'fa-lastfm-square',
			'fa-toggle-off',
			'fa-toggle-on',
			'fa-bicycle',
			'fa-bus',
			'fa-ioxhost',
			'fa-angellist',
			'fa-cc',
			'fa-ils',
			'fa-meanpath',
		);
	}

	/**
	 * This Function is for display font awesome icon popup.
	 */
	public function infinite_loader_icon_popup() {
		$result         = '';
		$infinite_icons = $this->infinite_loader_icon_lists();
		$result         = '<div class="infinite_display_icon_popup"><div class="infinite_icons_popup">
		<input type="text" class="infinite_icons_search"><span class="infinite_close_popup"><i class="fa fa-times"></i></span>
		<div class="infinite_icons_lists">';
		
		foreach ( $infinite_icons as $infinite_icon ) {
			$result .= '<span class="infinite_fa_fa_icon"><span class="infinite_icon_hover"></span><span class="infinite_icon_preview"><i class="fa ' . esc_attr( $infinite_icon ) . '"></i><span>' . esc_html( $infinite_icon ) . '</span></span></span>';
		}
		
		$result .= '</div></div></div>';
		
		return $result;
	}
}