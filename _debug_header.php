<?php
require_once('/home/tanw3558/public_html/wp-load.php');

echo '<h2>Debug header.php logic</h2>';

// Simulate what header.php does
$layout = apply_filters('hestia_header_layout', get_theme_mod('hestia_header_layout', 'default'));
echo '<p>$layout: ' . var_export($layout, true) . '</p>';

$disabled_frontpage = get_theme_mod('disable_frontpage_sections', false);
echo '<p>$disabled_frontpage: ' . var_export($disabled_frontpage, true) . '</p>';

$hide_top_bar = get_theme_mod('hestia_top_bar_hide', true);
echo '<p>$hide_top_bar: ' . var_export($hide_top_bar, true) . '</p>';
echo '<p>(bool) $hide_top_bar: ' . var_export((bool) $hide_top_bar, true) . '</p>';
echo '<p>(bool) $hide_top_bar === false: ' . var_export((bool) $hide_top_bar === false, true) . '</p>';

$header_class = '';
if ((bool) $hide_top_bar === false) {
    $header_class .= 'header-with-topbar';
}
echo '<p>$header_class: ' . var_export($header_class, true) . '</p>';

// Check what body_class() would return
$body_classes = get_body_class();
echo '<p>body_class: ' . esc_html(implode(' ', $body_classes)) . '</p>';

echo '<p><a href="https://tanganterbukamedia.com/?nocache=' . time() . '">Visit site</a></p>';
?>
