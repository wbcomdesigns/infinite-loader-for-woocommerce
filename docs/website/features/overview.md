# What It Does

Infinite Loader for WooCommerce changes how the WooCommerce shop archive paginates. Instead of a full page reload for every page of products, the next page is fetched over AJAX and its products are added to the page in place.

## Where it applies

The plugin loads its assets and takes over pagination on WooCommerce product archives only:

- the main **shop** page;
- **product category** archives;
- **product tag** archives;
- other **product taxonomy** archives.

It does not run on the cart, checkout, single product, or non-WooCommerce pages. Developers can widen or narrow this with the `infinite_loader_should_load_assets` filter (see [Hooks and Filters](../developer-guide/hooks-and-filters.md)).

## How placement works

There is no shortcode and no block. The plugin hooks into the standard WooCommerce shop loop and result-count templates, so on any theme that renders its shop through the normal WooCommerce loop the loader appears automatically once a loading mode is selected. Themes that build their shop loop with non-standard markup can be pointed at the right elements with the selector filters.

## What it stores

The plugin stores four options in the WordPress `wp_options` table (general, button style, previous-button style, and custom CSS/JS). It creates no custom database tables, no custom post types, and no post meta.

## Feature summary

- Three loading modes: infinite scroll, Load More button, and AJAX pagination.
- A running result count that updates as pages are appended (for example "Showing 1-16 of 42 results").
- Optional address-bar tracking so the browser Back button returns the shopper to where they were.
- A configurable Font Awesome loading icon with an optional spin animation.
- Full styling controls for the Load More and Previous buttons (colours, size, padding, margin, border, radius).
- Custom CSS and before/after-update JavaScript fields.
- A cache-friendly next-page request that carries no per-visitor nonce, so full-page caches (WP Rocket, Varnish, Cloudflare) can still serve the shop.
- Filters and jQuery events for developers.
- Translation-ready, with RTL stylesheets.
