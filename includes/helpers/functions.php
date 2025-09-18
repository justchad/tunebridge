<?php

namespace Tunebridge\Helpers;
/**
 * Helpers for TuneBridge.
 *
 * @package TuneBridge
 */

namespace TuneBridge;

defined( 'ABSPATH' ) || exit;

function load_template_part( $relative_path, $vars = [] ) {
	$file = trailingslashit( TUNEBRIDGE_PLUGIN_DIR ) . 'templates/' . ltrim( $relative_path, '/' );
	if ( ! file_exists( $file ) ) { return; }
	if ( is_array( $vars ) ) { extract( $vars, EXTR_SKIP ); } // phpcs:ignore WordPress.PHP.DontExtract
	include $file;
}

function user_has_allowed_role() {
	$opts = get_option( 'tunebridge_settings', [] );
	$roles = isset( $opts['allowed_roles'] ) ? (array) $opts['allowed_roles'] : [];
	$user = wp_get_current_user();
	return (bool) array_intersect( $roles, (array) $user->roles );
}
