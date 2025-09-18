<?php

namespace Tunebridge\Providers;

defined('ABSPATH') || exit;

class Spotify_Provider
{

	/**
	 * Get a bearer token for Spotify API using Client Credentials Flow.
	 */
	public static function get_token()
	{
		$client_id     = get_option('tunebridge_spotify_client_id');
		$client_secret = get_option('tunebridge_spotify_client_secret');

		if (! $client_id || ! $client_secret) {
			return false;
		}

		// Transient caching
		$cached_token = get_transient('tunebridge_spotify_token');
		if ($cached_token) {
			return $cached_token;
		}

		$response = wp_remote_post('https://accounts.spotify.com/api/token', [
			'headers' => [
				'Authorization' => 'Basic ' . base64_encode($client_id . ':' . $client_secret),
				'Content-Type'  => 'application/x-www-form-urlencoded',
			],
			'body' => [
				'grant_type' => 'client_credentials',
			],
		]);

		if (is_wp_error($response)) {
			return false;
		}

		$data = json_decode(wp_remote_retrieve_body($response), true);

		if (isset($data['access_token'])) {
			set_transient('tunebridge_spotify_token', $data['access_token'], 3500);
			return $data['access_token'];
		}

		return false;
	}

	/**
	 * Search for playlists.
	 */
	public static function search_playlists($query)
	{
		$token = self::get_token();
		if (! $token) {
			return [];
		}

		$response = wp_remote_get('https://api.spotify.com/v1/search?' . http_build_query([
			'q'     => $query,
			'type'  => 'playlist',
			'limit' => 10,
		]), [
			'headers' => [
				'Authorization' => 'Bearer ' . $token,
			],
		]);

		if (is_wp_error($response)) {
			return [];
		}

		$data = json_decode(wp_remote_retrieve_body($response), true);

		return $data['playlists']['items'] ?? [];
	}
}