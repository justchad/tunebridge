<?php

namespace Tunebridge\Contacts;

defined('ABSPATH') || exit;

class Contact_Post_Type
{
    public static function init()
    {
        add_action('init', [__CLASS__, 'register_post_type']);
        add_action('init', [__CLASS__, 'register_taxonomy']);
    }

    public static function register_post_type()
    {
        register_post_type('tunebridge_contact', [
            'labels' => [
                'name' => __('Contacts', 'tunebridge'),
                'singular_name' => __('Contact', 'tunebridge'),
            ],
            'public' => false,
            'show_ui' => true,
            'capability_type' => 'post',
            'supports' => ['title', 'editor'],
            'menu_icon' => 'dashicons-id',
            'show_in_menu' => false,
        ]);
    }

    public static function register_taxonomy()
    {
        register_taxonomy('tunebridge_status', 'tunebridge_contact', [
            'label' => __('Status', 'tunebridge'),
            'hierarchical' => false,
            'public' => false,
            'show_ui' => true,
            'show_admin_column' => true,
        ]);

        // Add default terms on plugin activation
        add_action('init', [__CLASS__, 'register_default_statuses']);
    }

    public static function register_default_statuses()
    {
        $statuses = [
            'Never Contacted',
            'Initial Sent',
            'Follow-Up',
            'Replied',
            'Do Not Contact',
        ];

        foreach ($statuses as $status) {
            if (!term_exists($status, 'tunebridge_status')) {
                wp_insert_term($status, 'tunebridge_status');
            }
        }
    }
}