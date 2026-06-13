<?php
require_once('/home/tanw3558/public_html/wp-load.php');

echo '<h2>Check if theme mods are cached</h2>';

// Check if LiteSpeed Cache is active
if (class_exists('LiteSpeed_Cache')) {
    echo '<p>LiteSpeed Cache is active</p>';
    
    // Try to purge cache
    if (function_exists('LiteSpeed_Cache::purge_all')) {
        LiteSpeed_Cache::purge_all();
        echo '<p>Purged all cache</p>';
    }
} else {
    echo '<p>LiteSpeed Cache is NOT active</p>';
}

// Check the actual value header.php would see
$hide_top_bar = get_theme_mod('hestia_top_bar_hide', true);
echo '<p>get_theme_mod in theme context: ' . var_export($hide_top_bar, true) . '</p>';

// Check if there are any filters modifying this
$filters = get_filter('theme_mod_hestia_top_bar_hide');
echo '<p>Filters on theme_mod_hestia_top_bar_hide: ' . var_export($filters, true) . '</p>';

echo '<p><a href="https://tanganterbukamedia.com/?nocache=' . time() . '">Visit site</a></p>';
?>
