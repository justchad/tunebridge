<?php

namespace Tunebridge\Ajax;

use Tunebridge\Data\Mock_Data;

defined('ABSPATH') || exit;

class Search_Artists_Ajax
{

    public static function init()
    {
        add_action('wp_ajax_tunebridge_search_artists', [__CLASS__, 'handle']);
    }

    public static function handle()
    {
        check_ajax_referer('tunebridge_nonce', 'nonce');

        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';

        if (empty($name)) {
            wp_send_json_error(['message' => 'Artist name is required.']);
        }

        // Return mock data for now
        $artists = Mock_Data::get_artists();

        // Simulate search filtering (basic match)
        $results = array_filter($artists, function ($artist) use ($name) {
            return stripos($artist['name'], $name) !== false;
        });

        wp_send_json_success(array_values($results));
    }
}