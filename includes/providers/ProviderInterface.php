<?php

namespace Tunebridge\Providers;
/**
 * Provider interface for TuneBridge.
 *
 * @package TuneBridge
 */

namespace TuneBridge\Providers;

defined( 'ABSPATH' ) || exit;

interface Provider_Interface {
	public function search_playlists( $query, $args = [] );
	public function search_artists( $query, $args = [] );
}
