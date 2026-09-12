# Infinite Loader for WooCommerce — Capabilities

**Slug:** `infinite-loader-for-woocommerce` · **Version:** 1.3.2 · **Requires:** WordPress 6.5+, PHP 8.0+, WooCommerce 3.0+ · **HPOS:** compatible · **Companion Pro/Free pair:** none

## What it does

Replaces WooCommerce's classic archive pagination with one of three AJAX loading styles on shop / category / tag / product-taxonomy archives. When a shopper scrolls near the end of the product list (infinite scroll) or clicks **Load More**, the frontend script fetches the next archive page over AJAX (a GET carrying `infinite_loader_ajax=1`), and the plugin answers with the product grid **alone** — result count, product loop, pagination — instead of re-rendering the whole themed page. The new products are appended beneath the current ones (or replace them, in AJAX-pagination mode), the visible "Showing X-Y of Z" count is updated to describe everything on screen, and the address bar follows the shopper so the browser Back button returns them where they were. A configurable Font Awesome loading icon animates while the fetch is in flight. The store owner configures loading style, per-page count, icon, and full button styling from a settings screen on the shared Wbcom admin shell.

## Capabilities

| Capability | Maturity | Notes |
|---|---|---|
| Infinite scroll (auto-load near list end) | Stable | Triggers within `infinite_loader_scroll_threshold` px (default 300) of the list bottom. |
| Load More button | Stable | Default for fresh activations since 1.3.0. Existing sites keep their saved setting. |
| AJAX pagination (replace grid) | Stable | Next page replaces the current grid in place, no full reload. |
| Products-only AJAX response | Stable | Answers the next-page request with the product grid only (built from the same loop templates as the archive), not the whole page. Filter `infinite_loader_render_products_only` returns `false` to fall back to full-page rendering for non-standard themes. |
| Load Previous button | Stable | Shown in Load More / infinite-scroll modes; own style tab. |
| Loading icon (Font Awesome 5 Free) | Stable | Icon picker in admin; optional spin; falls back to `fa-spinner`. Custom image URL also accepted. |
| Configurable button styling | Stable | Text, colours (base + hover), font size, and per-side padding/margin/border/border-radius for both Load More and Previous buttons; live hover CSS injected in `wp_head`. |
| Running result count | Stable | Substitutes the growing first/last range into "Showing …" after each load (placeholders `{{il_start}}`/`{{il_end}}`, real numbers in `data-*`). |
| Address-bar / history tracking | Stable | `history.replaceState`; opt-out via the "do not update URL" toggle (stored as `do_not_update_url = yes`). |
| Scroll-to-top button | Stable | Rendered in Load More / infinite-scroll modes only. |
| Custom CSS / JS hooks | Stable | Custom CSS plus before/after-update JS, both sanitized at save (see Security). |
| Per-page product count override | Stable | `loop_shop_per_page` filter, clamped 1–100. |
| Object-cached option reads | Stable | Each of the 4 option arrays is wrapped in `wp_cache_*` (1h) to avoid repeat DB reads per archive request. |
| Page-cache compatibility | Stable | Read endpoint is nonce-free by design so WP Rocket / Varnish / Cloudflare can serve the shop. |
| WooCommerce Blocks archive support | Basic | Selectors extended with `.wc-block-grid__products` / `__product` when WC Blocks is active. |
| EDD Software Licensing updater | Optional | Loaded only if `edd-license/` is present. |

## Admin surfaces

All under **WB Plugins → Infinite Loader** (shared `Wbcom_Settings_Page` shell; slug `infinite-loader-for-woocommerce-settings`). Tab render is gated on `manage_woocommerce`.

- **Overview** (default tab) — read-only summary: current loading style, products per load, whether the address bar follows the shopper, WooCommerce status. Links to the General tab and to the live shop.
- **General** — loading style (Infinite Scroll / Load More / AJAX pagination), products per load (1–100), "Load Font Awesome icons" toggle, **loading-icon picker** (a searchable Font Awesome grid popup; `Infinite_Loader_For_Woocommerce_Admin::infinite_loader_icon_popup()` renders ~470 `fa-*` icons; the picker font is loaded in wp-admin so the grid shows real icons rather than blank squares — fixed in 1.3.1), spin-while-loading toggle, and a do-not-update-URL toggle.
- **Button Style** — Load More button: text, base + hover colours, font size, per-side padding/margin/border/border-radius (each 0–999).
- **Previous Button Style** — same field set for the Previous button.
- **JavaScript/CSS** — custom CSS and before/after-update JS snippets.
- **FAQ** — help accordion.

