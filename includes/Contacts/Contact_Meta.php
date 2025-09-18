<?php

namespace Tunebridge\Contacts;

defined('ABSPATH') || exit;

class Contact_Meta
{
    public static function init()
    {
        add_action('add_meta_boxes', [__CLASS__, 'add_metabox']);
        add_action('save_post_tunebridge_contact', [__CLASS__, 'save_meta']);
    }

    public static function add_metabox()
    {
        add_meta_box(
            'tunebridge_contact_meta',
            __('Contact Details', 'tunebridge'),
            [__CLASS__, 'render_metabox'],
            'tunebridge_contact',
            'normal',
            'default'
        );
    }

    public static function render_metabox($post)
    {
        wp_nonce_field('tunebridge_contact_meta_nonce', 'tunebridge_contact_meta_nonce');

        $meta = [
            'email'     => get_post_meta($post->ID, '_tunebridge_email', true),
            'source'    => get_post_meta($post->ID, '_tunebridge_source', true),
            'platforms' => get_post_meta($post->ID, '_tunebridge_platforms', true),
            'playlists' => get_post_meta($post->ID, '_tunebridge_playlists', true),
            'socials'   => get_post_meta($post->ID, '_tunebridge_socials', true),
            'notes'     => get_post_meta($post->ID, '_tunebridge_notes', true),
        ];

        include TUNEBRIDGE_PATH . 'template-parts/admin/contact-meta-form.php';
    }

    public static function save_meta($post_id)
    {
        if (
            !isset($_POST['tunebridge_contact_meta_nonce']) ||
            !wp_verify_nonce($_POST['tunebridge_contact_meta_nonce'], 'tunebridge_contact_meta_nonce')
        ) {
            return;
        }

        $fields = [
            '_tunebridge_email',
            '_tunebridge_source',
            '_tunebridge_platforms',
            '_tunebridge_playlists',
            '_tunebridge_socials',
            '_tunebridge_notes',
        ];

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}