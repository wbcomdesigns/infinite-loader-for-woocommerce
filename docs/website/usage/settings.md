# Settings Reference

All settings live under **WB Plugins > Infinite Loader** in wp-admin, on the settings page at `admin.php?page=infinite-loader-for-woocommerce-settings`. The screen is available to users with the `manage_woocommerce` capability.

The settings are organised into tabs: **Overview**, **General**, **Button Style**, **Previous Button Style**, **JavaScript/CSS**, and **FAQ**.

## Overview tab

A read-only summary of how your shop currently loads products: the loading style in use, products per load, whether the address bar follows the shopper, and WooCommerce status. It also links to the General tab and to your shop page. It is the tab that opens first.

## General tab

| Setting | What it does | Default |
|---|---|---|
| Products Loading Type | Load More button, Infinite scroll, or Pagination. See [Loading Modes](../features/loading-modes.md). | Load More button |
| Products Per Page | How many products load at a time. Clamped to 1-100. | 8 |
| Enable Font Awesome | Loads the bundled Font Awesome icons so you can pick a loading spinner. | On |
| Loading Image | The icon shown while more products load. Pick one from the icon grid, or keep the default spinner. Only appears when Font Awesome is enabled. | fa-spinner |
| Spin the icon while loading | Adds a spin animation to the loading icon. | On |
| Keep the address bar unchanged | By default the address bar follows the shopper so the Back button returns them where they were. Turn this on to leave the address bar alone. | Off (address bar follows) |

## Button Style and Previous Button Style tabs

Two tabs with the same set of fields: one for the Load More button, one for the Previous button. See [Button Styling](button-styling.md).

## JavaScript/CSS tab

Custom CSS and before/after-update JavaScript snippets. See [Custom CSS and JavaScript](custom-css-and-js.md).

## Where settings are stored

Settings are saved in the WordPress `wp_options` table:

| Option | Holds |
|---|---|
| `infinite_loader_admin_general_option` | General tab settings. |
| `infinite_loader_admin_button_option` | Load More button style. |
| `infinite_loader_admin_previous_button_option` | Previous button style. |
| `infinite_loader_admin_css_js_option` | Custom CSS and JavaScript. |

Each option is registered with its own sanitize callback, so values are validated on save. To change a setting in code, read the option, adjust it, and write it back:

```php
$options = get_option( 'infinite_loader_admin_general_option' );
$options['product_loading_type'] = 'infinity-scroll';
update_option( 'infinite_loader_admin_general_option', $options );
```
