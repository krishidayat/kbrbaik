<?php
require_once('/home/tanw3558/public_html/wp-load.php');

echo '<h2>Force Purge + Fix</h2>';

// 1. Force set the theme mod
set_theme_mod('hestia_top_bar_hide', false);

// 2. Verify
$val = get_theme_mod('hestia_top_bar_hide', true);
echo '<p>get_theme_mod: ' . var_export($val, true) . '</p>';

// 3. Try to purge LiteSpeed Cache via REST API
$site_url = home_url();
$purge_url = $site_url . '/wp-json/litespeed/v1/purge_all';

$response = wp_remote_post($purge_url, array(
    'timeout' => 5,
    'headers' => array(
        'X-LiteSpeed-Purge' => 'all'
    )
));

if (is_wp_error($response)) {
    echo '<p>Purge REST error: ' . $response->get_error_message() . '</p>';
} else {
    echo '<p>Purge REST status: ' . wp_remote_retrieve_response_code($response) . '</p>';
}

// 4. Try to add purge via .htaccess
$htaccess_path = '/home/tanw3558/public_html/.htaccess';
$htaccess_content = file_get_contents($htaccess_path);
echo '<p>.htaccess length: ' . strlen($htaccess_content) . '</p>';

// Check if there's a cache section
if (strpos($htaccess_content, 'lscache') !== false) {
    echo '<p>Found lscache in .htaccess</p>';
}

// 5. Try the LiteSpeed admin-ajax approach
$ajax_url = admin_url('admin-ajax.php');
echo '<p>Admin AJAX: ' . $ajax_url . '</p>';

echo '<p style="color:green;">DONE! Check site now.</p>';
echo '<p><a href="https://tanganterbukamedia.com/?p=' . mt_rand(1, 99999) . '">Visit site with random param</a></p>';
?>
