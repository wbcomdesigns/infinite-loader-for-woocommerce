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
│       └── infinite-loader-for-woocommerce-welcome-page.php
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

### Actions

#### Frontend Actions
```php
// Triggered when AJAX loading starts
do_action('infinite_loader_product_start');

// Triggered when loading previous products
do_action('infinite_loader_product_start_prev');

// Triggered when loading next products
do_action('infinite_loader_product_start_next');

// Triggered after products are loaded
do_action('infinite_loader_ajax_load_products');

// Triggered after all AJAX operations complete
do_action('infinite_loader_ajax_btn_end');
```

#### JavaScript Events
```javascript
// Before products load
$(document).trigger('infinite_loader_product_start');

// After products load
$(document).trigger('infinite_loader_products_loaded');

// When style is set
$(document).trigger('infinite_loader_after_style_set');
```

### Filters

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
```

#### Style Filters
```php
// Modify load more button style
add_filter('infinite_loader_for_woocommerce_load_more_button_style', function($style, $settings) {
    $style .= 'text-transform: uppercase;';
    return $style;
}, 10, 2);

// Modify button hover CSS
add_filter('infinite_loader_lm_btn_hover_css', function($css) {
    $css .= '.infinite_button:hover { transform: scale(1.05); }';
    return $css;
});
```

#### Data Filters
```php
// Modify JavaScript data
add_filter('infinite_loader_js_data', function($data) {
    $data['custom_param'] = 'value';
    return $data;
});

// Customize products per page
add_filter('infinite_loader_products_per_page', function($per_page) {
    return is_mobile() ? 10 : 20;
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
    ajax_url: '',           // WordPress AJAX URL
    ajax_nonce: '',         // Security nonce
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

### Request Flow

1. **Frontend Request**
```javascript
$.ajax({
    url: next_page,
    data: {
        'infinite_loader_ajax': 1,
        'nonce': infinite_loader_product_data.ajax_nonce
    },
    beforeSend: function(xhr) {
        xhr.setRequestHeader('X-WP-Nonce', nonce);
    }
});
```

2. **Server Processing**
```php
// Hook into template_redirect
add_action('template_redirect', 'handle_infinite_loader_ajax');

function handle_infinite_loader_ajax() {
    if (!isset($_REQUEST['infinite_loader_ajax'])) {
        return;
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_REQUEST['nonce'], 'infinite_loader_ajax_nonce')) {
        wp_die('Security check failed');
    }
    
    // Let WordPress render the page normally
    // JavaScript will parse the response
}
```

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

### Adding Custom Loading Types

```php
// Add new loading type option
add_filter('infinite_loader_loading_types', function($types) {
    $types['custom-type'] = __('Custom Loading', 'text-domain');
    return $types;
});

// Handle custom type in JavaScript
add_filter('infinite_loader_js_data', function($data) {
    if ($data['type'] === 'custom-type') {
        $data['custom_behavior'] = true;
    }
    return $data;
});
```

### Custom Button Templates

```php
// Override button HTML
add_filter('infinite_loader_load_more_button_html', function($html) {
    return '<div class="custom-button-wrapper">
        <button class="custom-load-more">Load More</button>
    </div>';
});
```

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

### Nonce Verification
```php
// Always verify nonces in AJAX handlers
if (!wp_verify_nonce($_REQUEST['nonce'], 'infinite_loader_ajax_nonce')) {
    wp_die('Security check failed', 403);
}
```

### Input Sanitization
```php
// Sanitize all inputs
$page = isset($_GET['page']) ? absint($_GET['page']) : 1;
$per_page = isset($_GET['per_page']) ? absint($_GET['per_page']) : 12;
```

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