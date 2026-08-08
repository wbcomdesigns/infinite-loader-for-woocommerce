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
| **Cards to work** | **9** — 2 in Bugs, 6 in Scope, 1 in Ready for Development |
| **Checklist below** | **49** items on branch `1.2.4` |

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

### Frontend token bridge - follow the theme, do not repaint it

The store owner sets their brand colour once at theme level and expects every plugin to follow. **Reign and BuddyX each ship a full
token system, and they are different vocabularies** - Reign defines no `--bx-*`, BuddyX defines no `--reign-*` - so the chain must
try both before falling back. Verified against reign-theme (112 tokens), buddyx (118) and both `theme.json` palettes.

| Role | BuddyX | Reign | Preset fallback |
|---|---|---|---|
| Accent | `--bx-color-accent` | `--reign-accent-color` | `primary` / `accent` |
| Page background | `--bx-color-bg-page` | `--reign-site-body-bg-color` | `base` |
| Raised surface | `--bx-color-bg-elevated` | `--reign-site-sections-bg-color` | - |
| Body text | `--bx-color-text` | `--reign-site-body-text-color` | `contrast` |
| Muted text | `--bx-color-fg-muted` | `--reign-site-alternate-text-color` | - |
| Headings | `--bx-color-heading` | `--reign-site-headings-color` | - |
| Border | `--bx-color-border` | `--reign-site-border-color` | - |
| Link | `--bx-color-link` | `--reign-site-link-color` | - |
| Button bg / fg | `--bx-color-button-bg` / `-fg` | `--reign-site-button-bg-color` / `-text-color` | - |
| Success / error | - | `--reign-color-success` / `--reign-color-error` | - |

**Watch the preset slugs too:** Reign's accent slug is `primary`, BuddyX's is `accent`, so `var(--wp--preset--color--primary)`
alone resolves to nothing on BuddyX.

```css
:root,
.infinite-app {
    /* BuddyX token, then Reign token, then both preset slugs, then a literal. */
    --infinite-accent: var(--bx-color-accent,
                  var(--reign-accent-color,
                  var(--wp--preset--color--primary,
                  var(--wp--preset--color--accent, #157dfd))));

    --infinite-bg:     var(--bx-color-bg-page,
                  var(--reign-site-body-bg-color,
                  var(--wp--preset--color--base, #ffffff)));

    --infinite-text:   var(--bx-color-text,
                  var(--reign-site-body-text-color,
                  var(--wp--preset--color--contrast, #1a1a1a)));

    --infinite-border: var(--bx-color-border,
                  var(--reign-site-border-color,
                  color-mix(in srgb, var(--infinite-text) 12%, transparent)));
}
```

- [ ] **Build the bridge block** above, with `surface` and `muted` alongside the four shown.
- [ ] **Components read only `--infinite-*` tokens.** No component references a theme token, a preset or a hex directly - that single indirection layer is what makes one theme change land everywhere, and what stops a third-party theme falling through to nothing.
- [ ] **Do not add a plugin-side dark class.** Reign and BuddyX both flip dark mode with the same root attribute, `[data-bx-mode="dark"]`. Because our tokens read from theme tokens, dark mode arrives for free. Forcing our own class produces a dark panel on a light page - a state the product never reaches - and you end up "fixing" bugs that do not exist.
- [ ] **Scope any standalone dark values so the theme always wins:** `@media (prefers-color-scheme: dark) { :root:not([data-bx-mode]) { ... } }`. Dark mode is a root token override, never a per-component rule.
- [ ] **Verify on Reign and BuddyX separately** - they resolve through different tokens, so passing on one proves nothing about the other. Change the theme accent, reload, confirm our output moved.
- [ ] **Toggle dark mode with the theme's own control**, never by hand-adding a class. If the theme chrome stays light while our panel darkens, you are in an artificial state - stop and use the real toggle.
- [ ] **Check a third-party theme** (Storefront or a block theme). Most customers run neither of ours; the preset and literal fallbacks are what they get and must look deliberate.

### Admin side of the token bridge

The frontend bridges to the theme. **wp-admin has no theme tokens** — it has its own colour scheme, chosen by each user in their
profile. Same component vocabulary, different source, so components are written once and work in both contexts.

```css
.infinite-admin {
    /* WordPress exposes these from the user's admin colour scheme.
       They are defined in block-library CSS, so always supply the fallback. */
    --infinite-accent:        var(--wp-admin-theme-color, #2271b1);
    --infinite-accent-strong: var(--wp-admin-theme-color-darker-10, #135e96);

    --infinite-bg:      #ffffff;
    --infinite-surface: #f6f7f7;
    --infinite-text:    #1d2327;
    --infinite-muted:   #646970;
    --infinite-border:  #dcdcde;
}
```

