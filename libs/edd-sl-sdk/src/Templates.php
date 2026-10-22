<?php
/**
 * Templates manager.
 *
 * @package EasyDigitalDownloads\Updater
 * @since 1.0.0
 */

namespace EasyDigitalDownloads\Updater;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit; // @codeCoverageIgnore

use EasyDigitalDownloads\Updater\Utilities\Path;
class Templates {

	public static function load( string $file, array $args = array() ) {
		// Wbcom security hardening (2026-10-22): $file can originate from an
		// AJAX GET param (Handler::ajax_get_license_overlay), so contain it to
		// the templates directory. basename() strips any path components
		// (../, absolute paths); the realpath check rejects anything that still
		// resolves outside the templates dir (e.g. via a symlink). Divergence
		// from the shared libs/edd-sl-sdk tracked for portfolio re-sync.
		$file           = basename( $file );
		$templates_path = self::get_templates_path();
		$template       = $templates_path . $file . '.php';

		$real_base = realpath( $templates_path );
		$real_tmpl = realpath( $template );
		if ( false === $real_base || false === $real_tmpl || 0 !== strpos( $real_tmpl, trailingslashit( $real_base ) ) ) {
			return;
		}

		if ( ! file_exists( $template ) ) {
			return;
		}

		load_template( $template, false, $args );
	}

	/**
	 * Get the templates path.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	private static function get_templates_path() {
		return apply_filters( 'edd_sl_sdk_templates_path', trailingslashit( Path::get_dir() ) . 'templates/' );
	}
}
