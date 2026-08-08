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

## Where the work is tracked

Two places, deliberately, and they reconcile:

| | |
|---|---|
| **Basecamp board** | [Infinite Loader for WooCommerce](https://3.basecamp.com/5798509/projects/42374799) |
| **Cards to work** | **7** — 2 in Bugs, 4 in Scope, 1 in Ready for Development |
| **Checklist below** | **22** items on branch `1.2.4` |

**Why the two numbers differ.** A card is the trackable unit a person picks up; a checklist item is one verifiable step inside it. The portfolio-floor items in particular repeat across all 12 plugins — four suite-wide faults, counted once per plugin here.

**To verify progress:** the card is done when every checklist item it names is ticked in this file, on this branch. Neither source is authoritative alone — the board says what is being worked, this file says what "done" means.

## Current Task List

Ordered by how many store owners are affected, not by how interesting the code is.
Derived from a code audit on 2026-08-08 that verified every open Basecamp card against this branch.
**Work happens on this branch (`1.2.4`).**

### 1. Ship blocker - gate this release on it
- [ ] **The shipped `.min.js` is stale and every production site runs it.** Built at `13506ed` (16 Jun); the AJAX hardening landed at `5127dcd` (20 Jun) and was never rebuilt. Customers run code with no timeout, no URL validation, no scroll throttle, and a retry handler bound inside `complete:` that duplicates on every request - the repeating-products symptom. `public/class-infinite-loader-for-woocommerce-public.php:150-158` serves min whenever `SCRIPT_DEBUG` is off.
- [ ] **Add a build gate** that fails the release if any `.min.js` is older than its source, or this recurs silently.

### 2. Performance the owner will feel
- [ ] **Page caching is defeated** - a per-user nonce is appended to the archive URL (`public/js/infinite_loader_products.js:224-227`) so every request misses Varnish/WP Rocket/Cloudflare. That nonce is never verified for this request. Dropping it is a one-line change.
- [ ] **Each load re-renders the whole page** (`:221-223`, `:402`) and discards header/footer/menus. ~125 full renders to browse a 2,000-product catalogue.
- [ ] **Infinite scroll has no bottom-proximity check** (`:141-152`) - it chain-loads the catalogue on any scroll event.

### 3. Later - kills the theme-selector bug class
- [ ] Replace selector-based DOM scraping (`get_woocommerce_selectors()`, `:166-185`) with a REST route returning only product HTML. Size L. Not before the build fix.

### Do not rework
Four bug cards were closed on 2026-08-08 as already-fixed or wrong-premise. In particular, the proposed 5s TTL DOM cache would be a **regression** - the cache must invalidate on append, which `refresh()` at `:443` already does.

### What this plugin should have and does not (8 of 16)

**Store owner expects:**

- [ ] **Gutenberg block** - Block themes often never fire the classic WooCommerce hooks this plugin renders through, so the owner sees nothing and has no way to place it by hand.
- [ ] **Shortcode fallback** - Without one there is no escape hatch when the automatic placement does not fire.
- [ ] **Theme-overridable templates** - The owner cannot restyle output without editing plugin files, which an update overwrites.
- [ ] **Admin screen for stored data** - Anything the plugin stores, the owner must be able to see, moderate and export from wp-admin. Otherwise support means phpMyAdmin.

**Developer extending it expects:**

- [ ] **REST API** - No mobile app, headless storefront or external integration can reach this data.
- [ ] **Documented hooks/filters** - Developers extending the plugin have to read the source to find the extension points.
- [ ] **Test suite** - Nothing catches a regression before a customer does.
- [ ] **WPCS config** - Coding-standard drift is invisible until a WordPress.org review rejects it.
### Frontend, UX & code health

- [ ] **Cleanest plugin in the suite on static measures** - 0 block violations, 1 dead-code lead, 0 duplicate bodies, 19 tokens with 326 `var()` uses. Use it as the reference the others converge on.
- [ ] Its real problems are not code-health ones: the stale minified bundle and the cache-defeating nonce (main task list). Do those first.
- [ ] **No block and no shortcode** - the load-more surface cannot be placed on a block theme.
- [ ] 20 advisory violations remain, mostly focus rings and logical properties - the portfolio floor pass covers them.

### The standard every plugin in this suite is measured against
We are not auditing against each plugin's own history - we are auditing against what a WooCommerce plugin **should** provide a store owner and a developer extending it. Scored across all 12 plugins on 2026-08-08.

| Expectation | Who needs it | Suite score |
|---|---|---|
| Gutenberg block | owner | **0 / 12** |
| Admin screen for stored data | owner | **0 / 12** |
| REST API | developer | **0 / 12** |
| Test suite | developer | **0 / 12** |
| WPCS config | developer | 2 / 12 |
| Documented hooks/filters | developer | 3 / 12 |
| Theme-overridable templates | owner | 4 / 12 |
| Shortcode fallback | owner | 5 / 12 |
| RTL stylesheet | owner | 9 / 12 |
| CSS custom properties | owner | 9 / 12 |
| Conditional asset loading | owner | 9 / 12 |
| Clean uninstall | owner | 10 / 12 |
| First-run guidance | owner | 10 / 12 |
| Translation file | owner | 11 / 12 |
| CI config | developer | 11 / 12 |
| Settings screen | owner | 12 / 12 |

**The four zeros are the real backlog.** Every plugin has a settings screen; not one has a block, an admin screen for the data it stores, a REST route, or a test. Those four gaps explain more customer complaints than the entire open bug list does.

### Portfolio floor - one mechanical pass per plugin
- [ ] **Focus rings** - `outline: none` with no `:focus-visible` replacement, **98 occurrences suite-wide**. Keyboard users cannot see where they are.
- [ ] **RTL** - raw `margin-left` / `margin-right`, **96 occurrences suite-wide**. Use `margin-inline-start/end`.
- [ ] **Icons** - **62** Dashicons references; migrate to Lucide with a map for stored values.
- [ ] **No native dialogs** - **12** `alert()`/`confirm()` calls put a raw browser dialog in front of a shopper mid-purchase.

### Ground rules
- **Dead-code lists are leads, not delete lists.** `init_form_fields()`, `get_content_html()` and `get_content_plain()` are `WC_Email` overrides invoked through the parent class - they look unreferenced to a static scan and **must not be removed**. The same applies to callbacks reached only by `add_action` string name and CSS classes built in JS.
- **Deduplicate at the seam.** Where free and Pro share an identical function body, the fix is one owner plus an extension point, never the same edit twice.
- **One concern per PR**, so a regression bisects fast.

### Ground rules for this list
- A card is a lead, not a spec. Several open cards were found to be already fixed or factually wrong about this tree - re-verify before building.
- Fix at the seam, not on the screen that reported it. Where a fix has a shared cause, the entry below says so.
- Most customers do not run our themes. Verify on a generic theme (Storefront or a block theme), not only on Reign/BuddyX.

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