- [ ] **One vocabulary, two bridges.** `--infinite-accent`, `-bg`, `-surface`, `-text`, `-muted`, `-border` mean the same thing in both contexts; only the source differs. A component that reads them works on the front end and in wp-admin without a second implementation.
- [ ] **Admin accent follows the user's colour scheme** via `--wp-admin-theme-color`. Always pass the fallback — the variable is defined in block-library CSS and is not guaranteed present on a plain settings screen.
- [ ] **Do not reuse frontend theme tokens in admin.** `--bx-color-*` and `--reign-*` do not exist in wp-admin; referencing them there silently falls through to the literal, so the screen stops following the admin scheme.
- [ ] **Verify by switching admin colour scheme** (Users → Profile) and confirming the panel follows. The reference implementation does not do this — it hardcodes 33 hex values — so do not copy its palette, only its structure.

### No admin-ajax — REST or server-rendered

**Decision (2026-08-08): no `admin-ajax.php` anywhere.** Every call boots the whole WordPress admin stack before doing any work,
often just to read a row. REST skips that, is cacheable, is introspectable, and is the same surface a mobile or headless client
would use later.

**Where this plugin stands: 4 `admin-ajax` references, zero REST routes.** Suite-wide it is 137 references and 0 REST routes
across 12 plugins. Notable here: the archive fetch that currently appends a cache-defeating nonce.

- [ ] **Server-render first.** If the data is known at page render, emit it in the markup and delete the round trip entirely. Fastest option, and available more often than it looks.
- [ ] **Only genuinely async work becomes a REST route**, with a real `permission_callback` and a schema. Never `__return_true`.
- [ ] **Public routes are registered deliberately** for logged-out visitors, with their own nonce — never the admin one.
- [ ] **Do not port a broken guard.** Handlers in this suite use `if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce(...) )`, which is skipped entirely when the nonce is omitted. A REST `permission_callback` fails closed by default — keep it that way.
- [ ] **Migrate, do not double-register.** Leaving the old `wp_ajax_` action alive "for compatibility" keeps the vulnerable path alive.
- [ ] **Nonce is not authorisation.** Every route needs a capability check, plus an ownership check where it touches a record.
- [ ] **Done when** `grep` for `admin-ajax` and `ajaxurl` returns nothing in this plugin.

### Rebuild the admin panel to the standard shell

The one screen every store owner sees, and the least invested-in across the suite. Build to the pattern in
**Who Viewed My Profile** (`who-viewed-my-profile`, `/wp-admin/admin.php?page=bp-profile-views-settings` on the
release-skill site) - roughly 2,000 lines, already solved, copy it rather than reinvent.

```
includes/admin/class-<prefix>-admin.php   controller + get_tabs() registry + get_overview_stats()
includes/admin/views/shell.php            page header, sidebar nav, body slot
includes/admin/views/overview.php         stat tiles + config snapshot + quick actions
includes/admin/views/settings-*.php       one file per settings group
assets/css/admin.css
```

- [ ] **Land on an Overview, not a settings form.** Opening the plugin answers "what is this doing on my store right now?" before offering a single input.
- [ ] **This plugin's Overview should surface:** load mode in use (scroll or button), products per load, and which theme selectors resolved on this site.
- [ ] **Stat tiles each carry an explanatory caption.** A bare number is not information - the reference writes "Every row recorded in the profile-views table" under its count.
- [ ] **A "Current configuration" snapshot** written as consequences, not stored values - "Yes, anonymous visits are stored but filtered out of aggregate counts", never `exclude_logout_user_count: 1`.
- [ ] **Quick actions** routing to the tab that changes the thing just described.
- [ ] **Sidebar generated from a tab registry** - one array keyed by slug with `label`, `icon`, `group` (main / settings / account). Adding a screen touches one array, not markup in three places.
- [ ] **Version pill in the header; dependency state shown on screen** rather than rendering an empty dashboard.
- [ ] **Replace the shared `admin/wbcom/` header/nav framework** where present - do not layer the new shell on top of it.
- [ ] **Verify at 1440px and 390px, light and dark, LTR and RTL.** Colours from CSS custom properties, never hardcoded hex.

**Two things that will bite:**
- `<hr class="wp-header-end">` immediately after the header is **required**. Without it core's `common.js` re-parents every `.notice` to the first `<h1>` and the "Settings saved" banner lands between the title and subtitle. The reference documents this in a comment - keep the comment.
- Call `settings_errors()` yourself in the shell, after that marker.

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
