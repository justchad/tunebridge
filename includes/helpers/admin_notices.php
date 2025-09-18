<?php

defined('ABSPATH') || exit;

use Tunebridge\Utilities\Admin_Notices;

function tunebridge_add_notice($message, $type = 'success')
{
    Admin_Notices::add_notice($message, $type);
}