# Troubleshooting

## Nothing changes on the shop page

1. Confirm WooCommerce is active. The plugin only runs when WooCommerce is present, and only on shop and product archive pages.
2. Confirm a loading mode is selected on **WB Plugins > Infinite Loader > General**. The Overview tab shows the mode currently in use.
3. Clear any full-page cache and your browser cache after changing settings.
4. Check the browser console (F12) for JavaScript errors, such as a jQuery conflict from another plugin.

## Products do not load, or the button does nothing

This is almost always a theme markup mismatch. The loader finds the product grid and page links by CSS selector, and the defaults assume standard WooCommerce markup (`ul.products`, `li.product`, `a.next.page-numbers`).

1. Test with a default WooCommerce-compatible theme such as Storefront. If it works there, the issue is your theme's markup.
2. Inspect the shop page and confirm the product container and the next-page link match the default selectors.
3. If they do not, point the plugin at the right elements with the selector filters (`infinite_loader_products_selector`, `infinite_loader_item_selector`, `infinite_loader_next_page_selector`, and so on). See [Hooks and Filters](../developer-guide/hooks-and-filters.md).

## Appended products look different from the ones already on screen

Some themes build their shop loop with non-standard markup, so the "products only" response can come back different from the first paint. Return false from `infinite_loader_render_products_only` to fall back to rendering the full archive and letting the script scrape it.

## The loading icon is missing

The default spinner uses Font Awesome. Make sure **Enable Font Awesome** is on in General settings; the plugin then loads its bundled Font Awesome on shop archives. If your theme also ships Font Awesome, either source works. You can replace the icon HTML entirely with the `wbcom_infinite_loader_image` filter.

## Duplicate products appear

Usually a caching or query-modification conflict.

1. Clear all caches (page cache, object cache, CDN).
2. Temporarily disable other plugins that modify the product query or add AJAX filtering, and re-test.
3. If you run a product-filter plugin, re-sync the loader after it updates the grid:

```javascript
$( document ).on( 'your_filter_plugin_complete', function () {
    infinite_loader_update_state( true );
} );
```

## Infinite scroll loads too eagerly or too late

Adjust the trigger distance with the `infinite_loader_scroll_threshold` filter. The default is 300 pixels; raise it to prefetch earlier, lower it to load later.

## Custom CSS or JavaScript from the settings does not apply

The CSS and JavaScript fields are sanitised on save. `@import`, `javascript:` URLs, and a set of dangerous JavaScript patterns (such as `eval(`, `innerHTML =`, `document.cookie`) are stripped out. If a rule or snippet disappears, it likely tripped one of those filters. Keep the JavaScript fields to simple DOM work, and for anything more involved enqueue your own script and listen for the plugin's jQuery events. See [Custom CSS and JavaScript](../usage/custom-css-and-js.md).

## Enabling deeper debugging

```php
// wp-config.php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'SCRIPT_DEBUG', true ); // also serves the unminified plugin scripts
```

With `SCRIPT_DEBUG` on, the plugin serves its unminified CSS and JavaScript, which is easier to read in the browser. With `WP_DEBUG` on, the loader script logs extra detail to the console.
