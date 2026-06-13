<?php
require_once('/home/tanw3558/public_html/wp-load.php');

echo '<h2>Purge LiteSpeed Cache</h2>';

// Try to purge all cache
if (class_exists('LiteSpeed_Cache')) {
    echo '<p>LiteSpeed Cache class exists</p>';
    
    // Try different purge methods
    if (method_exists('LiteSpeed_Cache', 'purge_all')) {
        LiteSpeed_Cache::purge_all();
        echo '<p>Purged all cache via purge_all()</p>';
    }
    
    if (method_exists('LiteSpeed_Cache', 'flush')) {
        LiteSpeed_Cache::flush();
        echo '<p>Flushed cache via flush()</p>';
    }
} else {
    echo '<p>LiteSpeed Cache class NOT found</p>';
}

// Also try to purge via wp_cache_flush
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo '<p>Flushed object cache via wp_cache_flush()</p>';
}

// Check if LiteSpeed Cache plugin is active
$active_plugins = get_option('active_plugins');
echo '<p>Active plugins:</p>';
foreach ($active_plugins as $plugin) {
    if (stripos($plugin, 'litespeed') !== false) {
        echo '<p>- ' . esc_html($plugin) . '</p>';
    }
}

echo '<p><a href="https://tanganterbukamedia.com/?nocache=' . time() . '">Visit site</a></p>';
?>
