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
		wp_enqueue_script( 'admin-js', plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), $this->version, false );

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

	/**
	 * Display load more preview button.
	 */
	public static function infinite_loader_for_woocommerce_display_load_more_button() {
		$infinite_loader_button_setting  = get_option( 'infinite_loader_admin_button_option' );
		$infinite_loader_lm_custom_class = isset( $infinite_loader_button_setting['custom_class'] ) ? $infinite_loader_button_setting['custom_class'] : '';
		$infinite_loader_lm_button_text  = isset( $infinite_loader_button_setting['button_text'] ) ? $infinite_loader_button_setting['button_text'] : '';

		$infinite_loader_load_more_button  = '<div class="infinite_loader_btn_load infinite_loader_btn_setting">';
		$infinite_loader_load_more_button .= '<a class="infinite_button ' . esc_attr( $infinite_loader_lm_custom_class ) . '" style="';
		$infinite_loader_load_more_button .= apply_filters( 'infinite_loader_for_woocommerce_load_more_button_style', '', );
		$infinite_loader_load_more_button .= '" href="#load_next_page">' . esc_html( $infinite_loader_lm_button_text ) . '</a>';
		$infinite_loader_load_more_button .= '</div>';
		return $infinite_loader_load_more_button;
	}

	/**
	 * The Function is responsible for the load more button style.
	 */
	public function infinite_loader_for_woocommerce_button_style() {
		$infinite_loader_load_more_button_style = '';
		$infinite_loader_button_setting         = get_option( 'infinite_loader_admin_button_option' );

		$infinite_loader_lm_button_margin_top    = ( isset( $infinite_loader_button_setting['margin_top'] ) && ! empty( $infinite_loader_button_setting['margin_top'] ) ) ? $infinite_loader_button_setting['margin_top'] : '0';
		$infinite_loader_lm_button_margin_right  = ( isset( $infinite_loader_button_setting['margin_right'] ) && ! empty( $infinite_loader_button_setting['margin_right'] ) ) ? $infinite_loader_button_setting['margin_right'] : '0';
		$infinite_loader_lm_button_margin_bottom = ( isset( $infinite_loader_button_setting['margin_bottom'] ) && ! empty( $infinite_loader_button_setting['margin_bottom'] ) ) ? $infinite_loader_button_setting['margin_bottom'] : '0';
		$infinite_loader_lm_button_margin_left   = ( isset( $infinite_loader_button_setting['margin_left'] ) && ! empty( $infinite_loader_button_setting['margin_left'] ) ) ? $infinite_loader_button_setting['margin_left'] : '0';
		$infinite_loader_lm_button_border_top    = ( isset( $infinite_loader_button_setting['border_top'] ) && ! empty( $infinite_loader_button_setting['border_top'] ) ) ? $infinite_loader_button_setting['border_top'] : '0';
		$infinite_loader_lm_button_border_bottom = ( isset( $infinite_loader_button_setting['border_bottom'] ) && ! empty( $infinite_loader_button_setting['border_bottom'] ) ) ? $infinite_loader_button_setting['border_bottom'] : '0';
		$infinite_loader_lm_button_border_left   = ( isset( $infinite_loader_button_setting['border_left'] ) && ! empty( $infinite_loader_button_setting['border_left'] ) ) ? $infinite_loader_button_setting['border_left'] : '0';
		$infinite_loader_lm_button_border_right  = ( isset( $infinite_loader_button_setting['border_right'] ) && ! empty( $infinite_loader_button_setting['border_right'] ) ) ? $infinite_loader_button_setting['border_right'] : '0';

		$infinite_loader_load_more_button_style .= 'font-size: ' . $infinite_loader_button_setting['text_font_size'] . 'px;';
		$infinite_loader_load_more_button_style .= 'color: ' . $infinite_loader_button_setting['text_color'] . ';';
		$infinite_loader_load_more_button_style .= 'background-color: ' . $infinite_loader_button_setting['background_color'] . ';';
		$infinite_loader_load_more_button_style .= 'padding-top:' . $infinite_loader_button_setting['padding_top'] . 'px;';
		$infinite_loader_load_more_button_style .= 'padding-right:' . $infinite_loader_button_setting['padding_right'] . 'px;';
		$infinite_loader_load_more_button_style .= 'padding-bottom:' . $infinite_loader_button_setting['padding_bottom'] . 'px;';
		$infinite_loader_load_more_button_style .= 'padding-left:' . $infinite_loader_button_setting['padding_left'] . 'px;';
		$infinite_loader_load_more_button_style .= 'margin-top:' . $infinite_loader_lm_button_margin_top . 'px;';
		$infinite_loader_load_more_button_style .= 'margin-right:' . $infinite_loader_lm_button_margin_right . 'px;';
		$infinite_loader_load_more_button_style .= 'margin-bottom:' . $infinite_loader_lm_button_margin_bottom . 'px;';
		$infinite_loader_load_more_button_style .= 'margin-left:' . $infinite_loader_lm_button_margin_left . 'px;';
		$infinite_loader_load_more_button_style .= 'border-top: ' . $infinite_loader_lm_button_border_top . 'px solid ' . ( ! empty( $infinite_loader_button_setting['border_color'] ) ? $infinite_loader_button_setting['border_color'] : '#000' ) . ';';
		$infinite_loader_load_more_button_style .= 'border-bottom: ' . $infinite_loader_lm_button_border_bottom . 'px solid ' . ( ! empty( $infinite_loader_button_setting['border_color'] ) ? $infinite_loader_button_setting['border_color'] : '#000' ) . ';';
		$infinite_loader_load_more_button_style .= 'border-left: ' . $infinite_loader_lm_button_border_left . 'px solid ' . ( ! empty( $infinite_loader_button_setting['border_color'] ) ? $infinite_loader_button_setting['border_color'] : '#000' ) . ';';
		$infinite_loader_load_more_button_style .= 'border-right: ' . $infinite_loader_lm_button_border_right . 'px solid ' . ( ! empty( $infinite_loader_button_setting['border_color'] ) ? $infinite_loader_button_setting['border_color'] : '#000' ) . ';';
		$infinite_loader_load_more_button_style .= 'border-top-left-radius: ' . ( ( isset( $infinite_loader_button_setting['border_radius_top'] ) && ! empty( $infinite_loader_button_setting['border_radius_top'] ) ) ? $infinite_loader_button_setting['border_radius_top'] : '0' ) . 'px;';
		$infinite_loader_load_more_button_style .= 'border-top-right-radius: ' . ( ( isset( $infinite_loader_button_setting['border_radius_right'] ) && ! empty( $infinite_loader_button_setting['border_radius_right'] ) ) ? $infinite_loader_button_setting['border_radius_right'] : '0' ) . 'px;';
		$infinite_loader_load_more_button_style .= 'border-bottom-left-radius: ' . ( ( isset( $infinite_loader_button_setting['border_radius_bottom'] ) && ! empty( $infinite_loader_button_setting['border_radius_bottom'] ) ) ? $infinite_loader_button_setting['border_radius_bottom'] : '0' ) . 'px;';
		$infinite_loader_load_more_button_style .= 'border-bottom-right-radius: ' . ( ( isset( $infinite_loader_button_setting['border_radius_left'] ) && ! empty( $infinite_loader_button_setting['border_radius_left'] ) ) ? $infinite_loader_button_setting['border_radius_left'] : '0' ) . 'px;';
		return $infinite_loader_load_more_button_style;
	}

	/**
	 * Display load previews preview button.
	 */
	public static function infinite_loader_for_woocommerce_display_load_previous_button() {
		$infinite_loader_previous_button_setting  = get_option( 'infinite_loader_admin_previous_button_option' );
		$infinite_loader_prev_button_custom_class = isset( $infinite_loader_previous_button_setting['custom_class'] ) ? $infinite_loader_previous_button_setting['custom_class'] : '';
		$infinite_loader_prev_button_text         = isset( $infinite_loader_previous_button_setting['button_text'] ) ? $infinite_loader_previous_button_setting['button_text'] : '';
		$infinite_loader_prev_button_enable       = isset( $infinite_loader_previous_button_setting['enable_previous_button'] ) ? $infinite_loader_previous_button_setting['enable_previous_button'] : '';

		$infinite_loader_previous_button  = '<div class="infinite_loader_btn_load infinite_loader_prev_btn_setting">';
		$infinite_loader_previous_button .= '<a class="infinite_button ' . esc_attr( $infinite_loader_prev_button_custom_class ) . '" style="';
		$infinite_loader_previous_button .= apply_filters( 'infinite_loader_for_woocommerce_load_previous_button_style', '', );
		$infinite_loader_previous_button .= '" href="#load_previous_page">' . esc_html( $infinite_loader_prev_button_text ) . '</a>';
		$infinite_loader_previous_button .= '</div>';
		return $infinite_loader_previous_button;

	}

	/**
	 * The Function is responsible for the load previous button style.
	 */
	public function infinite_loader_for_woocommerce_previous_button_style() {
		$infinite_loader_load_previous_button_style = '';
		$infinite_loader_previous_button_setting    = get_option( 'infinite_loader_admin_previous_button_option' );
		$infinite_loader_prev_button_margin_top     = ( isset( $infinite_loader_previous_button_setting['margin_top'] ) && ! empty( $infinite_loader_previous_button_setting['margin_top'] ) ) ? $infinite_loader_previous_button_setting['margin_top'] : '0';
		$infinite_loader_prev_button_margin_right   = ( isset( $infinite_loader_previous_button_setting['margin_right'] ) && ! empty( $infinite_loader_previous_button_setting['margin_right'] ) ) ? $infinite_loader_previous_button_setting['margin_right'] : '0';
		$infinite_loader_prev_button_margin_bottom  = ( isset( $infinite_loader_previous_button_setting['margin_bottom'] ) && ! empty( $infinite_loader_previous_button_setting['margin_bottom'] ) ) ? $infinite_loader_previous_button_setting['margin_bottom'] : '0';
		$infinite_loader_prev_button_margin_left    = ( isset( $infinite_loader_previous_button_setting['margin_left'] ) && ! empty( $infinite_loader_previous_button_setting['margin_left'] ) ) ? $infinite_loader_previous_button_setting['margin_left'] : '0';
		$infinite_loader_prev_button_border_top     = ( isset( $infinite_loader_previous_button_setting['border_top'] ) && ! empty( $infinite_loader_previous_button_setting['border_top'] ) ) ? $infinite_loader_previous_button_setting['border_top'] : '0';
		$infinite_loader_prev_button_border_bottom  = ( isset( $infinite_loader_previous_button_setting['border_bottom'] ) && ! empty( $infinite_loader_previous_button_setting['border_bottom'] ) ) ? $infinite_loader_previous_button_setting['border_bottom'] : '0';
		$infinite_loader_prev_button_border_left    = ( isset( $infinite_loader_previous_button_setting['border_left'] ) && ! empty( $infinite_loader_previous_button_setting['border_left'] ) ) ? $infinite_loader_previous_button_setting['border_left'] : '0';
		$infinite_loader_prev_button_border_right   = ( isset( $infinite_loader_previous_button_setting['border_right'] ) && ! empty( $infinite_loader_previous_button_setting['border_right'] ) ) ? $infinite_loader_previous_button_setting['border_right'] : '0';

		$infinite_loader_load_previous_button_style .= 'font-size: ' . $infinite_loader_previous_button_setting['text_font_size'] . 'px;';
		$infinite_loader_load_previous_button_style .= 'color: ' . $infinite_loader_previous_button_setting['text_color'] . ';';
		$infinite_loader_load_previous_button_style .= 'background-color: ' . $infinite_loader_previous_button_setting['background_color'] . ';';
		$infinite_loader_load_previous_button_style .= 'padding-top:' . $infinite_loader_previous_button_setting['padding_top'] . 'px;';
		$infinite_loader_load_previous_button_style .= 'padding-right:' . $infinite_loader_previous_button_setting['padding_right'] . 'px;';
		$infinite_loader_load_previous_button_style .= 'padding-bottom:' . $infinite_loader_previous_button_setting['padding_bottom'] . 'px;';
		$infinite_loader_load_previous_button_style .= 'padding-left:' . $infinite_loader_previous_button_setting['padding_left'] . 'px;';
		$infinite_loader_load_previous_button_style .= 'margin-top:' . $infinite_loader_prev_button_margin_top . 'px;';
		$infinite_loader_load_previous_button_style .= 'margin-right:' . $infinite_loader_prev_button_margin_right . 'px;';
		$infinite_loader_load_previous_button_style .= 'margin-bottom:' . $infinite_loader_prev_button_margin_bottom . 'px;';
		$infinite_loader_load_previous_button_style .= 'margin-left:' . $infinite_loader_prev_button_margin_left . 'px;';
		$infinite_loader_load_previous_button_style .= 'border-top-color: ' . $infinite_loader_prev_button_border_top . 'px solid ' . ( ! empty( $infinite_loader_previous_button_setting['border_color'] ) ? $infinite_loader_previous_button_setting['border_color'] : '#000' ) . ';';
		$infinite_loader_load_previous_button_style .= 'border-right-color: ' . $infinite_loader_prev_button_border_bottom . 'px solid ' . ( ! empty( $infinite_loader_previous_button_setting['border_color'] ) ? $infinite_loader_previous_button_setting['border_color'] : '#000' ) . ';';
		$infinite_loader_load_previous_button_style .= 'border-bottom-color: ' . $infinite_loader_prev_button_border_left . 'px solid ' . ( ! empty( $infinite_loader_previous_button_setting['border_color'] ) ? $infinite_loader_previous_button_setting['border_color'] : '#000' ) . ';';
		$infinite_loader_load_previous_button_style .= 'border-left-color: ' . $infinite_loader_prev_button_border_right . 'px solid ' . ( ! empty( $infinite_loader_previous_button_setting['border_color'] ) ? $infinite_loader_previous_button_setting['border_color'] : '#000' ) . ';';
		$infinite_loader_load_previous_button_style .= 'border-top-left-radius: ' . ( ( isset( $infinite_loader_previous_button_setting['border_radius_top'] ) && ! empty( $infinite_loader_previous_button_setting['border_radius_top'] ) ) ? $infinite_loader_previous_button_setting['border_radius_top'] : '0' ) . 'px;';
		$infinite_loader_load_previous_button_style .= 'border-top-right-radius: ' . ( ( isset( $infinite_loader_previous_button_setting['border_radius_right'] ) && ! empty( $infinite_loader_previous_button_setting['border_radius_right'] ) ) ? $infinite_loader_previous_button_setting['border_radius_right'] : '0' ) . 'px;';
		$infinite_loader_load_previous_button_style .= 'border-bottom-left-radius: ' . ( ( isset( $infinite_loader_previous_button_setting['border_radius_bottom'] ) && ! empty( $infinite_loader_previous_button_setting['border_radius_bottom'] ) ) ? $infinite_loader_previous_button_setting['border_radius_bottom'] : '0' ) . 'px;';
		$infinite_loader_load_previous_button_style .= 'border-bottom-right-radius: ' . ( ( isset( $infinite_loader_previous_button_setting['border_radius_left'] ) && ! empty( $infinite_loader_previous_button_setting['border_radius_left'] ) ) ? $infinite_loader_previous_button_setting['border_radius_left'] : '0' ) . 'px;';
		return $infinite_loader_load_previous_button_style;
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
			$result .= '<span class="infinite_fa_fa_icon"><span class="infinite_icon_hover"></span><span class="infinite_icon_preview"><i class="fa ' . $infinite_icon . '"></i><span>' . $infinite_icon . '</span></span></span>';
		}
		$result .= '</div></div></div>';
		return $result;
	}
}
