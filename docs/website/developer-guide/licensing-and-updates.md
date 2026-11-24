# Licensing and Updates

Infinite Loader for WooCommerce ships as a single tier. There is no separate Pro plugin, and the plugin has no licence screen of its own.

## How updates are delivered

Updates come from `https://wbcomdesigns.com/` through the Easy Digital Downloads Software Licensing SDK bundled in the plugin. WordPress shows them on the normal Plugins and Updates screens like any other plugin update.

The free download carries a preset licence key, so updates work with no setup. After you activate the plugin, it registers that key with the update server in the background the first time an admin screen loads. If the server cannot be reached, it tries again later and keeps trying until it succeeds. There is no notice and no button for the site owner.

If you have your own key for this plugin, the plugin never replaces it with the preset key: once a different key or a valid licence is stored, the background activation stops for good.

## Update packages are signature-checked

Each update package is checked against a signature before WordPress installs it, and only packages served over HTTPS from `wbcomdesigns.com` or `updates.wbcomdesigns.com` are accepted. The signature comes from the package download itself, or from a fallback address on `wbcomdesigns.com` when the download carries none. The plugin runs this check in warning mode: the result is recorded, and a package that fails the check is not blocked from installing.

## Opt out of the licence request

On a site that must not contact the update server, for example an air-gapped or privacy-strict install, add this to `wp-config.php`:

```php
define( 'INFINITE_LOADER_FOR_WOOCOMMERCE_NO_LICENSE_PHONE_HOME', true );
```

The preset key is then never sent. The plugin keeps working; it just will not receive automatic updates.

## What is stored

The licence key and its status are stored in the options the SDK keeps for this plugin, plus a cached last-check result. Deleting the plugin from the Plugins screen removes all of them along with the plugin's own settings.
