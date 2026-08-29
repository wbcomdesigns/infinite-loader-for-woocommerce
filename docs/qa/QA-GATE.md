# Infinite Loader for WooCommerce — Pre-release QA Gate

Run this top to bottom before every release. Two layers: **code flow** you verify in the terminal (`◇ code`), and **browser** checks where you must open the page and *read the rendered result* (`▦ browser`) — admin and storefront — to catch friction a passing test never shows.

- **Slug:** `infinite-loader-for-woocommerce` · **Version:** 1.3.1 · **Branch:** `master`
- **Companion pair:** none (no Free/Pro split)
- **Core feature:** infinite scroll / Load More / AJAX pagination on WooCommerce shop archives — the frontend fetches the next archive page over AJAX (`GET …?infinite_loader_ajax=1`) and the plugin appends the product grid. **This is the feature that must be verified in a real browser on a generic theme.**

## How to run it

1. Clean WP + WooCommerce install; import the WooCommerce sample products (or seed — see Phase 2). Activate a **generic** theme (Storefront + one default block theme), not BuddyX / Reign.
2. Configure the plugin once (WB Plugins → Infinite Loader → General: pick a loading style, per-page count, an icon), then walk the shopper path on the shop archive.
3. A check passes only with evidence — a command output or a screenshot you actually read. Verify per item; do not batch everything and glance once at the end.
4. Ship only when every box is ticked, or the gap is logged as an accepted exception with a reason.

Legend: `◇ code` = verifiable from the terminal · `▦ browser` = open the page and read it · `admin` / `frontend` = which surface.

---

## Phase 01 — Code flow: boot & activation
*Does the plugin come up cleanly, exactly once, and go down without leaving a mess.*

- [ ] Activates on a clean WP + WooCommerce install with no PHP notice, warning, or fatal in `debug.log`. `◇ code`
- [ ] Bootstraps **exactly once** — `run_infinite_loader_for_woocommerce()` fires from the single `plugins_loaded` → `infinite_loader_for_woocommerce_check_woocommerce()` path; no duplicate hook registration on admin loads. `◇ code` `admin`
- [ ] `Requires Plugins: woocommerce` header present; the runtime WooCommerce guard (`class_exists('WooCommerce')` self-deactivate + admin notice) is the intended UX fallback, not a duplicate of it. `◇ code`
- [ ] Shared `lib/wbcom-settings/` shell loads the highest bundled version (`wbcom_settings_register('1.0.2', …)`); no fatal when a second Wbcom plugin ships a different copy (activate two together). `◇ code`
- [ ] Textdomain loads on `plugins_loaded` via the i18n class; no output before headers. `◇ code`
- [ ] Deactivate → reactivate is clean; `uninstall.php` removes only this plugin's own options + transients (single-site AND multisite via `get_sites()`). `◇ code`
- [ ] PHP lint (8.0–8.4) clean; WPCS clean; `bin/verify-build-freshness.sh` passes (no committed minified bundle behind its source). `◇ code`

## Phase 02 — Code flow: data, contracts & scale
*Every key read is written, the store is reachable the ways it claims, and the archive holds at 2,000+ products.*

- [ ] Contract audit clean: every `infinite_loader_admin_*_option` sub-key the frontend reads is written by a settings tab and sanitized by its `validate_*` callback; no orphan option keys, no read-never-written. `◇ code`
- [ ] The 4 option stores are reachable the ways they claim: **admin UI** (settings tabs) writes them, **frontend** reads them (localized to `infinite_loader_products.js`). There is intentionally **no REST/AJAX write path and no custom table** — confirm none was half-added. `◇ code`
- [ ] Next-page rendering reuses WooCommerce's own archive query + loop templates (`wc_setup_loop` + `wc_get_template_part('content','product')`) — no separate unbounded `SELECT`; pagination is WooCommerce's `LIMIT`/`OFFSET`. `◇ code`
- [ ] **Seed 2,000+ products**: the shop archive first paint is unchanged, and each next-page fetch returns only that page's grid (not the whole catalogue). Confirm the products-only response stays small (~21KB on a stock shop, per the 1.3.0 fix) rather than a full themed page. `◇ code` `▦ browser`
- [ ] Public read endpoint is safe to leave unauthenticated: it is read-only, sets `nosniff` / `SAMEORIGIN` / `noindex` headers, and is rate-limited to 30 req/min per IP (`check_rate_limit` → `429`). No path mutates data. `◇ code`
- [ ] Settings persist: save each tab → reload → values retained; no silently-dropped field, no key the UI writes but nothing reads. `◇ code` `▦ browser` `admin`
- [ ] Does not strip other plugins' hooks globally: the only `remove_all_actions` calls target `admin_notices`/`all_admin_notices` **scoped to this plugin's own settings screens** — confirm they cannot fire on other admin pages or the frontend. `◇ code`

