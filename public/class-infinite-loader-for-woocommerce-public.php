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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
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
		if( is_shop() ) {
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				$extension = is_rtl() ? '.rtl.css' : '.css';
				$path      = is_rtl() ? '/rtl' : '';
			} else {
				$extension = is_rtl() ? '.rtl.css' : '.min.css';
				$path      = is_rtl() ? '/rtl' : '/min';
			}

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css' . $path . '/infinite-loader-for-woocommerce-public' . $extension, array(), $this->version, 'all' ); 
		}		

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		
		if( is_shop() ) {
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				$extension = '.js';
				$path      = '';
			} else {
				$extension = '.min.js';
				$path      = '/min';
			}

			wp_enqueue_script( 'infinite_loader_products', plugin_dir_url( __FILE__ ) . 'js' . $path . '/infinite-loader-for-woocommerce-public' . $extension, array( 'jquery' ), $this->version, false );
		}
		
	}

	/**
	 * Function set styles in wp_head WordPress action.
	 *
	 * @return void
	 */
	public function infinite_loader_for_woocommerce_display_custom_css() {
		$infinite_loader_css_js_setting = get_option( 'infinite_loader_admin_css_js_option' );
		$infinite_loader_custom_css     = isset( $infinite_loader_css_js_setting['custom_css'] ) ? $infinite_loader_css_js_setting['custom_css'] : '';
		if ( ! empty( $infinite_loader_custom_css ) ) {
			echo '<style type="text/css">' . wp_kses_post( $infinite_loader_custom_css ) . '</style>';
		}
	}

	/**
	 * Function to register font awesome css file.
	 *
	 * @return void
	 */
	public function infinite_loader_for_woocommerce_enqueue_fontawesome_file() {
		$infinite_loader_general_setting       = get_option( 'infinite_loader_admin_general_option' );
		$infinite_loader_css_js_enable        = isset( $infinite_loader_general_setting['enable_font_awesome'] ) ? $infinite_loader_general_setting['enable_font_awesome'] : '';
		
		if ( $infinite_loader_css_js_enable ) {
			wp_enqueue_style( 'font-awesome-5', plugins_url( 'css/fontawesome5.min.css', __FILE__ ), array(), $this->version, 'all' );
		}
	}

	/**
	 * Function includes the css and js of loading products.
	 */
	public function infinite_loader_add_css_js_for_loading_products() { 
		if ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				$css_extension = is_rtl() ? '.rtl.css' : '.css';
				$css_path      = is_rtl() ? '/rtl' : '';

				$js_extension = '.js';
				$js_path      = '';
			} else {
				$css_extension = is_rtl() ? '.rtl.css' : '.min.css';
				$css_path      = is_rtl() ? '/rtl' : '/min';

				$js_extension = '.min.js';
				$js_path      = '/min';
			}

			wp_enqueue_script( 'infinite_loader_products_js', plugins_url( 'js' . $js_path . '/infinite_loader_products' . $js_extension, __FILE__ ), array( 'jquery' ), array(), $this->version, 'all' );
			wp_register_style( 'infinite_loader_products_css', plugins_url( 'css' . $css_path . '/infinite_loader_products' . $css_extension, __FILE__ ), array(), $this->version, 'all' );
			wp_enqueue_style( 'infinite_loader_products_css' );
			$this->infinite_loader_for_woocommerce_display_button();
		}
	}

	/**
	 * Display Load Products Button on Front-end.
	 */
	public function infinite_loader_for_woocommerce_display_button() {

		$infinite_loader_general_settings      = get_option( 'infinite_loader_admin_general_option' );
		$infinite_loader_lm_button_settings   = get_option( 'infinite_loader_admin_button_option' );
		$infinite_loader_prev_button_settings = get_option( 'infinite_loader_admin_previous_button_option' );
		$infinite_loader_selectors_settings   = get_option( 'infinite_loader_admin_selectors_option' );
		$infinite_loader_css_js_settings      = get_option( 'infinite_loader_admin_css_js_option' );
		$infinite_loader_check_rotate         = isset( $infinite_loader_general_settings['rotate_image'] ) ? $infinite_loader_general_settings['rotate_image'] : '';
		$infinite_loader_page_loading_type    = isset( $infinite_loader_general_settings['product_loading_type'] ) ? $infinite_loader_general_settings['product_loading_type'] : '';
		$infinite_loader_use_prev_btn         = ( 'load-more-button' === $infinite_loader_page_loading_type || 'infinity-scroll' === $infinite_loader_page_loading_type)  ? 'yes' : '';

		/** Hard coded this as to remove the selectors tab. */
		$wc_products_selector                 = apply_filters( 'infinite_loader_products_selector', 'ul.products' );
		$wc_item_selector                     = apply_filters( 'infinite_loader_item_selector', 'li.product' );
		$wc_pagination_selector               = apply_filters( 'infinite_loader_pagination_selector', 'nav.woocommerce-pagination' );
		$wc_next_page_selector                = apply_filters( 'infinite_loader_next_page_selector', 'a.next.page-numbers' );
		$wc_prev_page_selector                = apply_filters( 'infinite_loader_prev_page_selector', 'a.prev.page-numbers' );

		$rotate_image_class = '';
		if ( $infinite_loader_check_rotate ) {
			$rotate_image_class = 'infinite_loader_rotate_image';
		}
		
		$infinite_loader_icon = '<div class="infinite_loader_products_loading">';
		if ( isset( $infinite_loader_general_settings['loading_image'] ) && isset( $infinite_loader_general_settings['enable_font_awesome'] ) ) {
			if ( substr( $infinite_loader_general_settings['loading_image'], 0, 3 ) === 'fa-' ) {
				$infinite_loader_icon .= '<i class="fa ' . esc_attr( $infinite_loader_general_settings['loading_image'] ) . ' ' . esc_attr( $rotate_image_class ) . '"></i>';
			} else {
				$infinite_loader_icon .= '<i class="fa ' . esc_attr( $rotate_image_class ) . '"><img class="infinite_loader_icon" src="' . esc_url( $infinite_loader_general_settings['loading_image'] ) . '" alt=""></i>';
			}
		} else {
			$infinite_loader_icon .= '<i class="fa fa-spinner ' . esc_attr( $rotate_image_class ) . '"></i>';
		}
		$infinite_loader_load_more_button = Infinite_Loader_For_Woocommerce_Admin::infinite_loader_for_woocommerce_display_load_more_button();
		$infinite_loader_previous_button  = Infinite_Loader_For_Woocommerce_Admin::infinite_loader_for_woocommerce_display_load_previous_button();
		
		$infinite_loader_icon = apply_filters( 'wbcom_infinite_loader_image', $infinite_loader_icon );

		wp_localize_script(
			'infinite_loader_products_js',
			'infinite_loader_product_data',
			array(
				'type'           => $infinite_loader_general_settings['product_loading_type'],
				'use_prev_btn'   => $infinite_loader_use_prev_btn,
				'update_url'     => empty( $infinite_loader_general_settings['do_not_update_url'] ), // if $general_options['update_url'] is set it means stop updating.
				'load_image'     => $infinite_loader_icon,
				'load_img_class' => '.infinite_loader_products_loading',

				'load_more'      => $infinite_loader_load_more_button,
				'load_prev'      => $infinite_loader_previous_button,
				'javascript'     => apply_filters( 'infinite_loader_js_function', $infinite_loader_css_js_settings ),
				'products'       => $wc_products_selector,
				'item'           => $wc_item_selector,
				'pagination'     => $wc_pagination_selector,
				'next_page'      => $wc_next_page_selector,
				'prev_page'      => $wc_prev_page_selector,
				'infinite_loader_btn_setting_load_image' => '',
				'infinite_loader_btn_setting_use_image' => '',
				'infinite_loader_prev_btn_setting_load_image' => '',
				'infinite_loader_prev_btn_setting_use_image' => '',
				'error_message' => esc_html__( 'Unable to load more products. Please try again.', 'infinite-loader-for-woocommerce' ),
				'retry_text' => esc_html__( 'Retry', 'infinite-loader-for-woocommerce' ),
				
			)
		);
	}

	/**
	 * This Function is sets the number of products at shop page.
	 *
	 * @return int Return the number of products to display.
	 */
	public function infinite_loader_set_product_per_page( $product_per_page ) {

		$infinite_loader_general_settings = get_option( 'infinite_loader_admin_general_option' );
		
		// Validate and sanitize the input
		if ( isset( $infinite_loader_general_settings['product_per_page'] ) ) {
			$product_per_page = absint( $infinite_loader_general_settings['product_per_page'] );
			
			// Set reasonable limits
			if ( $product_per_page < 1 ) {
				$product_per_page = 1;
			} elseif ( $product_per_page > 100 ) {
				$product_per_page = 100;
			}
		} else {
			$product_per_page = 16; // Default value
		}
		
		return $product_per_page;
	}

	/**
	 * Display the load more product count.
	 *
	 * @param  string $template_name Hold the template name.
	 */
	public function infinite_loader_before_template_part( $template_name ) {
		if ( $template_name == 'loop/result-count.php' ) {
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
			esc_html( 'Showing the single result', 'infinite-loader-for-woocommerce' );
		} elseif ( $total <= $per_page || -1 === $per_page ) {
			/* translators: %d: total results */
			printf( esc_html__( 'Showing all %d result', 'infinite-loader-for-woocommerce', $total, 'infinite-loader-for-woocommerce' ), $total ); //phpcs:ignore
		} else {
			/* translators: 1: first result 2: last result 3: total results */
			printf( esc_html( 'Showing %1$d&ndash;%2$d of %3$d result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'infinite-loader-for-woocommerce' ), -1, -2, $total ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		echo '" data-start="', esc_attr( $first ), '" data-end="', esc_attr( $last ), '" data-laststart=', esc_attr( $first ), ' data-lastend=', esc_attr( $last ), '></span>';
		return $text;
	}

	/**
	 * Add load more button Hover css on front-end.
	 */
	public function infinite_loader_add_load_more_hover_css() {
		$infinite_loader_button_setting     = get_option( 'infinite_loader_admin_button_option' );
		$infinite_loader_lm_bg_hover_color  = isset( $infinite_loader_button_setting['background_color_mouse_hover'] ) ? $infinite_loader_button_setting['background_color_mouse_hover'] : '';
		$infinite_loader_lm_hover_txt_color = isset( $infinite_loader_button_setting['text_color_mouse_hover'] ) ? $infinite_loader_button_setting['text_color_mouse_hover'] : '';

		echo '<style>';
		$style     = '
                .infinite_loader_btn_setting .infinite_button:hover {
                    background-color: ' . $infinite_loader_lm_bg_hover_color . ' !important;
                    color: ' . $infinite_loader_lm_hover_txt_color . '!important;
                }';
			$style = apply_filters( 'infinite_loader_lm_btn_hover_css', $style );
		if ( ! empty( $style ) ) {
			echo wp_kses_post( $style );
		}
		echo '</style>';

	}

	/**
	 * Add Previous button Hover css on front-end.
	 */
	public function infinite_loader_add_previous_hover_css() {
		$infinite_loader_button_setting           = get_option( 'infinite_loader_admin_previous_button_option' );
		$infinite_loader_previous_bg_hover_color  = isset( $infinite_loader_button_setting['background_color_mouse_hover'] ) ? $infinite_loader_button_setting['background_color_mouse_hover'] : '';
		$infinite_loader_previous_hover_txt_color = isset( $infinite_loader_button_setting['text_color_mouse_hover'] ) ? $infinite_loader_button_setting['text_color_mouse_hover'] : '';

		echo '<style>';
		$style     = '
                .infinite_loader_prev_btn_setting .infinite_button:hover {
                    background-color: ' . $infinite_loader_previous_bg_hover_color . ' !important;
                    color: ' . $infinite_loader_previous_hover_txt_color . '!important;
                }';
			$style = apply_filters( 'infinite_loader_previous_btn_hover_css', $style );
		if ( ! empty( $style ) ) {
			echo wp_kses_post( $style );
		}
		echo '</style>';

	}

	/** 
	 * This function adds the scroll to top button for Load More button and Infinity Scroll loading type.
	 * 
	 * @since 1.2.3
	 */
	public function infinite_loader_for_woo_scroll_top_button() { 

		$infinite_loader_general_settings  = get_option( 'infinite_loader_admin_general_option' );

		if( ! empty( $infinite_loader_general_settings['product_loading_type'] ) && ( 'load-more-button' === $infinite_loader_general_settings['product_loading_type'] || 'infinity-scroll' === $infinite_loader_general_settings['product_loading_type'] ) ) { ?>
		<a href="#" class="infinity_loader_topbutton"><i class="fa-solid fa-circle-arrow-up fa-bounce fa-2xl"></i></a>
	
		<?php }
	} 
}
