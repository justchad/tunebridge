<?php

namespace Tunebridge\Contacts;

defined('ABSPATH') || exit;

class Contact_List_Actions
{
    public static function init()
    {
        add_action('restrict_manage_posts', [__CLASS__, 'add_status_filter']);
        add_filter('parse_query', [__CLASS__, 'filter_contacts_by_status']);
        add_filter('bulk_actions-edit-tunebridge_contact', [__CLASS__, 'register_bulk_actions']);
        add_filter('handle_bulk_actions-edit-tunebridge_contact', [__CLASS__, 'handle_bulk_actions'], 10, 3);
    }

    public static function add_status_filter()
    {
        global $typenow;
        if ($typenow !== 'tunebridge_contact') {
            return;
        }

        $selected = $_GET['tunebridge_status_filter'] ?? '';
        $statuses = Contact_Meta::get_statuses();

        echo '<select name="tunebridge_status_filter">';
        echo '<option value="">' . __('All Statuses', 'tunebridge') . '</option>';

        foreach ($statuses as $slug => $label) {
            printf(
                '<option value="%s"%s>%s</option>',
                esc_attr($slug),
                selected($selected, $slug, false),
                esc_html($label)
            );
        }

        echo '</select>';
    }

    public static function filter_contacts_by_status($query)
    {
        global $pagenow;

        if (
            $pagenow === 'edit.php' &&
            isset($_GET['post_type']) &&
            $_GET['post_type'] === 'tunebridge_contact' &&
            !empty($_GET['tunebridge_status_filter'])
        ) {
            $query->query_vars['meta_key']   = '_tunebridge_status';
            $query->query_vars['meta_value'] = sanitize_text_field($_GET['tunebridge_status_filter']);
        }
    }

    public static function register_bulk_actions($actions)
    {
        $statuses = Contact_Meta::get_statuses();
        foreach ($statuses as $slug => $label) {
            $actions["set_status_{$slug}"] = sprintf(__('Set status: %s', 'tunebridge'), $label);
        }
        return $actions;
    }

    public static function handle_bulk_actions($redirect_to, $doaction, $post_ids)
    {
        if (strpos($doaction, 'set_status_') !== 0) {
            return $redirect_to;
        }

        $status = str_replace('set_status_', '', $doaction);
        $count = 0;

        foreach ($post_ids as $post_id) {
            update_post_meta($post_id, '_tunebridge_status', $status);
            $count++;
        }

        return add_query_arg([
            'tunebridge_bulk_status_updated' => $count,
            'tunebridge_bulk_status_set'     => $status,
        ], $redirect_to);
    }
}