# Licensing and Updates

When the `edd-license/` directory is present in the plugin, it wires itself to Easy Digital Downloads Software Licensing for automatic updates from `https://wbcomdesigns.com/`. If the directory is absent, none of this loads and the plugin runs unlicensed.

Infinite Loader for WooCommerce ships as a single tier. There is no separate Pro plugin.

## Where the key is entered

The license row renders on the shared **WB Plugins** license screen at `admin.php?page=wbcom-license-page`, alongside every other Wbcom plugin's key. Paste the key, click **Activate**, and later **Deactivate** if needed.

## What is stored

| Option | Holds |
|---|---|
| `edd_wbcom_infinite_loader_license_key` | The license key string. |
| `edd_wbcom_infinite_loader_license_status` | Activation status (`valid`, `expired`, `invalid`, and so on). |

The last successful license check is cached in the transient `edd_wbcom_infinite_loader_license_key_data`. Entering a new key clears the stored status, so it must be re-activated. All three values are removed on uninstall.

## Store requests

- Activation and deactivation use `edd_action=activate_license` / `deactivate_license`.
- Update checks use `edd_action=get_version`.
