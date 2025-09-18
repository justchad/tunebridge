<?php

namespace Tunebridge\Ajax;

use Tunebridge\Data\Mock_Data;

defined('ABSPATH') || exit;

class Playlist_Search_Ajax
{

    public static function init()
    {
        add_action('wp_ajax_tunebridge_search_playlists', [__CLASS__, 'handle_search']);
    }

    public static function handle_search()
    {
        check_ajax_referer('tunebridge_nonce');

        $query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';

        $results = array_filter(Mock_Data::get_playlists(), function ($playlist) use ($query) {
            return stripos($playlist['name'], $query) !== false || stripos($playlist['curator'], $query) !== false;
        });

        wp_send_json_success(array_values($results));
    }
}