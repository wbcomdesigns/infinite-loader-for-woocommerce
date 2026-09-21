# JavaScript Events and API

All front-end extension points are jQuery events fired on `document` by the loader script (`public/js/infinite_loader_products.js`). Listen for them with `$( document ).on( ... )`. Use them to re-initialise your own features on newly loaded products.

## Events

```javascript
// AJAX loading is starting.
$( document ).on( 'infinite_loader_product_start', function () { /* ... */ } );

// Loading the previous page (Previous button / prepend).
$( document ).on( 'infinite_loader_product_start_prev', function () { /* ... */ } );

// Loading the next page (scroll / Load More / pagination).
$( document ).on( 'infinite_loader_product_start_next', function () { /* ... */ } );

// A batch of products has been requested.
$( document ).on( 'infinite_loader_ajax_load_products', function () { /* ... */ } );

// A load cycle's button handling has finished.
$( document ).on( 'infinite_loader_ajax_btn_end', function () { /* ... */ } );

// New products are in the DOM - the event to reinitialise your own features.
$( document ).on( 'infinite_loader_products_loaded', function () { /* ... */ } );

// The plugin has (re)applied its inline styles.
$( document ).on( 'infinite_loader_after_style_set', function () { /* ... */ } );
```

The most useful of these is `infinite_loader_products_loaded`, which fires once the new products are in the page:

```javascript
$( document ).on( 'infinite_loader_products_loaded', function () {
    // Re-init a masonry layout, tooltips, quick-view, etc.
    initializeTooltips();
} );
```

## Global functions

The script exposes a few helpers on the page:

```javascript
// Load the next page. replace: true replaces, false appends, 2 prepends.
// url is an optional custom URL.
infinite_loader_load_next_page( replace, url );

// Recalculate plugin state; pass true to reset the running product count.
infinite_loader_update_state( reset_count );

// Re-bind the Load More / Previous buttons.
infinite_loader_init_buttons();

// Refresh lazy-loading state.
infinite_loader_update_lazyload();
```

## Configuration object

The plugin localises its configuration to `infinite_loader_product_data`. Notable keys:

| Key | Meaning |
|---|---|
| `type` | The active loading mode. |
| `products`, `item`, `pagination`, `next_page`, `prev_page` | The resolved CSS selectors. |
| `load_image` | The loading-icon HTML fragment. |
| `update_url` | `'1'` when the address bar should follow the shopper, `''` when it should not. |
| `scroll_threshold` | The infinite-scroll trigger distance in pixels. |
| `javascript` | An object with `before_update` and `after_update` snippet strings. |
| `debug_mode` | True when `WP_DEBUG` is on. |
| `ajax_url`, `ajax_nonce` | Present for compatibility but not used by the loader; the next-page request is a plain GET to the archive URL (see [How Loading Works](ajax-and-rendering.md)). |

## Integration example

```javascript
// Reflow an Isotope layout after each load.
$( document ).on( 'infinite_loader_products_loaded', function () {
    if ( $( '.products' ).data( 'isotope' ) ) {
        $( '.products' ).isotope( 'reloadItems' ).isotope();
    }
} );
```