## Phase 03 — Browser: admin presentation
*Open every settings tab and read it. Layout painted, states handled, the icon picker actually works.*

- [ ] Settings screen renders on the shared Wbcom shell; **each tab (Overview, General, Button Style, Previous Button Style, JavaScript/CSS, FAQ) switches and paints** — not merely present in the DOM. Look at each one. `▦ browser` `admin`
- [ ] **Icon picker (General tab):** "Choose icon" opens the Font Awesome grid popup and the icons **render** (not blank squares — the 1.3.1 fix); typing in the search filters; clicking an icon selects it, updates the preview + hidden `loading_image`, and it survives save + reload. "Use default" restores `fa-spinner`. `▦ browser` `admin`
- [ ] **Colour pickers** (Button + Previous Button tabs) open, apply, and persist; the per-side padding/margin/border/radius fields are labelled and on one row (the 1.3.0 layout fix), not four unlabelled stacked boxes. `▦ browser` `admin`
- [ ] "Settings saved" notice appears under the header on the shared shell after each save — not dropped into the wrong section. `▦ browser` `admin`
- [ ] **Overview tab** reports the live state truthfully: loading style, products per load, address-bar tracking, WooCommerce version — cross-check against what you saved on General. `▦ browser` `admin`
- [ ] **FAQ tab** accordion expands/collapses (the 1.3.0 fix — it previously shipped with no styles, so every answer was stuck open). `▦ browser` `admin`
- [ ] No console errors on any settings tab; assets enqueued once (admin JS/CSS + `wp-color-picker` + `fontawesome5.min.css`), no 404s, select2 **not** loaded. `▦ browser` `admin`

## Phase 04 — Browser: frontend presentation (the core feature)
*The shopper's side, on a theme we do not own. The next page must actually load.*

- [ ] On a **generic theme** (Storefront + a default block theme), open the shop archive: with **Load More** selected, the button renders and clicking it fetches the next page (`GET …?infinite_loader_ajax=1` in the network panel) and **appends** the next products beneath the current grid. `▦ browser` `frontend`
- [ ] With **Infinite Scroll** selected, scrolling near the end of the list (within ~300px, the `infinite_loader_scroll_threshold` default) auto-loads the next page; it does **not** fire while the shopper is still up in the header (the 1.3.0 threshold fix). `▦ browser` `frontend`
- [ ] With **AJAX pagination** selected, the next page **replaces** the grid in place (not appended, not full reload) and the page-number links keep working. `▦ browser` `frontend`
- [ ] The **loading icon/animation renders and matches the picked icon** while a fetch is in flight (spin honoured if enabled); on a theme with no Font Awesome of its own, the bundled `fontawesome5.min.css` still makes the default spinner visible (the 1.3.0 enqueue-timing fix). `▦ browser` `frontend`
- [ ] The **result count updates to describe everything on screen** ("Showing 1–16 of 17"), not just the last page loaded (the 1.3.0 running-count fix). `▦ browser` `frontend`
- [ ] **Address bar follows the shopper** down the archive (unless "do not update URL" is on), and the browser **Back** button returns them where they were rather than page one. `▦ browser` `frontend`
- [ ] End of catalogue is handled: when no next page remains the loader stops cleanly (no infinite spinner, no error); a failed fetch surfaces the retry affordance, not a silent dead end. `▦ browser` `frontend`
- [ ] Load More / Previous / scroll-to-top button **hover, focus, and visited** states are correct — themes override `<a>` buttons, so check all three; the hover CSS from `wp_head` wins. `▦ browser` `frontend`
- [ ] No JS errors in the storefront console; no handler bound to a selector the theme never emits. On a WC-Blocks archive, the `.wc-block-grid__*` selectors are picked up. `▦ browser` `frontend`
- [ ] No store internals leak to shoppers (file paths, admin notices, local-env warnings) on the archive or in the AJAX response. `▦ browser` `frontend`

