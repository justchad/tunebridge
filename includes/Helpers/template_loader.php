<?php

defined('ABSPATH') || exit;

if (!function_exists('tunebridge_load_template')) {
    /**
     * Loads a plugin template part.
     *
     * @param string $path Relative path under /TemplateParts/, e.g., 'Dashboard/Blocks/contact_today'.
     * @param array  $args Optional array of arguments to pass to the template.
     */
    function tunebridge_load_template($path, $args = [])
    {
        $template_path = plugin_dir_path(__FILE__) . '../../TemplateParts/' . $path . '.php';

        if (file_exists($template_path)) {
            extract($args);
            include $template_path;
        } else {
            error_log("TuneBridge template not found: {$template_path}");
        }
    }
}