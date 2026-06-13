<?php
$file = '/var/www/radio/routes/web.php';
$content = file_get_contents($file);

$oldLayanan = "Route::get('/layanan', function () {\n    \$station = request('station');\n    return view('services', compact('station'));\n})->name('services');";
$newLayanan = "Route::get('/layanan', function () {\n    \$station = request('station');\n    \$view = \$station && \$station->slug === 'kbrbaik' ? 'kbrbaik-services' : 'services';\n    return view(\$view, compact('station'));\n})->name('services');";

$found = str_contains($content, $oldLayanan);
echo "Old layanan found: " . ($found ? 'YES' : 'NO') . "\n";

if ($found) {
    $content = str_replace($oldLayanan, $newLayanan, $content);
    echo "Layanan route updated\n";
}

$pattern = '/Route::get\([^)]*pelatihan[^)]*\).*?\)->name\([^)]*pelatihan[^)]*\);/s';
$content = preg_replace($pattern, '', $content);

$marker = "Route::get('/beranda', function ()";
$insertPos = strpos($content, $marker);
echo "Beranda marker found at: " . ($insertPos !== false ? $insertPos : 'NOT FOUND') . "\n";

if ($insertPos !== false) {
    $newPelatihan = "\nRoute::get('/pelatihan', function () {\n    \$station = request('station');\n    \$view = \$station && \$station->slug === 'kbrbaik' ? 'kbrbaik-pelatihan' : 'pelatihan';\n    return view(\$view, compact('station'));\n})->name('pelatihan');\n";
    $content = substr_replace($content, $newPelatihan, $insertPos, 0);
    echo "Pelatihan route inserted\n";
}

file_put_contents($file, $content);
echo "Written. File size: " . strlen($content) . "\n";