## Phase 05 — Cross-cutting: responsive · RTL · dark · a11y
*Both admin settings and the shop archive, at each breakpoint. Infinite scroll is the core feature — do not trap the keyboard user.*

- [ ] 390 / 768 / 1024 / 1280: no horizontal body scroll on the settings screen or the shop archive; button rows and spacing-field rows stack sensibly. `▦ browser` `admin` `frontend`
- [ ] **The Load More button (and loaded products) are reachable one-thumb at 390px**; tap targets ≥ 44px. `▦ browser` `frontend`
- [ ] RTL: the settings screen and the loaded grid mirror correctly; the RTL frontend stylesheets (`*/rtl/*.rtl.css`) load when `is_rtl()`. `▦ browser` `admin` `frontend`
- [ ] Dark mode (where the surface themes it): the shared shell and buttons use token/setting-driven colours, no raw hex bleeding one theme onto the other. `▦ browser`
- [ ] **A11y for infinite scroll specifically:** focus is **not trapped** by the auto-loading list, and a keyboard user can still **reach the footer** and anything below the products. The scroll-to-top link and Load More button are keyboard-reachable with a visible focus ring; icon-only controls carry an `aria-label` (the scroll-top button does). `▦ browser` `frontend`

## Phase 06 — Packaging & release artifact
*Verify the zip, not the dev tree.*

- [ ] Version agrees across the main-file header (`1.3.1`), `INFINITE_LOADER_FOR_WOOCOMMERCE_VERSION`, `README.txt` stable tag, and `package.json`. `◇ code`
- [ ] Built zip contains no `bin/`, `.distignore`, `node_modules/`, `audit/`, `docs/`, or `*.md` guides (the user guide was pulled from the release in 1.3.0). `◇ code`
- [ ] Bundled runtime assets **are present** in the zip, asserted by named file: `public/css/fontawesome5.min.css`, `public/css/webfonts/fa-solid-900.woff2`, `lib/wbcom-settings/`, minified frontend bundles under `public/js/min/` and `public/css/min/`. `◇ code`
- [ ] Pristine install from the **built zip** (fresh Docker WP + WooCommerce): activates, shop archive returns 200, the loader assets enqueue, and a next-page fetch returns the products-only grid. `◇ code` `▦ browser`
- [ ] `README.txt` changelog in WooCommerce action-prefix style (New/Improve/Fix/Security/Dev/Compat), no em-dashes, no emoji. `◇ code`

## Phase 07 — Friction hunt
*Not "does it work" but "where does a real person stall." Judge against 10,000 store owners, not the happy path.*

- [ ] **First run:** on a fresh activation with zero config, does the shop already do something useful? (1.3.0 defaults new sites to **Load More** — confirm the archive shows a working button, not classic pagination and not a blank screen, before the owner touches a setting.) `▦ browser` `admin` `frontend`
- [ ] **Owner setup:** can a non-developer pick a loading style and an icon from the General tab without the docs? Labels read by what they do ("Change how products load", the Overview summary), not by option key. `▦ browser` `admin`
- [ ] **Shopper path:** walk the archive end to end in each of the three modes and count the interactions — any dead end, any spinner that never resolves, any Load More that no-ops, any point where "no more products" is unclear? `▦ browser` `frontend`
- [ ] **Error honesty:** force a failed next-page fetch (kill the network mid-scroll, or trip the 30/min rate limit) — does the shopper get a retry affordance and the owner a sensible state, with nothing silently swallowed? `▦ browser` `◇ code`
- [ ] **Theme conflict:** on a theme whose shop loop is built outside the standard WooCommerce loop templates, does appended markup match first-paint markup — and if not, does `infinite_loader_render_products_only`/the selector filters give a clean escape hatch? `▦ browser` `frontend`
- [ ] **Same-class sweep:** every friction found on one loading mode / theme / viewport — check it on the other two modes, a block theme, and 390px before calling it fixed. Prove the sweep. `▦ browser` `◇ code`

## Phase 08 — Release sign-off
*The gate closes here.*

- [ ] Phases 01–07 complete, or each unchecked item logged as an accepted exception with a reason. `◇ code` `▦ browser`
- [ ] Functionality catalog current: `audit/manifest.json` + `CAPABILITIES.md` regenerated no earlier than the newest `includes/` / `admin/` / `public/` change. `◇ code`
- [ ] Smoke-pass evidence recorded (screenshots of the three modes loading on a generic theme + the icon picker) with before/after proof for anything fixed this cycle. `◇ code`
