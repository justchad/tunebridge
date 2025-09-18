<?php
/**
 * WP-CLI commands for TuneBridge releases.
 *
 * Usage:
 *   wp tunebridge bump --version=1.2.3 --note="Added CSV export"
 *
 * @package TuneBridge
 */

namespace TuneBridge\Tools;

use WP_CLI;

defined( 'ABSPATH' ) || exit;

class CLI {

	public static function register() {
		\WP_CLI::add_command( 'tunebridge bump', [ __CLASS__, 'bump' ] );
	}

	public static function bump( $args, $assoc_args ) {
		$version = isset( $assoc_args['version'] ) ? $assoc_args['version'] : '';
		$note    = isset( $assoc_args['note'] ) ? $assoc_args['note'] : '';

		if ( empty( $version ) ) {
			\WP_CLI::error( 'Please provide --version=x.y.z' );
		}
		self::update_main_plugin_version( $version );
		self::update_changelog( $version, $note );
		\WP_CLI::success( 'Version bumped to ' . $version . ' and changelog updated.' );
	}

	protected static function update_main_plugin_version( $version ) {
		$plugin_file = TUNEBRIDGE_PLUGIN_DIR . 'tunebridge.php';
		$contents = file_get_contents( $plugin_file );
		$contents = preg_replace( '/Version:\s*([0-9\.]+)/', 'Version: ' . $version, $contents );
		$contents = preg_replace( '/define\(\s*\' + "'" + 'TUNEBRIDGE_VERSION' + "'" + '\s*,\s*\' + "'" + '[0-9\.]+' + "'" + '\s*\)/', 'define( \'TUNEBRIDGE_VERSION\', \'{}\' )'.format(version), $contents )
		; // This pattern replacement is tricky in PHP, fallback below.
		// Fallback: simple replace for constant line.
		$contents = preg_replace( '/define\(\s*\'TUNEBRIDGE_VERSION\'\s*,\s*\'[^\']*\'\s*\);/', 'define( \'TUNEBRIDGE_VERSION\', \'%s\' );' );
		file_put_contents( $plugin_file, sprintf( $contents, $version ) );
	}

	protected static function update_changelog( $version, $note ) {
		$changelog = TUNEBRIDGE_PLUGIN_DIR . 'CHANGELOG.md';
		$date = date( 'Y-m-d' );
		$entry = "\n## " . $version . " - " . $date . "\n\n" . ( $note ? "- " . $note . "\n" : "" );
		if ( file_exists( $changelog ) ) {
			$prev = file_get_contents( $changelog );
			file_put_contents( $changelog, $entry . "\n" . $prev );
		} else {
			file_put_contents( $changelog, "# Changelog\n" . $entry );
		}
	}
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	CLI::register();
}
