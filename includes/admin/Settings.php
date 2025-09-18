<?php

namespace Tunebridge\Admin;
/**
 * Settings page and registry.
 *
 * @package TuneBridge
 */

namespace TuneBridge;

defined( 'ABSPATH' ) || exit;

class Settings {

	public static function init() {
		add_action( 'admin_init', [ __CLASS__, 'register' ] );
	}

	public static function register() {
		register_setting(
			'tunebridge_settings_group',
			'tunebridge_settings',
			[
				'type'              => 'array',
				'sanitize_callback' => [ __CLASS__, 'sanitize' ],
				'default'           => [
					'provider_spotify_enabled' => 1,
					'spotify_client_id'        => '',
					'spotify_client_secret'    => '',
					'default_include_tracks'   => 1,
					'public_dashboard'         => 0,
					'logging_enabled'          => 0,
					'allowed_roles'            => [ 'administrator' ],
				],
			]
		);

		add_settings_section( 'tb_section_providers', __( 'Providers', 'tunebridge' ), function(){ echo '<p>' . esc_html__( 'Configure provider credentials and enable/disable integrations.', 'tunebridge' ) . '</p>'; }, 'tunebridge_settings' );

		add_settings_field( 'provider_spotify_enabled', __( 'Enable Spotify', 'tunebridge' ), [ __CLASS__, 'field_checkbox' ], 'tunebridge_settings', 'tb_section_providers', [ 'key' => 'provider_spotify_enabled', 'label' => __( 'Enable Spotify provider', 'tunebridge' ) ] );
		add_settings_field( 'spotify_client_id', __( 'Spotify Client ID', 'tunebridge' ), [ __CLASS__, 'field_text' ], 'tunebridge_settings', 'tb_section_providers', [ 'key' => 'spotify_client_id' ] );
		add_settings_field( 'spotify_client_secret', __( 'Spotify Client Secret', 'tunebridge' ), [ __CLASS__, 'field_text' ], 'tunebridge_settings', 'tb_section_providers', [ 'key' => 'spotify_client_secret' ] );

		add_settings_section( 'tb_section_general', __( 'General', 'tunebridge' ), function(){ echo '<p>' . esc_html__( 'General preferences and access control.', 'tunebridge' ) . '</p>'; }, 'tunebridge_settings' );

		add_settings_field( 'default_include_tracks', __( 'Include Tracks by Default', 'tunebridge' ), [ __CLASS__, 'field_checkbox' ], 'tunebridge_settings', 'tb_section_general', [ 'key' => 'default_include_tracks', 'label' => __( 'Include tracklists in playlist searches', 'tunebridge' ) ] );
		add_settings_field( 'public_dashboard', __( 'Public Dashboard', 'tunebridge' ), [ __CLASS__, 'field_checkbox' ], 'tunebridge_settings', 'tb_section_general', [ 'key' => 'public_dashboard', 'label' => __( 'Enable public dashboard shortcode', 'tunebridge' ) ] );
		add_settings_field( 'logging_enabled', __( 'Logging', 'tunebridge' ), [ __CLASS__, 'field_checkbox' ], 'tunebridge_settings', 'tb_section_general', [ 'key' => 'logging_enabled', 'label' => __( 'Enable basic logging', 'tunebridge' ) ] );
		add_settings_field( 'allowed_roles', __( 'Allowed Roles', 'tunebridge' ), [ __CLASS__, 'field_roles' ], 'tunebridge_settings', 'tb_section_general', [ 'key' => 'allowed_roles' ] );
	}

	public static function sanitize( $input ) {
		$clean = [];
		$clean['provider_spotify_enabled'] = isset( $input['provider_spotify_enabled'] ) ? 1 : 0;
		$clean['spotify_client_id']        = isset( $input['spotify_client_id'] ) ? sanitize_text_field( $input['spotify_client_id'] ) : '';
		$clean['spotify_client_secret']    = isset( $input['spotify_client_secret'] ) ? sanitize_text_field( $input['spotify_client_secret'] ) : '';
		$clean['default_include_tracks']   = isset( $input['default_include_tracks'] ) ? 1 : 0;
		$clean['public_dashboard']         = isset( $input['public_dashboard'] ) ? 1 : 0;
		$clean['logging_enabled']          = isset( $input['logging_enabled'] ) ? 1 : 0;

		$roles                  = isset( $input['allowed_roles'] ) && is_array( $input['allowed_roles'] ) ? array_map( 'sanitize_text_field', $input['allowed_roles'] ) : [];
		$valid_roles            = array_keys( wp_roles()->roles );
		$clean['allowed_roles'] = array_values( array_intersect( $roles, $valid_roles ) );

		return $clean;
	}

	public static function field_checkbox( $args ) {
		$opts = get_option( 'tunebridge_settings', [] );
		$key  = $args['key']; $val = ! empty( $opts[ $key ] ) ? 1 : 0; $lbl = isset( $args['label'] ) ? $args['label'] : '';
		?><label><input type="checkbox" name="tunebridge_settings[<?php echo esc_attr( $key ); ?>]" value="1" <?php checked( $val, 1 ); ?> /> <?php echo esc_html( $lbl ); ?></label><?php
	}

	public static function field_text( $args ) {
		$opts = get_option( 'tunebridge_settings', [] ); $key = $args['key']; $val = isset( $opts[ $key ] ) ? $opts[ $key ] : '';
		?><input type="text" class="regular-text" name="tunebridge_settings[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $val ); ?>" /><?php
	}

	public static function field_roles( $args ) {
		$opts = get_option( 'tunebridge_settings', [] ); $selected = isset( $opts['allowed_roles'] ) ? (array) $opts['allowed_roles'] : [];
		$all_roles = wp_roles()->roles;
		?><select name="tunebridge_settings[allowed_roles][]" multiple size="5"><?php foreach ( $all_roles as $role_key => $role_data ) : ?><option value="<?php echo esc_attr( $role_key ); ?>" <?php selected( in_array( $role_key, $selected, true ) ); ?>><?php echo esc_html( $role_data['name'] ); ?></option><?php endforeach; ?></select><p class="description"><?php esc_html_e( 'Users with any selected role will be allowed to use TuneBridge features.', 'tunebridge' ); ?></p><?php
	}

	public static function render() {
		if ( ! current_user_can( 'manage_tunebridge_settings' ) ) {
			wp_die( esc_html__( 'You do not have permission to manage settings.', 'tunebridge' ) );
		}
		?><div class="wrap"><h1><?php esc_html_e( 'TuneBridge Settings', 'tunebridge' ); ?></h1><form action="options.php" method="post"><?php settings_fields( 'tunebridge_settings_group' ); do_settings_sections( 'tunebridge_settings' ); submit_button(); ?></form></div><?php
	}
}
