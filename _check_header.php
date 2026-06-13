<?php
require_once('/home/tanw3558/public_html/wp-load.php');

echo '<h2>Hestia Theme Header Check</h2>';

// Read the parent theme header.php
$header_file = '/home/tanw3558/public_html/wp-content/themes/hestia-1/header.php';
$content = file_get_contents($header_file);

// Search for top bar related code
$lines = explode("\n", $content);
foreach ($lines as $i => $line) {
    if (stripos($line, 'top_bar') !== false || stripos($line, 'top-bar') !== false || stripos($line, 'topbar') !== false || stripos($line, 'header_with') !== false) {
        echo '<p>Line ' . ($i+1) . ': ' . htmlspecialchars($line) . '</p>';
    }
}

echo '<h2>Child Theme Check</h2>';
$child_header = '/home/tanw3558/public_html/wp-content/themes/hestia-1-child/header.php';
if (file_exists($child_header)) {
    echo '<p>Child theme header.php EXISTS</p>';
    $child_content = file_get_contents($child_header);
    echo '<pre>' . htmlspecialchars(substr($child_content, 0, 2000)) . '</pre>';
} else {
    echo '<p>Child theme header.php does NOT exist (uses parent)</p>';
}

echo '<h2>Functions Check (top bar related)</h2>';
$functions_file = '/home/tanw3558/public_html/wp-content/themes/hestia-1/functions.php';
$func_content = file_get_contents($functions_file);
$func_lines = explode("\n", $func_content);
foreach ($func_lines as $i => $line) {
    if (stripos($line, 'top_bar') !== false || stripos($line, 'header_with_topbar') !== false) {
        echo '<p>Line ' . ($i+1) . ': ' . htmlspecialchars($line) . '</p>';
    }
}
?>
