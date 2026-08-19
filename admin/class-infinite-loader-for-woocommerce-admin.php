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
 * Defines the plugin name, version, and two hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/admin
 * @author     WBCOM Designs <admin@wbcomdesigns.com>
 */
class Infinite_Loader_For_Woocommerce_Admin {

	/**
	 * Settings page slug.
	 *
	 * Unchanged from the pre-shell admin so existing bookmarks, the plugin
	 * action link and any documentation still resolve.
	 *
	 * @since 1.2.4
	 * @var   string
	 */
	const PAGE_SLUG = 'infinite-loader-for-woocommerce-settings';

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

			// Add color picker.
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
	 * Register this plugin's screen on the shared Wbcom settings shell.
	 *
	 * The shell (lib/wbcom-settings/) owns the menu entry, the sidebar, tab
	 * routing, assets and third-party notice suppression. This plugin only
	 * contributes nav entries and tab bodies, through the two prefixed seams
	 * registered at the bottom of this method.
	 *
	 * @since 1.2.4
	 */
	public function boot_settings_page() {
		if ( ! class_exists( 'Wbcom_Settings_Page' ) ) {
			return;
		}

		Wbcom_Settings_Page::boot(
			array(
				'prefix'     => 'infinite_loader',
				'slug'       => self::PAGE_SLUG,
				'assets_url' => INFINITE_LOADER_FOR_WOOCOMMERCE_PLUGIN_URL,
				'version'    => $this->version,
				'icon'       => 'infinity',
				'labels'     => array(
					'menu_title' => __( 'Infinite Loader', 'infinite-loader-for-woocommerce' ),
					'brand'      => __( 'Infinite Loader', 'infinite-loader-for-woocommerce' ),
					'subtitle'   => __( 'Load more and infinite scroll for WooCommerce', 'infinite-loader-for-woocommerce' ),
					'nav_label'  => __( 'Infinite Loader settings sections', 'infinite-loader-for-woocommerce' ),
					'pro_badge'  => __( 'Pro', 'infinite-loader-for-woocommerce' ),
				),
			)
		);

		add_filter( 'infinite_loader_settings_nav_groups', array( $this, 'settings_nav_groups' ) );
		add_action( 'infinite_loader_settings_tab_content', array( $this, 'render_settings_tab' ) );
	}

	/**
	 * Create the shared "WB Plugins" parent menu when no other Wbcom plugin has.
	 *
	 * @since 1.2.4
	 */
	public function register_parent_menu() {
		if ( ! class_exists( 'Wbcom_Settings_Page' ) || ! empty( $GLOBALS['admin_page_hooks']['wbcomplugins'] ) ) {
			return;
		}

		add_menu_page(
			esc_html__( 'WB Plugins', 'infinite-loader-for-woocommerce' ),
			esc_html__( 'WB Plugins', 'infinite-loader-for-woocommerce' ),
			'manage_options',
			'wbcomplugins',
			array( 'Wbcom_Settings_Page', 'render_welcome' ),
			'dashicons-lightbulb',
			59
		);
	}

