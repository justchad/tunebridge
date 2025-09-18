<?php

namespace Tunebridge\Core;
/**
 * Roles & capabilities for TuneBridge.
 *
 * @package TuneBridge
 */

namespace TuneBridge;

defined( 'ABSPATH' ) || exit;

class Roles {

	public static function caps_map() {
		return [ 'manage_tunebridge', 'view_tunebridge', 'edit_tunebridge_contacts', 'export_tunebridge_contacts', 'manage_tunebridge_settings', 'use_tunebridge_providers' ];
	}

	public static function add_caps() {
		$role = get_role( 'administrator' ); if ( ! $role ) return;
		foreach ( self::caps_map() as $cap ) { $role->add_cap( $cap ); }
	}

	public static function remove_caps() {
		$roles = wp_roles(); if ( ! $roles ) return;
		foreach ( $roles->roles as $role_key => $role_data ) {
			$role = get_role( $role_key ); if ( ! $role ) continue;
			foreach ( self::caps_map() as $cap ) { $role->remove_cap( $cap ); }
		}
	}
}
