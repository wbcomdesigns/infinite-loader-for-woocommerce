# Hooks and Filters

The plugin's main extension surface is a set of PHP filters. There are no plugin-defined `do_action` hooks on the front end; front-end extension points are jQuery events (see [JavaScript Events and API](javascript-events.md)).

## Selector filters

The loader finds the product grid and the page links by CSS selector. These filters let you point it at non-standard theme markup. When WooCommerce Blocks is active, the block grid selectors are added automatically.

```php
// Product container. Default: 'ul.products'
add_filter( 'infinite_loader_products_selector', function ( $selector ) {
    return 'ul.products, .custom-products';
} );

// A single product item. Default: 'li.product'
add_filter( 'infinite_loader_item_selector', function ( $selector ) {
    return 'li.product, .custom-product-item';
} );

// The pagination container. Default: 'nav.woocommerce-pagination'
add_filter( 'infinite_loader_pagination_selector', function ( $selector ) {
    return 'nav.woocommerce-pagination, .custom-pagination';
} );

// The "next page" link. Default: 'a.next.page-numbers'
add_filter( 'infinite_loader_next_page_selector', function ( $selector ) {
    return 'a.next.page-numbers, .my-next-link';
} );

// The "previous page" link. Default: 'a.prev.page-numbers'
add_filter( 'infinite_loader_prev_page_selector', function ( $selector ) {
    return 'a.prev.page-numbers, .my-prev-link';
} );
```

## Loading behaviour filters

```php
// How close, in pixels, to the end of the list infinite scroll starts loading.
// Default 300. Raise to prefetch earlier, lower to load later.
add_filter( 'infinite_loader_scroll_threshold', function () {
    return 800;
} );

// Answer a load-more request with just the product grid (default true), or
// return false to render the full archive and let the script scrape it, which
// suits themes that build their shop loop outside the standard WooCommerce
// loop templates.
add_filter( 'infinite_loader_render_products_only', '__return_false' );

// Products per page. Also clamped to 1-100 by the plugin.
add_filter( 'infinite_loader_products_per_page', function ( $per_page ) {
    return wp_is_mobile() ? 10 : 20;
} );

// Whether the plugin's CSS/JS load on the current request. Default: true on
// shop / product-category / product-tag / product-taxonomy archives only.
add_filter( 'infinite_loader_should_load_assets', function ( $should_load ) {
    return $should_load;
} );
```

## Button style filters

```php
// Load More button inline style (style string, settings array).
add_filter( 'infinite_loader_for_woocommerce_load_more_button_style', function ( $style, $settings ) {
    $style .= 'text-transform: uppercase;';
    return $style;
}, 10, 2 );

// Previous button inline style (style string, settings array).
add_filter( 'infinite_loader_for_woocommerce_load_previous_button_style', function ( $style, $settings ) {
    $style .= 'text-transform: uppercase;';
    return $style;
}, 10, 2 );

// Load More button hover CSS, printed in wp_head.
add_filter( 'infinite_loader_lm_btn_hover_css', function ( $css ) {
    return $css . '.infinite_button:hover { transform: scale( 1.05 ); }';
} );

// Previous button hover CSS, printed in wp_head.
add_filter( 'infinite_loader_previous_btn_hover_css', function ( $css ) {
    return $css;
} );
```

## Data and icon filters

```php
// The whole config object localized to the front-end script.
add_filter( 'infinite_loader_js_data', function ( $data ) {
    $data['custom_param'] = 'value';
    return $data;
} );

// The before/after-update JS snippets passed to the script (array with
// 'before_update' and 'after_update' keys).
add_filter( 'infinite_loader_js_function', function ( $js ) {
    $js['after_update'] = 'console.log( "products updated" );';
    return $js;
} );

// The loading-icon HTML fragment shown while the next page is fetched.
add_filter( 'wbcom_infinite_loader_image', function ( $icon_html ) {
    return '<div class="infinite_loader_products_loading"><span class="my-spinner"></span></div>';
} );
```

## Admin filter

```php
// Add or reorder groups in the settings navigation (shared Wbcom settings
// shell). Receives and returns the nav-groups array.
add_filter( 'infinite_loader_settings_nav_groups', function ( $groups ) {
    return $groups;
} );
```

The shell also fires an `infinite_loader_settings_tab_content` action per tab, which the plugin uses internally to render each settings partial.
