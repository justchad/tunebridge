<?php

namespace Tunebridge\Rest;
/**
 * REST API for TuneBridge.
 *
 * @package TuneBridge
 */

namespace TuneBridge;

use WP_REST_Server;

defined( 'ABSPATH' ) || exit;

class REST {

	public static function init() {
		add_action( 'rest_api_init', [ __CLASS__, 'register_routes' ] );
	}

	protected static function validate_request( $request ) {
		if ( ! is_user_logged_in() ) { return new \WP_Error( 'tb_rest_auth', __( 'Authentication required.', 'tunebridge' ), [ 'status' => 401 ] ); }
		if ( ! current_user_can( 'view_tunebridge' ) ) { return new \WP_Error( 'tb_rest_cap', __( 'Insufficient permissions.', 'tunebridge' ), [ 'status' => 403 ] ); }
		return true;
	}

	public static function register_routes() {
		register_rest_route( 'tunebridge/v1', '/search/playlists', [
			'methods' => WP_REST_Server::READABLE,
			'callback' => [ __CLASS__, 'search_playlists' ],
			'permission_callback' => function( $request ){ return self::validate_request( $request ); },
			'args' => [ 'q' => [ 'type' => 'string', 'required' => true, 'sanitize_callback' => 'sanitize_text_field' ] ],
		] );
		register_rest_route( 'tunebridge/v1', '/search/artists', [
			'methods' => WP_REST_Server::READABLE,
			'callback' => [ __CLASS__, 'search_artists' ],
			'permission_callback' => function( $request ){ return self::validate_request( $request ); },
			'args' => [ 'q' => [ 'type' => 'string', 'required' => true, 'sanitize_callback' => 'sanitize_text_field' ] ],
		] );
	}

	public static function search_playlists( $request ) {
		if ( ! Services::is_enabled( 'spotify' ) ) { return rest_ensure_response( [] ); }
		$prov = Services::provider( 'spotify' ); if ( ! $prov ) { return rest_ensure_response( [] ); }
		$q = (string) $request->get_param( 'q' );
		return rest_ensure_response( $prov->search_playlists( $q ) );
	}

	public static function search_artists( $request ) {
		if ( ! Services::is_enabled( 'spotify' ) ) { return rest_ensure_response( [] ); }
		$prov = Services::provider( 'spotify' ); if ( ! $prov ) { return rest_ensure_response( [] ); }
		$q = (string) $request->get_param( 'q' );
		return rest_ensure_response( $prov->search_artists( $q ) );
	}
}