	/**
	 * Declare the settings nav.
	 *
	 * This array IS the tab registry: the shell builds the sidebar, the routing
	 * and the default tab from it, so adding a screen means one entry here plus
	 * a case in render_settings_tab().
	 *
	 * Overview leads, so opening the plugin answers "what is this doing to my
	 * shop right now?" before offering an input.
	 *
	 * @since  1.2.4
	 * @param  array $groups Groups declared so far.
	 * @return array
	 */
	public function settings_nav_groups( $groups ) {
		$groups['main'] = array(
			'label' => __( 'Infinite Loader', 'infinite-loader-for-woocommerce' ),
			'items' => array(
				'overview'        => array(
					'title' => __( 'Overview', 'infinite-loader-for-woocommerce' ),
					'icon'  => 'layout-dashboard',
				),
				'general'         => array(
					'title' => __( 'General', 'infinite-loader-for-woocommerce' ),
					'icon'  => 'settings-2',
				),
				'button'          => array(
					'title' => __( 'Button Style', 'infinite-loader-for-woocommerce' ),
					'icon'  => 'square-mouse-pointer',
				),
				'previous-button' => array(
					'title' => __( 'Previous Button Style', 'infinite-loader-for-woocommerce' ),
					'icon'  => 'arrow-up-narrow-wide',
				),
				'javascript-css'  => array(
					'title' => __( 'JavaScript/CSS', 'infinite-loader-for-woocommerce' ),
					'icon'  => 'code',
				),
			),
		);

		$groups['help'] = array(
			'label' => __( 'Help', 'infinite-loader-for-woocommerce' ),
			'items' => array(
				'faq' => array(
					'title' => __( 'FAQ', 'infinite-loader-for-woocommerce' ),
					'icon'  => 'circle-help',
				),
			),
		);

		return $groups;
	}

	/**
	 * Render one settings tab.
	 *
	 * Each partial owns its own <form>, settings_fields() and submit button, so
	 * the shell only has to place the right one.
	 *
	 * @since 1.2.4
	 * @param string $tab Current tab id.
	 */
	public function render_settings_tab( $tab ) {
		$this->verify_admin_request();

		switch ( $tab ) {
			case 'general':
				include 'partials/infinite-loader-for-woocommerce-setting-general-tab.php';
				break;

			case 'button':
				include 'partials/infinite-loader-for-woocommerce-setting-button-tab.php';
				break;

			case 'previous-button':
				include 'partials/infinite-loader-for-woocommerce-setting-previous-button-tab.php';
				break;

			case 'javascript-css':
				include 'partials/infinite-loader-for-woocommerce-setting-css-js-tab.php';
				break;

			case 'faq':
				include 'partials/infinite-loader-for-woocommerce-faq-tab.php';
				break;

			case 'overview':
			default:
				$this->render_overview_tab();
				break;
		}
	}

