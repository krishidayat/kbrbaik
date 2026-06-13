<?php
require_once('/home/tanw3558/public_html/wp-load.php');

echo '<h2>Check functions.php files</h2>';

// Check parent theme functions.php
$parent = '/home/tanw3558/public_html/wp-content/themes/hestia-1/functions.php';
$parent_content = file_get_contents($parent);

echo '<p>Parent functions.php:</p>';
echo '<p>Size: ' . strlen($parent_content) . ' bytes</p>';
echo '<p>Has ttm_topbar: ' . var_export(strpos($parent_content, 'ttm_topbar') !== false, true) . '</p>';

// Check child theme functions.php
$child = '/home/tanw3558/public_html/wp-content/themes/hestia-1-child/functions.php';
if (file_exists($child)) {
    $child_content = file_get_contents($child);
    echo '<p>Child functions.php:</p>';
    echo '<p>Size: ' . strlen($child_content) . ' bytes</p>';
    echo '<p>First 200 chars: ' . htmlspecialchars(substr($child_content, 0, 200)) . '</p>';
} else {
    echo '<p>Child functions.php does NOT exist</p>';
}

// Verify current theme
$theme = wp_get_theme();
echo '<p>Active theme: ' . $theme->get('Name') . ' (' . $theme->get_stylesheet() . ')</p>';
echo '<p>Template: ' . $theme->get('Template') . '</p>';

echo '<p><a href="https://tanganterbukamedia.com/?rand=' . mt_rand(1,99999) . '">Visit site</a></p>';
?>
