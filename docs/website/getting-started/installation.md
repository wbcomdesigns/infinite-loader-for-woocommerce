# Installation

Infinite Loader for WooCommerce replaces the default WooCommerce shop pagination with infinite scroll, a Load More button, or AJAX-powered numbered pages, so shoppers browse your catalogue without full page reloads.

## Requirements

| Requirement | Minimum |
|---|---|
| WordPress | 6.5 or higher |
| WooCommerce | 3.0 or higher (required) |
| PHP | 8.0 or higher |

WooCommerce is a hard dependency. It is declared in the plugin header (`Requires Plugins: woocommerce`) and enforced at runtime: if WooCommerce is not active the plugin deactivates itself and shows an admin notice with an "Install WooCommerce" link. If WooCommerce is older than 3.0 the plugin shows a version notice and stops.

The plugin declares compatibility with WooCommerce High-Performance Order Storage (HPOS).

## Install from a ZIP file

1. Download the plugin ZIP file.
2. In wp-admin, go to **Plugins > Add New > Upload Plugin**.
3. Choose the ZIP file and click **Install Now**.
4. Click **Activate**.

## After activation

- You are redirected to the plugin settings screen.
- A **WB Plugins** menu appears in the admin sidebar. Your settings live under **WB Plugins > Infinite Loader**.
- A **Settings** link is added to the plugin's row on the Plugins screen.

A fresh activation is usable immediately: the plugin seeds sensible defaults (Load More button, 8 products per load, spinning Font Awesome icon), so your shop shows the new behaviour before you open a single setting. Sites that upgrade from an earlier version keep whatever they had saved; the defaults are only applied where no value was ever stored.

## Uninstall

Deleting the plugin from the Plugins screen removes everything it stored: the four settings options and the EDD license key, status, and cached license data. This runs on single sites and across every site in a multisite network.
