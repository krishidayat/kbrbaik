<?php
require_once('/home/tanw3558/public_html/wp-load.php');

echo '<h2>Full Header.php Analysis</h2>';

$header_file = '/home/tanw3558/public_html/wp-content/themes/hestia-1/header.php';
$content = file_get_contents($header_file);

// Show first 100 lines
$lines = explode("\n", $content);
for ($i = 0; $i < min(100, count($lines)); $i++) {
    echo '<p>' . ($i+1) . ': ' . htmlspecialchars($lines[$i]) . '</p>';
}
?>
