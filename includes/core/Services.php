<?php

namespace Tunebridge\Core;
/**
 * Provider service registry for TuneBridge.
 *
 * @package TuneBridge
 */

namespace TuneBridge;

defined( 'ABSPATH' ) || exit;

class Services {

	protected static $providers = [];

	public static function register( $key, $instance ) {
		self::$providers[ $key ] = $instance;
	}

	public static function provider( $key ) {
		return isset( self::$providers[ $key ] ) ? self::$providers[ $key ] : null;
	}

	public static function is_enabled( $key ) {
		$opts = get_option( 'tunebridge_settings', [] );
		switch ( $key ) {
			case 'spotify':
				return ! empty( $opts['provider_spotify_enabled'] );
		}
		return false;
	}
}
