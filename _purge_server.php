<?php
// Read .htaccess and add LSCache purge
$htaccess_path = '/home/tanw3558/public_html/.htaccess';
$htaccess = file_get_contents($htaccess_path);

echo '<h2>Current .htaccess (relevant lines)</h2>';
$lines = explode("\n", $htaccess);
foreach ($lines as $i => $line) {
    if (stripos($line, 'cache') !== false || stripos($line, 'lscache') !== false || stripos($line, 'CacheLookup') !== false) {
        echo '<p>Line ' . ($i+1) . ': ' . htmlspecialchars($line) . '</p>';
    }
}

echo '<h2>Try Purge via LiteSpeed API</h2>';

// Method 1: Send PURGE request
$ch = curl_init('https://tanganterbukamedia.com/');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PURGE');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$result = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo '<p>PURGE method result: HTTP ' . $http_code . '</p>';

// Method 2: Touch a file to invalidate cache (LiteSpeed watches for file changes)
$touch_file = '/home/tanw3558/public_html/.lscache_purge';
file_put_contents($touch_file, time());
echo '<p>Created .lscache_purge file</p>';

// Method 3: Add no-cache header via .htaccess
$purge_rule = "\n# Force purge LiteSpeed cache\n<IfModule mod_headers.c>\n    Header set Cache-Control \"no-cache, must-revalidate\"\n</IfModule>\n";

echo '<p><a href="https://tanganterbukamedia.com/?rand=' . mt_rand(1,99999) . '">Visit site</a></p>';
?>
