# Infinite Loader for WooCommerce - Developer Guide

## Table of Contents
1. [Architecture Overview](#architecture-overview)
2. [File Structure](#file-structure)
3. [Hooks and Filters](#hooks-and-filters)
4. [JavaScript API](#javascript-api)
5. [AJAX Implementation](#ajax-implementation)
6. [Customization Guide](#customization-guide)
7. [Security Considerations](#security-considerations)
8. [Performance Optimization](#performance-optimization)
9. [Debugging Guide](#debugging-guide)
10. [Contributing](#contributing)

## Architecture Overview

The plugin follows WordPress coding standards and uses a modular architecture:

```
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│   Admin Class   │     │  Public Class   │     │   Main Class    │
│  (Settings UI)  │────▶│ (Frontend Logic)│◀────│  (Coordinator)  │
└─────────────────┘     └─────────────────┘     └─────────────────┘
         │                       │                        │
         └───────────────────────┴────────────────────────┘
                                 │
                         ┌───────▼────────┐
                         │  Loader Class  │
                         │ (Hook Manager) │
                         └────────────────┘
```

### Core Components

1. **Main Plugin Class** (`class-infinite-loader-for-woocommerce.php`)
   - Initializes the plugin
   - Loads dependencies
   - Defines hooks

2. **Admin Class** (`class-infinite-loader-for-woocommerce-admin.php`)
   - Handles settings pages
   - Processes form submissions
   - Manages admin assets

3. **Public Class** (`class-infinite-loader-for-woocommerce-public.php`)
   - Handles frontend functionality
   - Enqueues scripts and styles
   - Processes AJAX requests

4. **JavaScript Module** (`infinite_loader_products.js`)
   - Manages AJAX loading
   - Handles user interactions
   - Updates DOM elements

## File Structure

```
infinite-loader-for-woocommerce/
├── admin/
│   ├── class-infinite-loader-for-woocommerce-admin.php
│   ├── css/
│   │   └── infinite-loader-for-woocommerce-admin.css
│   ├── js/
│   │   ├── admin.js
│   │   └── infinite-loader-for-woocommerce-admin.js
│   └── partials/
│       ├── infinite-loader-for-woocommerce-setting-*.php
├── includes/
│   ├── class-infinite-loader-for-woocommerce.php
│   ├── class-infinite-loader-for-woocommerce-activator.php
│   ├── class-infinite-loader-for-woocommerce-deactivator.php
│   ├── class-infinite-loader-for-woocommerce-i18n.php
│   └── class-infinite-loader-for-woocommerce-loader.php
├── public/
│   ├── class-infinite-loader-for-woocommerce-public.php
│   ├── css/
│   │   └── infinite-loader-for-woocommerce-public.css
│   └── js/
│       └── infinite_loader_products.js
├── languages/
└── infinite-loader-for-woocommerce.php
```

## Hooks and Filters

### JavaScript Events

The plugin does not fire any PHP `do_action` hooks on the frontend. All frontend
extension points are jQuery events fired on `document` by
`public/js/infinite_loader_products.js`. Listen for them with `$(document).on(...)`.

```javascript
// AJAX loading is starting.
$(document).on('infinite_loader_product_start', function () { /* ... */ });

// Loading the previous page (Previous button / prepend).
$(document).on('infinite_loader_product_start_prev', function () { /* ... */ });

// Loading the next page (scroll / Load More / pagination).
$(document).on('infinite_loader_product_start_next', function () { /* ... */ });

// A batch of products has been requested (fired alongside the button-end event).
$(document).on('infinite_loader_ajax_load_products', function () { /* ... */ });

// A load cycle's button handling has finished.
$(document).on('infinite_loader_ajax_btn_end', function () { /* ... */ });

// New products are in the DOM - the event to reinitialise your own features.
$(document).on('infinite_loader_products_loaded', function () { /* ... */ });

// The plugin has (re)applied its inline styles.
$(document).on('infinite_loader_after_style_set', function () { /* ... */ });
```

### Filters

#### Loading Behaviour Filters

```php
// How close to the end of the product list infinite scroll starts loading,
// in pixels. Default 300. Raise it to prefetch earlier, lower it to load
// later. Before 1.3.0 there was no distance check at all and the whole
// catalogue loaded from the first scroll event.
add_filter( 'infinite_loader_scroll_threshold', function () {
    return 800;
} );

// Answer a load-more request with the product grid alone (default), or return
// false to render the full archive and let the script scrape it, as versions
// before 1.3.0 did.
//
// Only worth turning off for a theme that builds its shop loop somewhere
// other than the standard WooCommerce loop templates, where the appended
// markup can come back different from the markup rendered on first paint.
add_filter( 'infinite_loader_render_products_only', '__return_false' );
```

#### Selector Filters
```php
// Customize product container selector
add_filter('infinite_loader_products_selector', function($selector) {
    return 'ul.products, .custom-products';
});

// Customize product item selector
add_filter('infinite_loader_item_selector', function($selector) {
    return 'li.product, .custom-product-item';
});

// Customize pagination selector
add_filter('infinite_loader_pagination_selector', function($selector) {
    return 'nav.woocommerce-pagination, .custom-pagination';
});

// Customize the "next page" link selector (default 'a.next.page-numbers')
add_filter('infinite_loader_next_page_selector', function($selector) {
    return 'a.next.page-numbers, .my-next-link';
});

// Customize the "previous page" link selector (default 'a.prev.page-numbers')
add_filter('infinite_loader_prev_page_selector', function($selector) {
    return 'a.prev.page-numbers, .my-prev-link';
});
```

#### Style Filters
```php
// Modify Load More button inline style (2 args: style string, settings array)
add_filter('infinite_loader_for_woocommerce_load_more_button_style', function($style, $settings) {
    $style .= 'text-transform: uppercase;';
    return $style;
}, 10, 2);

// Modify Previous button inline style (2 args: style string, settings array)
add_filter('infinite_loader_for_woocommerce_load_previous_button_style', function($style, $settings) {
    $style .= 'text-transform: uppercase;';
    return $style;
}, 10, 2);

// Modify Load More button hover CSS (injected in wp_head)
add_filter('infinite_loader_lm_btn_hover_css', function($css) {
    $css .= '.infinite_button:hover { transform: scale(1.05); }';
    return $css;
});

// Modify Previous button hover CSS (injected in wp_head)
add_filter('infinite_loader_previous_btn_hover_css', function($css) {
    $css .= '.infinite_previous_button:hover { transform: scale(1.05); }';
    return $css;
});
```

#### Data Filters
```php
// Modify the whole localized JavaScript config object
add_filter('infinite_loader_js_data', function($data) {
    $data['custom_param'] = 'value';
    return $data;
});

// Modify the before/after-update JS snippets passed to the script
// (array with 'before_update' and 'after_update' keys)
add_filter('infinite_loader_js_function', function($js) {
    $js['after_update'] = 'console.log("products updated");';
    return $js;
});

// Customize products per page (also clamped to 1-100 by the plugin)
add_filter('infinite_loader_products_per_page', function($per_page) {
    return wp_is_mobile() ? 10 : 20;
});
```

#### Asset Loading Filter
```php
// Decide whether the plugin's CSS/JS load on the current request. By default
// they load on shop / product-category / product-tag / product-taxonomy
// archives only. Return true to force-load elsewhere, false to suppress.
add_filter('infinite_loader_should_load_assets', function($should_load) {
    return $should_load;
});
```

#### Loading Icon Filter
```php
// Replace the loading-icon HTML fragment shown while the next page is fetched.
add_filter('wbcom_infinite_loader_image', function($icon_html) {
    return '<div class="infinite_loader_products_loading"><span class="my-spinner"></span></div>';
});
```

#### Admin Filter
```php
// Add or reorder groups in the plugin's settings navigation (shared Wbcom
// settings shell). Receives and returns the nav-groups array.
add_filter('infinite_loader_settings_nav_groups', function($groups) {
    return $groups;
});
```

## JavaScript API

### Global Functions

```javascript
// Load next page programmatically
infinite_loader_load_next_page(replace, url);
// replace: true (replace products), false (append), 2 (prepend)
// url: optional custom URL

// Update plugin state
infinite_loader_update_state(reset_count);
// reset_count: boolean to reset product count

// Initialize buttons
infinite_loader_init_buttons();

// Update lazy loading
infinite_loader_update_lazyload();
```

### Configuration Object
```javascript
infinite_loader_product_data = {
    ajax_url: '',           // WordPress admin-ajax URL (present but unused by the loader)
    type: '',               // Loading type
    products: '',           // Products selector
    item: '',               // Item selector
    pagination: '',         // Pagination selector
    load_image: '',         // Loading HTML
    javascript: {
        before_update: '',  // JS to run before load
        after_update: ''    // JS to run after load
    }
};
```

### Custom Events

```javascript
// Listen for products loaded
$(document).on('infinite_loader_products_loaded', function() {
    // Reinitialize your features
    initializeTooltips();
    updateProductFilters();
});

// Modify loading behavior
$(document).on('infinite_loader_product_start', function() {
    // Show custom loader
    $('.my-custom-loader').show();
});
```

## AJAX Implementation

The next-page request is a plain **GET to the archive URL** with a single
constant marker, `infinite_loader_ajax=1`. There is no nonce: the request only
reads a public shop archive and changes nothing, and a per-user token in the URL
would make every request a cache miss (Varnish / WP Rocket / Cloudflare could no
longer serve the shop). See [Security Considerations](#security-considerations).

1. **Frontend Request** (`public/js/infinite_loader_products.js`)
```javascript
$.ajax({
    method: 'GET',
    url: next_page,               // the WooCommerce archive page URL, e.g. /shop/page/2/
    data: {
        'infinite_loader_ajax': 1 // constant marker - keeps the response cacheable
    },
    success: function (data) {
        // The script keeps only the products, result count and pagination
        // out of the returned markup and discards the rest.
    }
});
```

2. **Server Processing** (`Infinite_Loader_For_Woocommerce_Admin::handle_infinite_loader_ajax`)

The handler is registered by the main class on `template_redirect` and lives on
the **Admin** class, not the Public class:

```php
// includes/class-infinite-loader-for-woocommerce.php
add_action( 'template_redirect', array( $plugin_admin, 'handle_infinite_loader_ajax' ) );
```

```php
// admin/class-infinite-loader-for-woocommerce-admin.php
public function handle_infinite_loader_ajax() {
    // Only act on our own marked request.
    if ( ! isset( $_REQUEST['infinite_loader_ajax'] ) ) {
        return;
    }

    // Read-only public request - no nonce, by design (see Security Considerations).
    header( 'X-Content-Type-Options: nosniff' );
    header( 'X-Frame-Options: SAMEORIGIN' );
    header( 'X-Robots-Tag: noindex, nofollow' );

    // Render just the product grid (filterable), then exit.
    if ( ! apply_filters( 'infinite_loader_render_products_only', true ) ) {
        return; // fall back to the full themed archive render
    }

    $this->render_products_only();
}
```

By default the handler renders the **product grid alone** - result count,
product loop, pagination - built from the same loop templates the archive uses,
so appended products match those already on screen, and then `exit`s.

### Response Handling

```javascript
function processAjaxResponse(data, next_page, replace) {
    var $data = $('<div>').html(data);
    
    // Extract products
    var $products = $data.find(infinite_loader_product_data.products).html();
    
    // Update DOM
    if (replace === 1) {
        domCache.products.html($products);
    } else if (replace === 2) {
        handle_prepend_products($data);
    } else {
        domCache.products.append($products);
    }
    
    // Update pagination and counts
    update_pagination($data, replace);
    update_result_count($data, replace);
}
```

## Customization Guide

### Integration with Other Plugins

```javascript
// Example: Integrate with Isotope
$(document).on('infinite_loader_products_loaded', function() {
    if ($('.products').data('isotope')) {
        $('.products').isotope('reloadItems').isotope();
    }
});

// Example: Update product filters
$(document).on('infinite_loader_ajax_load_products', function() {
    if (typeof updateProductFilters === 'function') {
        updateProductFilters();
    }
});
```

### Custom Selectors for Themes

```php
// For custom theme structures
function my_theme_infinite_loader_selectors() {
    add_filter('infinite_loader_products_selector', function() {
        return '.my-products-grid';
    });
    
    add_filter('infinite_loader_item_selector', function() {
        return '.my-product-card';
    });
}
add_action('init', 'my_theme_infinite_loader_selectors');
```

## Security Considerations

### Why there is no nonce (by design)

The next-page request is a **read-only GET of a public shop archive**. It creates
nothing, updates nothing, and returns only markup any visitor could already load
by opening the same archive URL in a browser. A nonce protects against CSRF on
*state-changing* requests; there is no state to change here, so it protects
nothing.

There is a positive reason to leave it out, too: a nonce is a per-user value, so
putting one in the URL makes every request unique and defeats full-page caches -
Varnish, WP Rocket, Cloudflare and the like would never serve the shop archive
again. The marker `infinite_loader_ajax=1` is a constant, so cached responses
still work. The per-visitor nonce was removed in 1.3.0 for exactly this reason.

The handler still sets defensive response headers
(`X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`,
`X-Robots-Tag: noindex, nofollow`) and validates the target URL client-side
before requesting (see below). It does **not** call `wp_verify_nonce` /
`check_ajax_referer`.

### Output Escaping
```php
// Escape all output
echo '<div class="' . esc_attr($class) . '">';
echo esc_html($text);
echo '</div>';
```

### URL Validation
```javascript
// Validate URLs before using
function is_valid_url(url) {
    try {
        var parsedUrl = new URL(url, window.location.origin);
        return parsedUrl.origin === window.location.origin;
    } catch (e) {
        return false;
    }
}
```

## Licensing & Updates

When the `edd-license/` directory is present, the plugin wires itself to
[EDD Software Licensing](https://easydigitaldownloads.com/downloads/software-licensing/)
for automatic updates from `https://wbcomdesigns.com/`. If the directory is
absent (for example a wordpress.org build), none of this loads and the plugin
runs unlicensed.

**Where the key is entered:** the license row renders on the shared **WB Plugins
license screen** (`admin.php?page=wbcom-license-page`) via the shared
`wbcom_add_plugin_license_code` action, alongside every other Wbcom plugin's key.
The site owner pastes the key, clicks **Activate**, and can later **Deactivate**.

**What is stored (options table):**

| Option | Holds |
|---|---|
| `edd_wbcom_infinite_loader_license_key` | The license key string. |
| `edd_wbcom_infinite_loader_license_status` | Activation status (`valid`, `expired`, `invalid`, …). |

The last successful license check is cached in the transient
`edd_wbcom_infinite_loader_license_key_data` (12 hours). Entering a new key
clears the stored status so it must be re-activated. Activation and deactivation
requests to the store are `edd_action=activate_license` / `deactivate_license`;
update checks use `edd_action=get_version`.

## Performance Optimization

### Caching Strategies

```php
// Cache option values
private function get_cached_option($option_name) {
    $cache_key = 'infinite_loader_' . $option_name;
    $cached = wp_cache_get($cache_key);
    
    if (false === $cached) {
        $cached = get_option($option_name, array());
        wp_cache_set($cache_key, $cached, '', HOUR_IN_SECONDS);
    }
    
    return $cached;
}
```

### DOM Optimization

```javascript
// Cache jQuery objects
var domCache = {
    products: null,
    window: $(window),
    
    init: function() {
        this.products = $(infinite_loader_product_data.products);
    },
    
    refresh: function() {
        this.init();
    }
};
```

### Debouncing

```javascript
// Debounce scroll events
var scrollTimer;
$(window).on('scroll', function() {
    clearTimeout(scrollTimer);
    scrollTimer = setTimeout(function() {
        // Handle scroll
    }, 100);
});
```

### Lazy Loading

```javascript
// Implement lazy loading for images
function prepare_lazy_load_content($data) {
    $data.find('img').each(function() {
        var $img = $(this);
        $img.attr('data-src', $img.attr('src')).removeAttr('src');
    });
}
```

## Debugging Guide

### Enable Debug Mode

```php
// In wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true);
```

### JavaScript Debugging

```javascript
// Add debug logging
if (infinite_loader_product_data.debug_mode) {
    console.log('Loading products...', {
        type: infinite_loader_type,
        page: next_page,
        products: domCache.products.length
    });
}
```

### Common Issues

1. **Selectors Not Found**
```javascript
// Debug selectors
console.log('Products selector:', $(infinite_loader_product_data.products));
console.log('Found elements:', $(infinite_loader_product_data.products).length);
```

2. **AJAX Failures**
```javascript
// Add error handling
error: function(xhr, status, error) {
    console.error('AJAX Error:', {
        status: status,
        error: error,
        response: xhr.responseText
    });
}
```

3. **Hook Timing**
```php
// Check hook execution order
add_action('init', function() {
    error_log('Init hook fired');
}, 5);
```

## Contributing

### Code Standards

1. **PHP**
   - Follow WordPress PHP Coding Standards
   - Use proper sanitization and escaping
   - Add inline documentation

2. **JavaScript**
   - Use JSHint/ESLint
   - Follow WordPress JavaScript standards
   - Maintain browser compatibility

3. **CSS**
   - Use BEM methodology where applicable
   - Prefix all classes with `infinite_loader_`
   - Include RTL styles

### Testing

```bash
# PHP Testing
phpunit

# JavaScript Testing
npm test

# Coding Standards
phpcs --standard=WordPress .
```

### Pull Request Process

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

### Adding Features

1. **Plan the Feature**
   - Discuss in issues first
   - Consider backward compatibility
   - Think about performance impact

2. **Implement**
   - Add appropriate hooks
   - Include documentation
   - Add unit tests

3. **Test**
   - Test with various themes
   - Check different WooCommerce versions
   - Verify on mobile devices