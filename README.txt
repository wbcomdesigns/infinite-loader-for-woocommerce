=== Wbcom Designs – Infinite Loader for WooCommerce ===
Contributors: vapvarun,wbcomdesigns
Donate link: https://wbcomdesigns.com/
Tags: Woocommerce
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.0
Stable tag: 1.3.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Load your all WooCommerce products on single store page.

== Description ==

Infinite Loader for WooCommerce Plugin allows you to change the default product page pagination into Infinite Scroll or Ajax pagination with Lazy Load. When a user scrolls down to the bottom of the page, the next page loads automatically.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `infinite-loader-for-woocommerce.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Compatible Plugins =

Woocommerce

== Changelog ==
= 1.3.0 =
* Fix      - The FAQ tab now expands and collapses. Its accordion shipped with no styles at all, so every answer was permanently open and the questions looked like plain text.
* Fix      - Settings tabs show their default values on a site where the options have not been saved yet, instead of an empty Products Per Page box.
* Fix      - Custom CSS from the JavaScript/CSS tab now applies rules that use child or sibling combinators. Output was HTML-escaped inside the style tag, so a selector like "ul.products > li.product" shipped with an encoded arrow and silently never matched, while simple selectors kept working.
* Fix      - The bundled Font Awesome stylesheet now loads, so the default loading spinner is visible on themes that do not ship Font Awesome themselves. It was hooked too early to ever run.
* Fix      - Infinite scroll now waits until the shopper is near the end of the product list. It previously loaded the next page on any scroll, so the whole catalogue loaded while the shopper was still in the header.
* Fix      - Rebuilt the minified frontend scripts, which were four days behind their source. Production sites were running an older loader with no request timeout and no URL validation.
* Fix      - Removed the per-visitor nonce from the archive request so page caches (WP Rocket, Varnish, Cloudflare) can serve the shop again. The request only reads a public archive and changes nothing, so it never needed one.
* Fix      - Load More and Infinity Scroll now serve only the product grid instead of rendering the whole shop page and discarding the header, footer and sidebars. On a stock shop this cut the response from 118,878 to 21,338 bytes, and the products themselves are byte for byte what the page would have rendered.
* Fix      - AJAX pagination replaced the grid again instead of stacking the next page underneath the current one.
* Fix      - The result count now describes what is on screen ("Showing 1-16 of 17") instead of only the page that loaded last.
* Fix      - The address bar now follows the shopper down the archive again, so the browser Back button returns them to where they were instead of page one. This had never worked: the setting was read in a way that always resolved to off.
* Fix      - Button and Previous Button spacing fields (padding, margin, border, radius) now show which box each number controls and sit on one row, instead of four unlabelled stacked boxes.
* New      - Settings rebuilt on the shared Wbcom admin shell, matching the other Wbcom WooCommerce plugins, with a new Overview tab showing how the shop currently loads products.
* New      - Filter infinite_loader_scroll_threshold sets how close to the end of the list (in pixels, default 300) infinite scroll starts loading.
* New      - Filter infinite_loader_render_products_only returns false to go back to rendering the full archive, for themes that build their shop loop outside the standard WooCommerce loop templates.
* Improve  - Multisite uninstall uses the supported get_sites() API rather than a direct database query.
* Improve  - A fresh activation now defaults to Load More instead of classic pagination. Existing sites keep the setting they saved.
* Dev      - Settings registrations name their sanitize callback explicitly, and the user guide is no longer packaged in the release zip.
* Dev      - Added a build-freshness check (bin/verify-build-freshness.sh) that fails CI when a committed minified bundle does not match its source.

= 1.2.2 =
* Fix: (#25)Fixed save setting notice display
* Fix: (#24)Fixed set all to default btn show empty alert box
* Fix: (#23)Fixed update loader button icon removed

= 1.2.1 =
* Fix: Update admin wrapper UI

= 1.2.0 =
*Fix: (#20) Fixed plugin redirection issue when woocommerce is not activated
*Fix: (#21) Improved Admin UI
*Fix: (#22) Added link for the plugin activate
*Fix: Fixed WPCS issues 

= 1.1.0 =
*Fix: (#19) Update javascript/css tab string
*Fix: (#18) Changed welcome tab description
*Fix: (#6) Fixed Pagination count issue in Ajax pagination option
*Fix: (#12) Fixed Warning issue displaying on JavaScript/CSS admin setting tab

= 1.0.0 =
* Initial Relese
