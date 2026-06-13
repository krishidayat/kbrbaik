<?php
require_once('/home/tanw3558/public_html/wp-load.php');

echo '<h2>Final Verification</h2>';

// Check the value
$val = get_theme_mod('hestia_top_bar_hide', 'DEFAULT');
echo '<p>get_theme_mod: ' . var_export($val, true) . '</p>';
echo '<p>Type: ' . gettype($val) . '</p>';

// Check raw
$raw = get_option('theme_mods_hestia-1');
echo '<p>Raw value: ' . var_export($raw['hestia_top_bar_hide'] ?? 'NOT SET', true) . '</p>';

// Check what header.php would do
$hide_top_bar = get_theme_mod('hestia_top_bar_hide', true);
$header_class = '';
if ((bool) $hide_top_bar === false) {
    $header_class .= 'header-with-topbar';
}
echo '<p>$header_class: ' . var_export($header_class, true) . '</p>';
echo '<p>(bool) $hide_top_bar: ' . var_export((bool) $hide_top_bar, true) . '</p>';
echo '<p>(bool) $hide_top_bar === false: ' . var_export((bool) $hide_top_bar === false, true) . '</p>';

// Force set again to be sure
set_theme_mod('hestia_top_bar_hide', false);

// Check again
$val2 = get_theme_mod('hestia_top_bar_hide', 'DEFAULT');
echo '<p>After force set, get_theme_mod: ' . var_export($val2, true) . '</p>';

echo '<p><a href="https://tanganterbukamedia.com/?p=' . time() . '">Visit site with cache-busting param</a></p>';
?>