The plugin also creates the shared **WB Plugins** parent menu when no other Wbcom plugin has (`manage_options`), and suppresses third-party admin notices on its own screens.

## Frontend surface

WooCommerce archives only — `is_shop()`, `is_product_category()`, `is_product_tag()`, `is_product_taxonomy()` (filterable via `infinite_loader_should_load_assets`). Assets load only on those pages. The loader engine is `public/js/infinite_loader_products.js`: it locates the WooCommerce product list / pagination / next-link via overridable selectors, fetches the next page with an abortable jQuery GET (`infinite_loader_ajax=1`), validates the target URL before requesting, appends (or replaces) the returned grid, updates the result count, and updates browser history. On error it surfaces a retry affordance; when no next page remains it stops.

## Data stored (options only — no custom tables)

| Option | Holds |
|---|---|
| `infinite_loader_admin_general_option` | Loading type, products per load, Font Awesome toggle, rotate/spin, do-not-update-URL, loading icon. |
| `infinite_loader_admin_button_option` | Load More button text / colours / spacing / border / radius. |
| `infinite_loader_admin_previous_button_option` | Previous button styling (same shape). |
| `infinite_loader_admin_css_js_option` | Custom CSS, before/after-update JS. |
| `edd_wbcom_infinite_loader_license_key`, `edd_wbcom_infinite_loader_license_status` | EDD Software Licensing (optional). |

Transients: `edd_wbcom_infinite_loader_license_key_data` (license-check cache, 12h). `uninstall.php` removes the four settings option arrays on single-site and, via `get_sites()`, multisite. (There is no rate-limiting transient - the rate limiter was removed in 1.3.2. Note: `uninstall.php` still targets old license option keys `infinite_loader_license_key/_status`, which do not match the `edd_wbcom_*` keys the license code actually writes, so license options are not currently cleaned up on uninstall.)

## Bundled icon assets

- `public/css/fontawesome5.min.css` — **Font Awesome 5 Free**, with its webfonts in `public/css/webfonts/` (`fa-solid-900`, `fa-regular-400` — ttf/woff/woff2). Enqueued on the storefront only when the owner enables Font Awesome, and in wp-admin on the settings screen so the icon picker renders.
- `public/css/font-awesome.min.css` — a FA5 **Pro** build whose fonts are **not** shipped; kept in the repo but intentionally never enqueued (renders nothing).
- `assets/vendor/lucide.min.js` — Lucide icons, used by the shared Wbcom settings shell nav.

## Extension seams

- **Response shape:** `infinite_loader_render_products_only` (products-only vs full page).
- **Where it runs:** `infinite_loader_should_load_assets`.
- **DOM selectors** (theme adaptation): `infinite_loader_products_selector`, `_item_selector`, `_pagination_selector`, `_next_page_selector`, `_prev_page_selector`, `_result_count_selector`.
- **Behaviour:** `infinite_loader_products_per_page`, `infinite_loader_scroll_threshold`, `infinite_loader_rate_limit`.
- **Payload / markup:** `infinite_loader_js_data`, `infinite_loader_js_function`, `wbcom_infinite_loader_image`.
- **Button styling:** `infinite_loader_for_woocommerce_load_more_button_style`, `_load_previous_button_style`, `infinite_loader_lm_btn_hover_css`, `infinite_loader_previous_btn_hover_css`.
- **Settings shell:** filter `infinite_loader_settings_nav_groups`, action `infinite_loader_settings_tab_content`.

## Security layer on the public read endpoint

The next-page fetch is served by `handle_infinite_loader_ajax()` on `template_redirect`, keyed by the `infinite_loader_ajax` request flag. It is **unauthenticated by design**: it only renders a public shop archive any visitor can already open, and it changes no state — so there is nothing for a nonce to protect, and dropping the per-visitor nonce is what restores full-page-cache compatibility. Protections in place:

- **Response headers** on the AJAX render: `X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, `X-Robots-Tag: noindex, nofollow`.
- **Rate limiter** (`check_rate_limit` on `init`): 30 requests/minute per client IP (filter `infinite_loader_rate_limit`), counted in a 60s transient; a breach returns `429 Too Many Requests`. Client IP is resolved through the proxy-header chain with `FILTER_VALIDATE_IP` (private/reserved ranges rejected).
- **Archive-page headers** (`add_security_headers` on `send_headers`): `X-XSS-Protection`, `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy` on shop-archive loads.
- **Marker hygiene:** the handler strips its own `infinite_loader_ajax` flag from the request and `REQUEST_URI` before rendering so WooCommerce add-to-cart links built from the current URL do not inherit it.
- **Stored CSS/JS sanitized at save** (see the settings table); colours are hex-validated.
