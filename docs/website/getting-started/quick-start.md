# Quick Start

Get infinite loading working on your shop in three steps.

## 1. Open the settings

Go to **WB Plugins > Infinite Loader** in wp-admin. The screen is visible to users with the `manage_woocommerce` capability.

The **Overview** tab opens first and tells you what the plugin is doing to your shop right now:

- the loading style in use;
- how many products load at a time;
- whether the address bar follows the shopper as they browse;
- whether WooCommerce is active, and its version.

## 2. Choose how products load

Open the **General** tab and pick a **Products Loading Type**:

- **Load More button** - shoppers click to see more (the fresh-install default).
- **Infinite scroll** - more products load automatically as the shopper nears the end of the list.
- **Pagination** - numbered pages fetched over AJAX, with no full reload.

Set **Products Per Page** to how many products should load at a time. The value is clamped between 1 and 100.

## 3. Save and view your shop

Click **Save Changes**, then open your shop page. The Overview tab has a **View your shop** button that links straight there.

## What is styled by default

- The Load More and Previous buttons ship with a blue fill (`#1d76da`), white text, rounded corners, and a darker hover.
- A spinning Font Awesome spinner icon is shown while the next products load.
- A "scroll to top" button appears on the storefront in Load More and Infinite scroll modes.

Everything above is adjustable from the settings tabs. See the [Settings Reference](../usage/settings.md) for every field.
