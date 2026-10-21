# Loading Modes

The plugin offers three loading modes, chosen from **Products Loading Type** on the General tab. The stored values are `load-more-button`, `infinity-scroll`, and `pagination`.

## Load More button

A button is shown below the product grid. The shopper clicks it to append the next page of products. A Previous button is also available so the shopper can load earlier pages without a full reload.

Best for desktop and controlled browsing, where the shopper decides when to load more.

## Infinite scroll

The next page loads automatically as the shopper nears the end of the product list. The trigger fires when the bottom of the list comes within a set distance of the viewport (300 pixels by default), so the catalogue is not loaded all at once while the shopper is still near the top. Developers can change the distance with the `infinite_loader_scroll_threshold` filter.

Like Load More, this mode also exposes a Previous button for loading earlier pages.

Best for mobile and image-heavy catalogues where hands-free browsing suits the shopper.

## Pagination (AJAX)

Numbered page links are kept, but clicking one fetches that page over AJAX and replaces the grid in place instead of triggering a full page reload. The header, footer, and sidebars stay put.

Best for shoppers who prefer classic, precise page-by-page navigation.

## Shared behaviour

- **Products per page** applies to every mode and is clamped between 1 and 100.
- **Address-bar tracking** is on by default in every mode, so the browser Back button works as expected. It can be turned off (see [Settings Reference](../usage/settings.md)).
- **The result count** updates to describe what is on screen as pages are appended, rather than only the most recently loaded page.

## Loading icon and scroll-to-top

While a page is being fetched, a loading icon is shown. By default this is a spinning Font Awesome spinner. In Load More and Infinite scroll modes, a "scroll to top" button is also added to the storefront.
