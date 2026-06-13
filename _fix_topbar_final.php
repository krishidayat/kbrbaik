<?php
require_once('/home/tanw3558/public_html/wp-load.php');

echo '<h2>Fix Top Bar - Set to false explicitly</h2>';

// Get current theme mods
$mods = get_option('theme_mods_hestia-1', array());

echo '<p>Before: hestia_top_bar_hide = ' . var_export(isset($mods['hestia_top_bar_hide']) ? $mods['hestia_top_bar_hide'] : 'NOT SET', true) . '</p>';

// Set to FALSE explicitly (not empty string!)
$mods['hestia_top_bar_hide'] = false;
update_option('theme_mods_hestia-1', $mods);

// Also set as separate option
update_option('hestia_top_bar_hide', false);

// Verify
$check = get_option('theme_mods_hestia-1');
echo '<p>After: hestia_top_bar_hide = ' . var_export($check['hestia_top_bar_hide'], true) . '</p>';
echo '<p>Type: ' . gettype($check['hestia_top_bar_hide']) . '</p>';

// Test the logic
$hide_top_bar = get_theme_mod('hestia_top_bar_hide', true);
echo '<p>get_theme_mod returns: ' . var_export($hide_top_bar, true) . '</p>';
echo '<p>(bool) $hide_top_bar === false: ' . var_export((bool) $hide_top_bar === false, true) . '</p>';

echo '<p style="color:green; font-size:20px;">DONE! Top bar should now show.</p>';
echo '<p><a href="https://tanganterbukamedia.com/?nocache=' . time() . '" style="font-size:18px;">Visit site (no cache)</a></p>';
?>
