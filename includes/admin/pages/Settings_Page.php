<?php

namespace Tunebridge\Admin\Pages;

defined('ABSPATH') || exit;

class Settings_Page
{

    public static function render()
    {
?>
<div class="wrap tunebridge-settings">
    <h1><?php esc_html_e('TuneBridge Settings', 'tunebridge'); ?></h1>

    <form method="post" action="options.php">
        <?php
                settings_fields('tunebridge_settings');
                do_settings_sections('tunebridge_settings');
                submit_button();
                ?>
    </form>
</div>
<?php
    }

    public static function register()
    {
        add_action('admin_init', [__CLASS__, 'register_settings']);
    }

    public static function register_settings()
    {
        add_settings_section(
            'tunebridge_spotify_section',
            __('Spotify API Credentials', 'tunebridge'),
            '__return_null',
            'tunebridge_settings'
        );

        register_setting('tunebridge_settings', 'tunebridge_spotify_client_id', [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ]);

        register_setting('tunebridge_settings', 'tunebridge_spotify_client_secret', [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ]);

        add_settings_field(
            'tunebridge_spotify_client_id',
            __('Client ID', 'tunebridge'),
            [__CLASS__, 'render_client_id_field'],
            'tunebridge_settings',
            'tunebridge_spotify_section'
        );

        add_settings_field(
            'tunebridge_spotify_client_secret',
            __('Client Secret', 'tunebridge'),
            [__CLASS__, 'render_client_secret_field'],
            'tunebridge_settings',
            'tunebridge_spotify_section'
        );

        // ✅ Developer Settings Section
        add_settings_section(
            'tunebridge_dev_section',
            __('Developer Settings', 'tunebridge'),
            function () {
                echo '<p>' . esc_html__('Options useful during development or testing.', 'tunebridge') . '</p>';
            },
            'tunebridge_settings'
        );

        register_setting('tunebridge_settings', 'tunebridge_use_mock_data', [
            'type'              => 'boolean',
            'sanitize_callback' => 'rest_sanitize_boolean',
        ]);

        add_settings_field(
            'tunebridge_use_mock_data',
            __('Use Mock Data', 'tunebridge'),
            [__CLASS__, 'render_mock_data_field'],
            'tunebridge_settings',
            'tunebridge_dev_section'
        );
    }



    public static function render_client_id_field()
    {
        $value = esc_attr(get_option('tunebridge_spotify_client_id', ''));
        echo '<input type="text" name="tunebridge_spotify_client_id" value="' . $value . '" class="regular-text" />';
    }

    public static function render_client_secret_field()
    {
        $value = esc_attr(get_option('tunebridge_spotify_client_secret', ''));
        echo '<input type="password" name="tunebridge_spotify_client_secret" value="' . $value . '" class="regular-text" />';
    }

    public static function render_mock_data_field()
    {
        $value = get_option('tunebridge_use_mock_data', false);
        echo '<label><input type="checkbox" name="tunebridge_use_mock_data" value="1" ' . checked(1, $value, false) . '> ';
        esc_html_e('Enable stub data responses instead of live API', 'tunebridge');
        echo '</label>';
    }
}