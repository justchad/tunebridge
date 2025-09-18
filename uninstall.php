<?php
/**
 * Uninstall cleanup for TuneBridge.
 *
 * @package TuneBridge
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

delete_option( 'tunebridge_settings' );
