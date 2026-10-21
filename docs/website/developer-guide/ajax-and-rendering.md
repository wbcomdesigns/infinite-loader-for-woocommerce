# How Loading Works

Understanding the request cycle helps when debugging theme compatibility or caching.

## The request

The next-page request is a plain **GET to the archive page URL** (for example `/shop/page/2/`) carrying a single constant marker, `infinite_loader_ajax=1`. It is not a call to `admin-ajax.php`.

```javascript
$.ajax( {
    method: 'GET',
    url: next_page,                  // the WooCommerce archive URL
    data: { infinite_loader_ajax: 1 } // constant marker - keeps the response cacheable
} );
```

The script validates that the target URL is same-origin before requesting it, and keeps only the products, the result count, and the pagination out of the response, discarding the rest.

## The server side

The handler is registered on `template_redirect` (not on a `wp_ajax_` action) and lives on the admin class:

```php
// includes/class-infinite-loader-for-woocommerce.php
add_action( 'template_redirect', array( $plugin_admin, 'handle_infinite_loader_ajax' ) );
```

When the marker is present, the handler sets defensive response headers (`X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, `X-Robots-Tag: noindex, nofollow`) and then, by default, renders only the product grid before calling `exit`:

- it sets up the WooCommerce loop props so the result count is correct;
- it renders the result count, the product loop (using the theme's `content-product.php` and `woocommerce_shop_loop` hooks), and the pagination;
- nothing else (header, footer, sidebars) is rendered.

This "products only" response is built from the same loop templates the archive itself uses, so appended products match those rendered on first paint, and it is far smaller than a full page render. To fall back to rendering the whole archive (for a theme whose shop loop is non-standard), return false from `infinite_loader_render_products_only`.

## Why there is no nonce

The next-page request is deliberately nonce-free. It only reads a public shop archive and changes nothing, so a nonce, which protects state-changing requests against CSRF, would protect nothing here.

There is a positive reason to omit it too: a nonce is a per-visitor value, so putting one in the URL would make every request unique and defeat full-page caches (WP Rocket, Varnish, Cloudflare) so they could never serve the shop archive again. The constant marker keeps cached responses valid. The per-visitor nonce was removed in 1.3.0 for exactly this reason.

## The running result count

WooCommerce's result-count string normally describes only the current page. The plugin substitutes placeholder tokens into that string and keeps the real first/last numbers in `data-start` / `data-end` attributes, so the front-end script can rewrite the visible range as pages are appended (for example "Showing 1-16 of 42 results" after two pages have loaded).

## Options caching

Settings are read through a short-lived object cache (`wp_cache_*`, one hour) so repeated reads within a request are cheap. The cache is flushed on uninstall.
