<?php
require_once('/home/tanw3558/public_html/wp-load.php');

echo '<h2>Debug get_theme_mod</h2>';

// Check the raw option
$raw = get_option('theme_mods_hestia-1');
echo '<pre>Raw theme_mods_hestia-1: ' . print_r($raw, true) . '</pre>';

// Check if hestia_top_bar_hide exists in the array
echo '<p>isset($raw["hestia_top_bar_hide"]): ' . var_export(isset($raw['hestia_top_bar_hide']), true) . '</p>';
echo '<p>$raw["hestia_top_bar_hide"] value: ' . var_export($raw['hestia_top_bar_hide'] ?? 'NOT SET', true) . '</p>';
echo '<p>typeof: ' . gettype($raw['hestia_top_bar_hide'] ?? null) . '</p>';

// Test get_theme_mod directly
$tm = get_theme_mod('hestia_top_bar_hide', 'DEFAULT_VALUE');
echo '<p>get_theme_mod result: ' . var_export($tm, true) . '</p>';

// Try to use the update method that Hestia uses
set_theme_mod('hestia_top_bar_hide', false);
$tm2 = get_theme_mod('hestia_top_bar_hide', 'DEFAULT_VALUE');
echo '<p>After set_theme_mod, get_theme_mod: ' . var_export($tm2, true) . '</p>';

// Check again
$raw2 = get_option('theme_mods_hestia-1');
echo '<pre>Raw after set: hestia_top_bar_hide = ' . var_export($raw2['hestia_top_bar_hide'] ?? 'NOT SET', true) . '</pre>';

echo '<p><a href="https://tanganterbukamedia.com/?nocache=' . time() . '">Visit site</a></p>';
?>
