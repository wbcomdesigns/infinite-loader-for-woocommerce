# Infinite Loader for WooCommerce (infinite-loader-for-woocommerce)

## Plugin Identity
- **Plugin Name:** Wbcom Designs - Infinite Loader for WooCommerce
- **Main File:** `infinite-loader-for-woocommerce.php`
- **Text Domain:** `infinite-loader-for-woocommerce`
- **Version:** 1.2.2
- **Author:** Wbcom Designs
- **License:** GPL-2.0+
- **Requires WordPress:** 5.0+
- **Requires Plugins:** `woocommerce` (declared in the plugin header)
- **Pro Version:** none (single tier, EDD-licensed)
- **Basecamp:** https://3.basecamp.com/5798509/projects/42374799

## Names & Identity

Every surface this product is known by. When these drift, a site owner reports a bug under one name and support searches for another.

| Surface | Value |
|---|---|
| Plugin Name (what the site owner sees) | `Wbcom Designs – Infinite Loader for WooCommerce` |
| Install slug (`wp-content/plugins/`) | `infinite-loader-for-woocommerce` |
| Git repo | `infinite-loader-for-woocommerce` |
| Text domain | `infinite-loader-for-woocommerce` |
| readme.txt title | `Wbcom Designs – Infinite Loader for WooCommerce` |
| Basecamp board | `Infinite Loader for WooCommerce` (42374799) |
| Basecamp URL | https://3.basecamp.com/5798509/projects/42374799 |

## What It Does
Replaces WooCommerce's default shop pagination with infinite scroll or a Load More / Load Previous button. Products for the next page are fetched over AJAX and appended in place, so browsing a catalogue never triggers a full page load.

## Architecture

### Pattern
WordPress Plugin Boilerplate (loader pattern). `Infinite_Loader_For_Woocommerce_Loader` collects actions and filters; `Infinite_Loader_For_Woocommerce::run()` registers them.

### Key Files

| File | Purpose |
|------|---------|
| `infinite-loader-for-woocommerce.php` | Bootstrap, dependency guard, constants |
| `includes/class-infinite-loader-for-woocommerce.php` | Core class, loads dependencies, defines hooks |
| `includes/class-infinite-loader-for-woocommerce-loader.php` | Hook registration system |
| `includes/class-infinite-loader-for-woocommerce-activator.php` | Activation routine |
| `includes/class-infinite-loader-for-woocommerce-deactivator.php` | Deactivation routine |
| `includes/class-infinite-loader-for-woocommerce-i18n.php` | Text domain loading |
| `admin/class-infinite-loader-for-woocommerce-admin.php` | Settings screens, option registration |
| `public/class-infinite-loader-for-woocommerce-public.php` | Front-end: script data, selectors, button markup |
| `admin/wbcom/wbcom-admin-settings.php` | Shared Wbcom admin header/nav framework |
| `admin/wbcom/wbcom-paid-plugin-settings.php` | Shared Wbcom license UI |
| `edd-license/EDD_WB_Infinite_Loader_Plugin_Updater.php` | EDD Software Licensing updater |

### Assets
- `public/js/infinite_loader_products.js` - the scroll/append engine
- `public/js/infinite-loader-for-woocommerce-public.js`
- `admin/js/infinite-loader-for-woocommerce-admin.js`, `admin/js/admin.js`
- Matching CSS under `public/css/` and `admin/css/` with `rtl/` variants

Codebase: ~5,900 PHP LOC across 27 files.

## Constants

| Constant | Value |
|----------|-------|
| `INFINITE_LOADER_FOR_WOOCOMMERCE_VERSION` | `'1.2.2'` |
| `INFINITE_LOADER_FOR_WOOCOMMERCE_FILE` | `__FILE__` |
| `INFINITE_LOADER_FOR_WOOCOMMERCE_URL` | plugin URL |
| `INFINITE_LOADER_FOR_WOOCOMMERCE_PATH` | plugin path |
| `INFINITE_LOADER_FOR_WOOCOMMERCE_TEMPLATE_PATH` | `/templates/` |
| `EDD_INFINITE_LOADER_STORE_URL` | `'https://wbcomdesigns.com/'` |
| `EDD_INFINITE_LOADER_ITEM_NAME` | `'Infinite Loader For Woocommerce'` |
| `EDD_INFINITE_LOADER_PLUGIN_LICENSE_PAGE` | `'wbcom-license-page'` |

## Hooks & Filters (plugin-defined)

### Filters - the main extension surface
| Hook | Purpose |
|------|---------|
| `infinite_loader_item_selector` | CSS selector for a single product item |
| `infinite_loader_next_page_selector` | Selector used to find the next-page link |
| `infinite_loader_js_data` | Data array localized to the front-end script |
| `infinite_loader_js_function` | Override the JS init function |
| `infinite_loader_for_woocommerce_load_more_button_style` | Load More button inline style |
| `infinite_loader_for_woocommerce_load_previous_button_style` | Load Previous button inline style |
| `infinite_loader_lm_btn_hover_css` | Button hover CSS |

### Actions consumed from the shared Wbcom framework
`wbcom_add_header_menu`, `wbcom_add_plugin_license_code`

## Settings & Data

### Options (`wp_options`)
| Option | Purpose |
|--------|---------|
| `infinite_loader_admin_general_option` | General settings |
| `infinite_loader_admin_button_option` | Load More button settings |
| `infinite_loader_admin_previous_button_option` | Load Previous button settings |
| `infinite_loader_admin_css_js_option` | Custom CSS/JS settings |
| `infinite_loader_license_key` / `infinite_loader_license_status` | License state |
| `edd_wbcom_infinite_loader_license_key` / `_status` | EDD license state |

No custom tables, no post meta, no CPTs.

## Dependencies
- **WooCommerce** - hard dependency, declared via the `Requires Plugins` header *and* enforced by a runtime guard that deactivates the plugin.

## Development Notes
- **Theme selectors are the fragile seam.** The loader finds products and the next-page link by CSS selector. Any theme with non-standard shop markup needs `infinite_loader_item_selector` / `infinite_loader_next_page_selector` rather than a code change. Prefer widening the filter defaults over hardcoding a theme.
- **Test on a generic theme first** (Storefront / Twenty Twenty-*), not only on Reign or BuddyX. Most installs do not run a Wbcom theme.
- **Big-site behaviour:** this plugin *is* the pagination layer. Any change must be checked against a catalogue of 2,000+ products for query cost and duplicate-item bugs on rapid scroll.
- Two license option pairs exist (`infinite_loader_license_*` and `edd_wbcom_infinite_loader_license_*`). Confirm which one the updater actually reads before touching either - divergent key pairs are a known bug class in this portfolio.
