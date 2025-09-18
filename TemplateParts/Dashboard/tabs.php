<?php
defined('ABSPATH') || exit;

$tabs = [
    'dashboard' => __('Dashboard', 'tunebridge'),
    'messaging' => __('Messaging', 'tunebridge'),
    'contacts'  => __('Contacts', 'tunebridge'),
];

$current_tab = $_GET['tab'] ?? 'dashboard';
?>

<h2 class="nav-tab-wrapper">
    <?php foreach ($tabs as $key => $label) : ?>
    <a href="?page=tunebridge&tab=<?php echo esc_attr($key); ?>"
        class="nav-tab <?php echo $current_tab === $key ? 'nav-tab-active' : ''; ?>">
        <?php echo esc_html($label); ?>
    </a>
    <?php endforeach; ?>
</h2>