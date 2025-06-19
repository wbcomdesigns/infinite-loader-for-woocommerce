<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/public
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Infinite_Loader_For_Woocommerce
 * @subpackage Infinite_Loader_For_Woocommerce/public
 * @author     WBCOM Designs <admin@wbcomdesigns.com>
 */
class Infinite_Loader_For_Woocommerce_Public {

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
	 * WooCommerce selectors cache
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $selectors    Cached selectors.
	 */
	private $selectors;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $plugin_name The name of the plugin.
	 * @param    string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		// Only load on relevant pages
		if ( ! $this->infinite_loader_should_load_assets() ) {
			return;
		}
		
		$asset_config = $this->infinite_loader_get_asset_config();
		
		wp_enqueue_style( 
			$this->plugin_name, 
			plugin_dir_url( __FILE__ ) . 'css' . $asset_config['css_path'] . '/infinite-loader-for-woocommerce-public' . $asset_config['css_extension'], 
			array(), 
			$this->version, 
			'all' 
		);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		// Only load on relevant pages
		if ( ! $this->infinite_loader_should_load_assets() ) {
			return;
		}
		
		$asset_config = $this->infinite_loader_get_asset_config();
		
		wp_enqueue_script( 
			'infinite_loader_products', 
			plugin_dir_url( __FILE__ ) . 'js' . $asset_config['js_path'] . '/infinite-loader-for-woocommerce-public' . $asset_config['js_extension'], 
			array( 'jquery' ), 
			$this->version, 
			true // Load in footer for better performance
		);
	}

	/**
	 * Function set styles in wp_head WordPress action.
	 *
	 * @return void
	 */
	public function infinite_loader_for_woocommerce_display_custom_css() {
		if ( ! $this->infinite_loader_should_load_assets() ) {
			return;
		}
		
		$css_js_setting = $this->get_cached_option( 'infinite_loader_admin_css_js_option' );
		$custom_css     = isset( $css_js_setting['custom_css'] ) ? $css_js_setting['custom_css'] : '';
		
		if ( ! empty( $custom_css ) ) {
			echo '<style type="text/css">' . wp_strip_all_tags( $custom_css ) . '</style>';
		}
	}

	/**
	 * Check if assets should be loaded on current page
	 *
	 * @return bool True if assets should be loaded
	 */
	private function infinite_loader_should_load_assets() {
		// Allow filtering
		$should_load = is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy();
		
		return apply_filters( 'infinite_loader_should_load_assets', $should_load );
	}

	/**
	 * Get asset configuration for current environment
	 *
	 * @return array Asset paths and extensions
	 */
	private function infinite_loader_get_asset_config() {
		$is_debug = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
		$is_rtl   = is_rtl();
		
		return array(
			'css_extension' => $is_debug ? ( $is_rtl ? '.rtl.css' : '.css' ) : ( $is_rtl ? '.rtl.css' : '.min.css' ),
			'css_path'      => $is_debug ? ( $is_rtl ? '/rtl' : '' ) : ( $is_rtl ? '/rtl' : '/min' ),
			'js_extension'  => $is_debug ? '.js' : '.min.js',
			'js_path'       => $is_debug ? '' : '/min',
		);
	}

	/**
	 * Get WooCommerce selectors with filters
	 *
	 * @return array Filtered selectors
	 */
	private function get_woocommerce_selectors() {
		if ( null === $this->selectors ) {
			$this->selectors = array(
				'products'     => apply_filters( 'infinite_loader_products_selector', 'ul.products' ),
				'item'         => apply_filters( 'infinite_loader_item_selector', 'li.product' ),
				'pagination'   => apply_filters( 'infinite_loader_pagination_selector', 'nav.woocommerce-pagination' ),
				'next_page'    => apply_filters( 'infinite_loader_next_page_selector', 'a.next.page-numbers' ),
				'prev_page'    => apply_filters( 'infinite_loader_prev_page_selector', 'a.prev.page-numbers' ),
				'result_count' => apply_filters( 'infinite_loader_result_count_selector', '.woocommerce-result-count' )
			);
			
			// Add support for WooCommerce blocks if active
			if ( $this->is_woocommerce_blocks_active() ) {
				$this->selectors['products'] .= ', .wc-block-grid__products';
				$this->selectors['item']     .= ', .wc-block-grid__product';
			}
		}
		
		return $this->selectors;
	}

	/**
	 * Check if WooCommerce blocks is active
	 *
	 * @return bool
	 */
	private function is_woocommerce_blocks_active() {
		return class_exists( 'Automattic\WooCommerce\Blocks\Package' );
	}

	/**
	 * Function to register font awesome css file.
	 *
	 * @return void
	 */
	public function infinite_loader_for_woocommerce_enqueue_fontawesome_file() {
		if ( ! $this->infinite_loader_should_load_assets() ) {
			return;
		}
		
		$general_setting = $this->get_cached_option( 'infinite_loader_admin_general_option' );
		$enable_fa       = isset( $general_setting['enable_font_awesome'] ) ? $general_setting['enable_font_awesome'] : '';
		
		if ( 'yes' === $enable_fa ) {
			wp_enqueue_style( 
				'font-awesome-5', 
				plugins_url( 'css/fontawesome5.min.css', __FILE__ ), 
				array(), 
				$this->version, 
				'all' 
			);
		}
	}

	/**
	 * Function includes the css and js of loading products.
	 */
	public function infinite_loader_add_css_js_for_loading_products() { 
		if ( ! $this->infinite_loader_should_load_assets() ) {
			return;
		}
		
		$asset_config = $this->infinite_loader_get_asset_config();
		
		wp_enqueue_script( 
			'infinite_loader_products_js', 
			plugins_url( 'js' . $asset_config['js_path'] . '/infinite_loader_products' . $asset_config['js_extension'], __FILE__ ), 
			array( 'jquery' ), 
			$this->version, 
			true 
		);
		
		wp_enqueue_style( 
			'infinite_loader_products_css', 
			plugins_url( 'css' . $asset_config['css_path'] . '/infinite_loader_products' . $asset_config['css_extension'], __FILE__ ), 
			array(), 
			$this->version, 
			'all' 
		);
		
		$this->infinite_loader_for_woocommerce_display_button();
	}

	/**
	 * Display Load Products Button on Front-end.
	 */
	public function infinite_loader_for_woocommerce_display_button() {
		$general_settings   = $this->get_cached_option( 'infinite_loader_admin_general_option' );
		$button_settings    = $this->get_cached_option( 'infinite_loader_admin_button_option' );
		$prev_button_settings = $this->get_cached_option( 'infinite_loader_admin_previous_button_option' );
		$css_js_settings    = $this->get_cached_option( 'infinite_loader_admin_css_js_option' );
		
		$check_rotate      = isset( $general_settings['rotate_image'] ) && 'yes' === $general_settings['rotate_image'];
		$page_loading_type = isset( $general_settings['product_loading_type'] ) ? $general_settings['product_loading_type'] : 'pagination';
		$use_prev_btn      = ( 'load-more-button' === $page_loading_type || 'infinity-scroll' === $page_loading_type ) ? 'yes' : '';
		
		// Get selectors
		$selectors = $this->get_woocommerce_selectors();
		
		$rotate_image_class = $check_rotate ? 'infinite_loader_rotate_image' : '';
		
		// Build loading icon
		$infinite_loader_icon = '<div class="infinite_loader_products_loading">';
		
		if ( isset( $general_settings['loading_image'] ) && isset( $general_settings['enable_font_awesome'] ) && 'yes' === $general_settings['enable_font_awesome'] ) {
			if ( substr( $general_settings['loading_image'], 0, 3 ) === 'fa-' ) {
				$infinite_loader_icon .= '<i class="fa ' . esc_attr( $general_settings['loading_image'] ) . ' ' . esc_attr( $rotate_image_class ) . '"></i>';
			} else {
				$infinite_loader_icon .= '<i class="fa ' . esc_attr( $rotate_image_class ) . '"><img class="infinite_loader_icon" src="' . esc_url( $general_settings['loading_image'] ) . '" alt=""></i>';
			}
		} else {
			$infinite_loader_icon .= '<i class="fa fa-spinner ' . esc_attr( $rotate_image_class ) . '"></i>';
		}
		$infinite_loader_icon .= '</div>';
		
		$load_more_button = Infinite_Loader_For_Woocommerce_Admin::infinite_loader_for_woocommerce_display_load_more_button();
		$previous_button  = Infinite_Loader_For_Woocommerce_Admin::infinite_loader_for_woocommerce_display_load_previous_button();
		
		$infinite_loader_icon = apply_filters( 'wbcom_infinite_loader_image', $infinite_loader_icon );
		
		// Prepare data for JavaScript
		$js_data = array(
			'ajax_url'       => admin_url( 'admin-ajax.php' ),
			'ajax_nonce'     => wp_create_nonce( 'infinite_loader_ajax_nonce' ),
			'type'           => $page_loading_type,
			'use_prev_btn'   => $use_prev_btn,
			'update_url'     => empty( $general_settings['do_not_update_url'] ),
			'load_image'     => $infinite_loader_icon,
			'load_img_class' => '.infinite_loader_products_loading',
			'load_more'      => $load_more_button,
			'load_prev'      => $previous_button,
			'javascript'     => apply_filters( 'infinite_loader_js_function', $css_js_settings ),
			'products'       => $selectors['products'],
			'item'           => $selectors['item'],
			'pagination'     => $selectors['pagination'],
			'next_page'      => $selectors['next_page'],
			'prev_page'      => $selectors['prev_page'],
			'error_message'  => esc_html__( 'Unable to load more products. Please try again.', 'infinite-loader-for-woocommerce' ),
			'retry_text'     => esc_html__( 'Retry', 'infinite-loader-for-woocommerce' ),
			'no_more_text'   => esc_html__( 'No more products', 'infinite-loader-for-woocommerce' ),
			'loading_text'   => esc_html__( 'Loading...', 'infinite-loader-for-woocommerce' ),
			'is_mobile'      => wp_is_mobile(),
			'debug_mode'     => defined( 'WP_DEBUG' ) && WP_DEBUG,
		);
		
		// Add compatibility data
		$js_data = apply_filters( 'infinite_loader_js_data', $js_data );
		
		wp_localize_script( 'infinite_loader_products_js', 'infinite_loader_product_data', $js_data );
	}

	/**
	 * This Function is sets the number of products at shop page.
	 *
	 * @param  int $product_per_page Current products per page.
	 * @return int                   Modified products per page.
	 */
	public function infinite_loader_set_product_per_page( $product_per_page ) {
		$general_settings = $this->get_cached_option( 'infinite_loader_admin_general_option' );
		
		if ( isset( $general_settings['product_per_page'] ) ) {
			$product_per_page = absint( $general_settings['product_per_page'] );
			
			// Set reasonable limits
			if ( $product_per_page < 1 ) {
				$product_per_page = 1;
			} elseif ( $product_per_page > 100 ) {
				$product_per_page = 100;
			}
		}
		
		return apply_filters( 'infinite_loader_products_per_page', $product_per_page );
	}

	/**
	 * Display the load more product count.
	 *
	 * @param string $template_name Hold the template name.
	 */
	public function infinite_loader_before_template_part( $template_name ) {
		if ( 'loop/result-count.php' === $template_name ) {
			add_filter( 'ngettext', array( $this, 'infinite_loader_products_count_additional' ), 1, 9999 );
			add_filter( 'ngettext_with_context', array( $this, 'infinite_loader_products_count_additional' ), 1, 9999 );
		}
	}

	/**
	 * Display Woocommerce count.
	 *
	 * @param  string $text Get Text.
	 * @return string
	 */
	public function infinite_loader_products_count_additional( $text ) {
		remove_filter( 'ngettext', array( $this, 'infinite_loader_products_count_additional' ), 1, 9999 );
		remove_filter( 'ngettext_with_context', array( $this, 'infinite_loader_products_count_additional' ), 1, 9999 );
		
		if ( class_exists( 'WC_Query' ) && method_exists( 'WC_Query', 'product_query' ) && function_exists( 'wc_get_loop_prop' ) ) {
			$total    = wc_get_loop_prop( 'total' );
			$per_page = wc_get_loop_prop( 'per_page' );
			$paged    = wc_get_loop_prop( 'current_page' );
			$first    = ( $per_page * $paged ) - $per_page + 1;
			$last     = min( $total, $per_page * $paged );
		} else {
			global $wp_query;
			$paged    = max( 1, $wp_query->get( 'paged' ) );
			$per_page = $wp_query->get( 'posts_per_page' );
			$total    = $wp_query->found_posts;
			$first    = ( $per_page * $paged ) - $per_page + 1;
			$last     = min( $total, $wp_query->get( 'posts_per_page' ) * $paged );
		}

		echo '<span class="infinite_loader_product_count" style="display: none;" data-text="';
		
		if ( 1 === $total ) {
			echo esc_attr__( 'Showing the single result', 'infinite-loader-for-woocommerce' );
		} elseif ( $total <= $per_page || -1 === $per_page ) {
			/* translators: %d: total results */
			printf( esc_attr__( 'Showing all %d results', 'infinite-loader-for-woocommerce' ), $total );
		} else {
			/* translators: 1: first result 2: last result 3: total results */
			printf( esc_attr__( 'Showing %1$d&ndash;%2$d of %3$d results', 'infinite-loader-for-woocommerce' ), -1, -2, $total );
		}
		
		echo '" data-start="' . esc_attr( $first ) . '" data-end="' . esc_attr( $last ) . '" data-laststart="' . esc_attr( $first ) . '" data-lastend="' . esc_attr( $last ) . '"></span>';
		
		return $text;
	}

	/**
	 * Add load more button Hover css on front-end.
	 */
	public function infinite_loader_add_load_more_hover_css() {
		if ( ! $this->infinite_loader_should_load_assets() ) {
			return;
		}
		
		$button_setting    = $this->get_cached_option( 'infinite_loader_admin_button_option' );
		$bg_hover_color    = isset( $button_setting['background_color_mouse_hover'] ) ? $button_setting['background_color_mouse_hover'] : '#0e4da0';
		$hover_text_color  = isset( $button_setting['text_color_mouse_hover'] ) ? $button_setting['text_color_mouse_hover'] : '#ffffff';
		
		$style = '
		.infinite_loader_btn_setting .infinite_button:hover {
			background-color: ' . esc_attr( $bg_hover_color ) . ' !important;
			color: ' . esc_attr( $hover_text_color ) . ' !important;
		}';
		
		$style = apply_filters( 'infinite_loader_lm_btn_hover_css', $style );
		
		if ( ! empty( $style ) ) {
			echo '<style type="text/css">' . wp_strip_all_tags( $style ) . '</style>';
		}
	}

	/**
	 * Add Previous button Hover css on front-end.
	 */
	public function infinite_loader_add_previous_hover_css() {
		if ( ! $this->infinite_loader_should_load_assets() ) {
			return;
		}
		
		$button_setting    = $this->get_cached_option( 'infinite_loader_admin_previous_button_option' );
		$bg_hover_color    = isset( $button_setting['background_color_mouse_hover'] ) ? $button_setting['background_color_mouse_hover'] : '#0e4da0';
		$hover_text_color  = isset( $button_setting['text_color_mouse_hover'] ) ? $button_setting['text_color_mouse_hover'] : '#ffffff';
		
		$style = '
		.infinite_loader_prev_btn_setting .infinite_button:hover {
			background-color: ' . esc_attr( $bg_hover_color ) . ' !important;
			color: ' . esc_attr( $hover_text_color ) . ' !important;
		}';
		
		$style = apply_filters( 'infinite_loader_previous_btn_hover_css', $style );
		
		if ( ! empty( $style ) ) {
			echo '<style type="text/css">' . wp_strip_all_tags( $style ) . '</style>';
		}
	}

	/** 
	 * This function adds the scroll to top button for Load More button and Infinity Scroll loading type.
	 * 
	 * @since 1.2.3
	 */
	public function infinite_loader_for_woo_scroll_top_button() {
		if ( ! $this->infinite_loader_should_load_assets() ) {
			return;
		}
		
		$general_settings = $this->get_cached_option( 'infinite_loader_admin_general_option' );
		$loading_type     = isset( $general_settings['product_loading_type'] ) ? $general_settings['product_loading_type'] : 'pagination';
		
		if ( 'load-more-button' === $loading_type || 'infinity-scroll' === $loading_type ) {
			?>
			<a href="#" class="infinity_loader_topbutton" aria-label="<?php esc_attr_e( 'Scroll to top', 'infinite-loader-for-woocommerce' ); ?>">
				<i class="fa-solid fa-circle-arrow-up fa-bounce fa-2xl"></i>
			</a>
			<?php
		}
	}

	/**
	 * Get cached option
	 *
	 * @param  string $option_name Option name.
	 * @return mixed               Option value.
	 */
	private function get_cached_option( $option_name ) {
		$cache_key = 'infinite_loader_' . $option_name;
		$cached    = wp_cache_get( $cache_key );
		
		if ( false === $cached ) {
			$cached = get_option( $option_name, array() );
			wp_cache_set( $cache_key, $cached, '', HOUR_IN_SECONDS );
		}
		
		return $cached;
	}

	/**
	 * Debug log helper
	 *
	 * @param mixed $message Message to log.
	 */
	private function debug_log( $message ) {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
			error_log( 'Infinite Loader: ' . print_r( $message, true ) );
		}
	}
}