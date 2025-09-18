<?php

namespace Tunebridge\Contacts;

defined('ABSPATH') || exit;

class Contact_List_Table
{
    public static function init()
    {
        add_filter('manage_tunebridge_contact_posts_columns', [__CLASS__, 'columns']);
        add_action('manage_tunebridge_contact_posts_custom_column', [__CLASS__, 'column_content'], 10, 2);
        add_filter('manage_edit-tunebridge_contact_sortable_columns', [__CLASS__, 'sortable_columns']);
    }

    public static function columns($columns)
    {
        unset($columns['date']); // We'll move it to the end

        return array_merge($columns, [
            'email'  => __('Email', 'tunebridge'),
            'source' => __('Source', 'tunebridge'),
            'status' => __('Status', 'tunebridge'),
            'date'   => __('Date', 'tunebridge'),
        ]);
    }

    public static function column_content($column, $post_id)
    {
        switch ($column) {
            case 'email':
                echo esc_html(get_post_meta($post_id, '_tunebridge_email', true));
                break;
            case 'source':
                echo esc_html(get_post_meta($post_id, '_tunebridge_source', true));
                break;
            case 'status':
                $status = get_post_meta($post_id, '_tunebridge_status', true);
                echo esc_html($status ?: __('Not Set', 'tunebridge'));
                break;
        }
    }

    public static function sortable_columns($columns)
    {
        $columns['email'] = 'email';
        $columns['source'] = 'source';

        return $columns;
    }
}