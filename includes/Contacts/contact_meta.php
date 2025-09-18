<?php

namespace Tunebridge\Contacts;

defined('ABSPATH') || exit;

class Contact_Meta
{

    public static function init()
    {
        add_action('add_meta_boxes', [__CLASS__, 'add_meta_boxes']);
        add_action('save_post', [__CLASS__, 'save_meta']);
    }

    public static function add_meta_boxes()
    {
        add_meta_box(
            'tunebridge_contact_meta',
            __('Contact Details', 'tunebridge'),
            [__CLASS__, 'render_meta_box'],
            'tunebridge_contact',
            'normal',
            'default'
        );
    }

    public static function render_meta_box($post)
    {
        wp_nonce_field('tunebridge_save_contact_meta', 'tunebridge_contact_nonce');

        $email = get_post_meta($post->ID, '_contact_email', true);
        $status = get_post_meta($post->ID, '_contact_status', true);

        echo '<label>Email:</label>';
        echo '<input type="email" name="contact_email" value="' . esc_attr($email) . '" class="widefat" />';
        echo '<br><br>';
        echo '<label>Status:</label>';
        echo '<input type="text" name="contact_status" value="' . esc_attr($status) . '" class="widefat" />';
    }

    public static function save_meta($post_id)
    {
        if (
            !isset($_POST['tunebridge_contact_nonce']) ||
            !wp_verify_nonce($_POST['tunebridge_contact_nonce'], 'tunebridge_save_contact_meta')
        ) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        if (isset($_POST['contact_email'])) {
            update_post_meta($post_id, '_contact_email', sanitize_email($_POST['contact_email']));
        }

        if (isset($_POST['contact_status'])) {
            update_post_meta($post_id, '_contact_status', sanitize_text_field($_POST['contact_status']));
        }
    }
}