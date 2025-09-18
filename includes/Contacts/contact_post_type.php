<?php

namespace Tunebridge\Contacts;

defined('ABSPATH') || exit;

class Contact_Post_Type
{

    public static function init()
    {
        add_action('init', [__CLASS__, 'register']);
    }

    public static function register()
    {
        register_post_type('tunebridge_contact', [
            'labels' => [
                'name' => __('Contacts', 'tunebridge'),
                'singular_name' => __('Contact', 'tunebridge'),
            ],
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'supports' => ['title', 'editor', 'custom-fields'],
            'capability_type' => 'post',
            'capabilities' => [
                'create_posts' => 'manage_options',
            ],
            'map_meta_cap' => true,
        ]);
    }
}