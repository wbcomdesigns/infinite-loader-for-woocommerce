# Frequently Asked Questions

## Does this plugin require WooCommerce?

Yes. WooCommerce 3.0 or higher must be installed and active. If it is not, the plugin deactivates itself and shows a notice with a link to install WooCommerce.

## What are the loading modes?

Three: **Load More button** (shoppers click to see more), **Infinite scroll** (products load automatically as the shopper nears the end of the list), and **Pagination** (numbered pages fetched over AJAX with no full reload). See [Loading Modes](../features/loading-modes.md).

## Where do I change the settings?

**WB Plugins > Infinite Loader** in wp-admin. The Overview tab opens first and summarises what the plugin is doing; the General tab is where you choose the loading mode and products per page.

## How many products should load at a time?

The setting accepts 1 to 100. Fewer products (around 8 to 12) suit mobile and image-heavy catalogues; desktop can comfortably show more. Balance speed against how much the shopper sees per load.

## What does "Keep the address bar unchanged" do?

By default the address bar follows the shopper as they load more, so the browser Back button returns them to where they were. Turn this option on to leave the address bar alone.

## Which pages does it run on?

WooCommerce product archives only: the shop page, product category, product tag, and other product taxonomy archives. It does not run on the cart, checkout, or single product pages.

## Is there a shortcode or a block?

No. Placement is automatic through the standard WooCommerce shop loop, so the loader appears on any theme that renders its shop through the normal WooCommerce templates once a loading mode is selected. Themes with non-standard shop markup can be pointed at the right elements with the selector filters (see [Hooks and Filters](../developer-guide/hooks-and-filters.md)).

## Does it work with WooCommerce Blocks?

Yes. When WooCommerce Blocks is active, the plugin adds the block grid selectors automatically.

## Is it translation-ready?

Yes. All user-facing strings are translatable, and the button text can be translated. RTL stylesheets are included. A `.pot` template ships in the `languages` folder.

## Does the plugin store any customer or order data?

No. It stores only its own settings (four options) and, when licensed, the EDD license key and status. There are no custom tables, no custom post types, and no post meta. Everything it stores is removed on uninstall.

## Is the next-page request secure?

Yes. The plugin escapes everything it prints, sanitises the custom CSS and JavaScript you enter, validates the target URL client-side before requesting, and sets defensive response headers on the load-more response. The request is intentionally nonce-free because it only reads a public archive and a per-visitor nonce would break page caches. See [How Loading Works](../developer-guide/ajax-and-rendering.md).

## Does it slow down my shop?

The initial page loads fewer products, and later pages load without a full reload, so perceived performance usually improves. The load-more response returns only the product grid rather than a whole page, and the request stays cacheable. As always, optimise product images and keep caching enabled.
