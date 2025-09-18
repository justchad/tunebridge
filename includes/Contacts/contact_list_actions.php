<?php

namespace Tunebridge\Contacts;

defined('ABSPATH') || exit;

class Contact_List_Actions
{

    public static function init()
    {
        add_filter('post_row_actions', [__CLASS__, 'add_row_actions'], 10, 2);
    }

    public static function add_row_actions($actions, $post)
    {
        if ($post->post_type !== 'tunebridge_contact') return $actions;

        $actions['message'] = '<a href="#">' . __('Send Message', 'tunebridge') . '</a>';
        return $actions;
    }
}