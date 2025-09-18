<?php
namespace Tunebridge\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Simple PSR-4-style autoloader for the Tunebridge plugin.
 */
class Autoloader {

	/**
	 * Register the autoloader.
	 */
	public static function register() {
		spl_autoload_register( [ __CLASS__, 'autoload' ] );
	}

	/**
	 * Autoload class files based on namespace.
	 *
	 * @param string $class Class name with namespace.
	 */
	public static function autoload( $class ) {
		// Only autoload Tunebridge classes.
		if ( strpos( $class, 'Tunebridge\\' ) !== 0 ) {
			return;
		}

		// Remove base namespace.
		$relative_class = substr( $class, strlen( 'Tunebridge\\' ) );

		// Convert namespace to path.
		$path = plugin_dir_path( __FILE__ ) . '../' . str_replace( '\\', '/', $relative_class ) . '.php';

		if ( file_exists( $path ) ) {
			require_once $path;
		}
	}
}