	/**
	 * The Overview tab: what the plugin is doing to this shop right now.
	 *
	 * @since 1.2.4
	 */
	private function render_overview_tab() {
		$general = get_option( 'infinite_loader_admin_general_option', array() );

		$mode      = isset( $general['product_loading_type'] ) ? $general['product_loading_type'] : 'pagination';
		$per_page  = isset( $general['product_per_page'] ) ? (int) $general['product_per_page'] : 0;
		$track_url = ! ( isset( $general['do_not_update_url'] ) && 'yes' === $general['do_not_update_url'] );

		$mode_labels = array(
			'infinity-scroll'   => __( 'Infinity Scroll', 'infinite-loader-for-woocommerce' ),
			'load-more-button'  => __( 'Load More button', 'infinite-loader-for-woocommerce' ),
			'pagination'        => __( 'AJAX pagination', 'infinite-loader-for-woocommerce' ),
		);
		$mode_label  = isset( $mode_labels[ $mode ] ) ? $mode_labels[ $mode ] : $mode;

		Wbcom_Settings_Page::card_open( __( 'How your shop loads products', 'infinite-loader-for-woocommerce' ) );
		?>
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><?php esc_html_e( 'Loading style', 'infinite-loader-for-woocommerce' ); ?></th>
				<td><?php echo esc_html( $mode_label ); ?></td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Products per load', 'infinite-loader-for-woocommerce' ); ?></th>
				<td>
					<?php
					echo $per_page > 0
						? esc_html( (string) $per_page )
						: esc_html__( 'Using the theme or WooCommerce default', 'infinite-loader-for-woocommerce' );
					?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Address bar follows the shopper', 'infinite-loader-for-woocommerce' ); ?></th>
				<td>
					<?php
					echo $track_url
						? esc_html__( 'Yes - the Back button returns them where they were', 'infinite-loader-for-woocommerce' )
						: esc_html__( 'No', 'infinite-loader-for-woocommerce' );
					?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'WooCommerce', 'infinite-loader-for-woocommerce' ); ?></th>
				<td>
					<?php
					echo defined( 'WC_VERSION' )
						/* translators: %s: WooCommerce version. */
						? esc_html( sprintf( __( '%s active', 'infinite-loader-for-woocommerce' ), WC_VERSION ) )
						: esc_html__( 'Not active', 'infinite-loader-for-woocommerce' );
					?>
				</td>
			</tr>
		</table>
		<p>
			<a class="wbcom-btn" href="<?php echo esc_url( Wbcom_Settings_Page::tab_url( self::PAGE_SLUG, 'general' ) ); ?>">
				<?php esc_html_e( 'Change how products load', 'infinite-loader-for-woocommerce' ); ?>
			</a>
			<a class="wbcom-btn" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
				<?php esc_html_e( 'View your shop', 'infinite-loader-for-woocommerce' ); ?>
			</a>
		</p>
		<?php
		Wbcom_Settings_Page::card_close();
	}

	/**
	 * Register the option groups the settings tabs save into.
	 *
	 * Only register_setting() now. The tab registry and add_settings_section()
	 * calls that used to live here went with the old admin shell: the nav comes
	 * from settings_nav_groups() and each partial owns its own form, so the
	 * Settings API is only needed for the save + sanitize contract.
	 *
	 * @since    1.0.9
	 * @access   public
	 * @author   Wbcom Designs
	 */
	public function infinite_loader_for_woocommerce_init_plugin_settings() {
		register_setting( 'infinite_loader_admin_general_options', 'infinite_loader_admin_general_option', array( $this, 'validate_general_settings' ) );
		register_setting( 'infinite_loader_admin_button_options', 'infinite_loader_admin_button_option', array( $this, 'validate_button_settings' ) );
		register_setting( 'infinite_loader_admin_previous_button_options', 'infinite_loader_admin_previous_button_option', array( $this, 'validate_button_settings' ) );
		register_setting( 'infinite_loader_admin_css_js_options', 'infinite_loader_admin_css_js_option', array( $this, 'validate_css_js_settings' ) );
	}

	/**
	 * Validate general settings
	 *
	 * @param  array $input Input data.
	 * @return array        Validated data.
	 */
	public function validate_general_settings( $input ) {
		$validated = array();

		// Validate product loading type.
		$allowed_types                     = array( 'infinity-scroll', 'load-more-button', 'pagination' );
		$validated['product_loading_type'] = isset( $input['product_loading_type'] ) && in_array( $input['product_loading_type'], $allowed_types, true )
			? $input['product_loading_type']
			: 'pagination';

		// Validate products per page.
		$validated['product_per_page'] = isset( $input['product_per_page'] ) ? absint( $input['product_per_page'] ) : 8;
		if ( $validated['product_per_page'] < 1 ) {
			$validated['product_per_page'] = 8;
		} elseif ( $validated['product_per_page'] > 100 ) {
			$validated['product_per_page'] = 100;
		}

		// Validate checkboxes.
		$validated['enable_font_awesome'] = isset( $input['enable_font_awesome'] ) && 'yes' === $input['enable_font_awesome'] ? 'yes' : '';
		$validated['rotate_image']        = isset( $input['rotate_image'] ) && 'yes' === $input['rotate_image'] ? 'yes' : '';
		$validated['do_not_update_url']   = isset( $input['do_not_update_url'] ) && 'yes' === $input['do_not_update_url'] ? 'yes' : '';

		// Validate loading image.
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

		// Text fields.
		$validated['custom_class'] = isset( $input['custom_class'] ) ? sanitize_html_class( $input['custom_class'] ) : '';
		$validated['button_text']  = isset( $input['button_text'] ) ? sanitize_text_field( $input['button_text'] ) : 'Load More';

		// Colors.
		$validated['background_color']             = isset( $input['background_color'] ) ? $this->sanitize_hex_color( $input['background_color'] ) : '#1d76da';
		$validated['background_color_mouse_hover'] = isset( $input['background_color_mouse_hover'] ) ? $this->sanitize_hex_color( $input['background_color_mouse_hover'] ) : '#0e4da0';
		$validated['border_color']                 = isset( $input['border_color'] ) ? $this->sanitize_hex_color( $input['border_color'] ) : '#1d76da';
		$validated['text_color']                   = isset( $input['text_color'] ) ? $this->sanitize_hex_color( $input['text_color'] ) : '#ffffff';
		$validated['text_color_mouse_hover']       = isset( $input['text_color_mouse_hover'] ) ? $this->sanitize_hex_color( $input['text_color_mouse_hover'] ) : '#ffffff';

		// Dimensions.
		$dimension_fields = array(
			'text_font_size',
			'padding_top',
			'padding_right',
			'padding_bottom',
			'padding_left',
			'margin_top',
			'margin_right',
			'margin_bottom',
			'margin_left',
			'border_top',
			'border_right',
			'border_bottom',
			'border_left',
			'border_radius_top',
			'border_radius_right',
			'border_radius_bottom',
			'border_radius_left',
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

		// Sanitize custom CSS.
		if ( isset( $input['custom_css'] ) ) {
			// Remove any script tags and PHP.
			$validated['custom_css'] = wp_strip_all_tags( $input['custom_css'] );

			// Remove @import statements to prevent external resource loading.
			$validated['custom_css'] = preg_replace( '/@import\s+(?:url\s*\(\s*)?["\']?[^"\')]+["\']?\s*\)?[^;]*;?/i', '', $validated['custom_css'] );

			// Remove JavaScript URLs.
			$validated['custom_css'] = preg_replace( '/javascript\s*:/i', '', $validated['custom_css'] );
		} else {
			$validated['custom_css'] = '';
		}

		// Sanitize JavaScript fields.
		$js_fields = array( 'before_update', 'after_update' );
		foreach ( $js_fields as $field ) {
			if ( isset( $input[ $field ] ) ) {
				$validated[ $field ] = $this->sanitize_javascript( $input[ $field ] );
			} else {
				$validated[ $field ] = '';
			}
		}

		return $validated;
	}

	/**
	 * Sanitize JavaScript code
	 *
	 * @param  string $js JavaScript code.
	 * @return string     Sanitized JavaScript.
	 */
	private function sanitize_javascript( $js ) {
		// Remove PHP tags.
		$js = str_replace( array( '<?php', '<?', '?>' ), '', $js );

		// Remove script tags.
		$js = preg_replace( '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $js );

		// Check for dangerous functions and patterns.
		$dangerous_patterns = array(
			'/\beval\s*\(/i',
			'/\bnew\s+Function\s*\([^)]*\)/i',
			'/\bdocument\.write/i',
			'/\bdocument\.writeln/i',
			'/\bdocument\.cookie/i',
			'/\blocalStorage/i',
			'/\bsessionStorage/i',
			'/\bwindow\.location\s*=/i',
			'/\bdocument\.location\s*=/i',
		);

		foreach ( $dangerous_patterns as $pattern ) {
			if ( preg_match( $pattern, $js ) ) {
				// Log security issue.
				error_log( 'Infinite Loader: Potentially dangerous JavaScript detected: ' . $pattern );

				// Remove the dangerous code.
				$js = preg_replace( $pattern, '/* Code removed for security */', $js );
			}
		}

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
	 * Display load more preview button.
	 */
	public static function infinite_loader_for_woocommerce_display_load_more_button() {
		$infinite_loader_button_setting  = get_option( 'infinite_loader_admin_button_option', array() );
		$infinite_loader_lm_custom_class = self::infinite_loader_get_option_value( $infinite_loader_button_setting, 'custom_class' );
		$infinite_loader_lm_button_text  = self::infinite_loader_get_option_value( $infinite_loader_button_setting, 'button_text', 'Load More' );

		$infinite_loader_load_more_button  = '<div class="infinite_loader_btn_load infinite_loader_btn_setting">';
		$infinite_loader_load_more_button .= '<a class="infinite_button ' . esc_attr( $infinite_loader_lm_custom_class ) . '" style="';

		// Get filtered styles.
		$button_styles                     = apply_filters( 'infinite_loader_for_woocommerce_load_more_button_style', '', $infinite_loader_button_setting );
		$infinite_loader_load_more_button .= esc_attr( $button_styles );

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

		// Get filtered styles.
		$button_styles                    = apply_filters( 'infinite_loader_for_woocommerce_load_previous_button_style', '', $infinite_loader_previous_button_setting );
		$infinite_loader_previous_button .= esc_attr( $button_styles );

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

		// Font size.
		$font_size = self::infinite_loader_get_dimension_value( $infinite_loader_button_setting, 'text_font_size', '16' );
		$styles[]  = 'font-size: ' . $font_size . 'px';

		// Colors.
		$text_color   = self::infinite_loader_get_option_value( $infinite_loader_button_setting, 'text_color', '#ffffff' );
		$bg_color     = self::infinite_loader_get_option_value( $infinite_loader_button_setting, 'background_color', '#1d76da' );
		$border_color = self::infinite_loader_get_option_value( $infinite_loader_button_setting, 'border_color', '#1d76da' );

		$styles[] = 'color: ' . $text_color;
		$styles[] = 'background-color: ' . $bg_color;

		// Padding.
		$padding_fields   = array( 'padding_top', 'padding_right', 'padding_bottom', 'padding_left' );
		$padding_defaults = array( '13', '30', '13', '30' );

		foreach ( $padding_fields as $index => $field ) {
			$value    = self::infinite_loader_get_dimension_value( $infinite_loader_button_setting, $field, $padding_defaults[ $index ] );
			$styles[] = str_replace( '_', '-', $field ) . ': ' . $value . 'px';
		}

		// Margin.
		$margin_fields = array( 'margin_top', 'margin_right', 'margin_bottom', 'margin_left' );

		foreach ( $margin_fields as $field ) {
			$value    = self::infinite_loader_get_dimension_value( $infinite_loader_button_setting, $field, '0' );
			$styles[] = str_replace( '_', '-', $field ) . ': ' . $value . 'px';
		}

		// Border.
		$border_fields = array( 'border_top', 'border_right', 'border_bottom', 'border_left' );

		foreach ( $border_fields as $field ) {
			$width    = self::infinite_loader_get_dimension_value( $infinite_loader_button_setting, $field, '1' );
			$side     = str_replace( 'border_', '', $field );
			$styles[] = 'border-' . $side . ': ' . $width . 'px solid ' . $border_color;
		}

		// Border radius.
		$radius_map = array(
			'border_radius_top'    => 'border-top-left-radius',
			'border_radius_right'  => 'border-top-right-radius',
			'border_radius_bottom' => 'border-bottom-right-radius',
			'border_radius_left'   => 'border-bottom-left-radius',
		);

		foreach ( $radius_map as $field => $css_property ) {
			$value    = self::infinite_loader_get_dimension_value( $infinite_loader_button_setting, $field, '50' );
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
		// Use the same logic as load more button.
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

		// Ensure numeric value.
		if ( ! is_numeric( $value ) ) {
			return $default;
		}

		$numeric_value = absint( $value );

		// Limit reasonable range (0-999px).
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
			// Properly escape the icon class.
			$escaped_icon = esc_attr( $infinite_icon );
			$result      .= '<span class="infinite_fa_fa_icon"><span class="infinite_icon_hover"></span><span class="infinite_icon_preview"><i class="fa ' . $escaped_icon . '"></i><span>' . esc_html( $infinite_icon ) . '</span></span></span>';
		}

		$result .= '</div></div></div>';

		return $result;
	}

	/**
	 * Mark the response to an archive load-more request.
	 *
	 * Deliberately unauthenticated: this only asks WordPress to render a public
	 * shop archive that any visitor can already open directly, and it changes no
	 * state, so there is nothing for a nonce to protect. Requiring one also made
	 * the plugin unusable behind a page cache, because the per-user value landed
	 * in the archive URL and turned every request into a cache miss.
	 *
	 * @since 1.0.0
	 */
	public function handle_infinite_loader_ajax() {
		// Check if this is an infinite loader AJAX request.
		if ( ! isset( $_REQUEST['infinite_loader_ajax'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only public archive request; see docblock.
			return;
		}

		// Add security headers.
		header( 'X-Content-Type-Options: nosniff' );
		header( 'X-Frame-Options: SAMEORIGIN' );
		header( 'X-Robots-Tag: noindex, nofollow' );

		/**
		 * Whether to answer with just the product grid instead of a whole page.
		 *
		 * Set false to fall back to rendering the full archive and letting the
		 * script scrape it, which is what every version before 1.2.4 did. Worth
		 * doing if a theme builds its shop loop somewhere other than the
		 * standard WooCommerce loop templates and the appended markup comes back
		 * different from the markup rendered on first paint.
		 *
		 * @param bool $products_only Default true.
		 */
		if ( ! apply_filters( 'infinite_loader_render_products_only', true ) ) {
			return;
		}

		$this->render_products_only();
	}

	/**
	 * Answer a load-more request with the product grid alone.
	 *
	 * The script only ever keeps the products, the result count and the
	 * pagination out of the response and throws the rest away, so rendering a
	 * whole page to serve one was pure waste: measured on a stock shop, 99,453
	 * bytes were sent to use 20,452 of them, and the theme rendered its header,
	 * footer, menus and sidebars every time. A 2,000 product catalogue cost
	 * about 125 full page renders to browse.
	 *
	 * The grid is built from the same loop templates the archive itself uses,
	 * so a theme's content-product.php override and any woocommerce_shop_loop
	 * hooks still apply and appended products match the ones already on screen.
	 *
	 * @since 1.2.4
	 */
	private function render_products_only() {
		global $wp_query;

		if ( ! function_exists( 'wc_setup_loop' ) || ! function_exists( 'wc_get_template_part' ) ) {
			return; // WooCommerce too old - fall back to the full render.
		}

		/*
		 * Take our own marker back out of the request before rendering.
		 * WooCommerce builds each add-to-cart link by appending to the current
		 * URL, so leaving it in produced links like
		 * /shop/page/2/?infinite_loader_ajax=1&add-to-cart=22 - and following
		 * one of those would hand the shopper a bare product grid with no
		 * header or footer, because this handler would answer that request too.
		 * We exit at the end of this method, so editing the request here cannot
		 * affect anything else.
		 */
		unset( $_GET['infinite_loader_ajax'], $_REQUEST['infinite_loader_ajax'] );
		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			$_SERVER['REQUEST_URI'] = remove_query_arg(
				'infinite_loader_ajax',
				esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) )
			);
		}

		// The archive template normally does this; we are answering before it
		// runs, so the loop props the result count reads have to be set here.
		wc_setup_loop(
			array(
				'name'         => 'infinite-loader',
				'is_shortcode' => false,
				'is_paginated' => true,
				'total'        => (int) $wp_query->found_posts,
				'total_pages'  => (int) $wp_query->max_num_pages,
				'per_page'     => (int) $wp_query->get( 'posts_per_page' ),
				'current_page' => max( 1, (int) $wp_query->get( 'paged', 1 ) ),
			)
		);

		header( 'Content-Type: text/html; charset=' . get_bloginfo( 'charset' ) );

		if ( have_posts() ) {
			woocommerce_result_count();

			woocommerce_product_loop_start();
			while ( have_posts() ) {
				the_post();
				wc_get_template_part( 'content', 'product' );
			}
			woocommerce_product_loop_end();

			woocommerce_pagination();
		}

		exit;
	}
}