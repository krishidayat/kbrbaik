<?php
$web = file_get_contents('/var/www/radio/routes/web.php');

$search = "Route::get('/layanan', function () {
    \$station = request('station');
    if (\$station && \$station->slug === 'kbrbaik') {
        return view('kbrbaik-services', compact('station'));
    }
    return view('services', compact('station'));
})->name('services');

Route::get('/beranda', function () {";

$replace = "Route::get('/layanan', function () {
    \$station = request('station');
    if (\$station && \$station->slug === 'kbrbaik') {
        return view('kbrbaik-services', compact('station'));
    }
    return view('services', compact('station'));
})->name('services');

Route::get('/pelatihan', function () {
    \$station = request('station');
    if (\$station && \$station->slug === 'kbrbaik') {
        return view('kbrbaik-pelatihan', compact('station'));
    }
    return view('pelatihan', compact('station'));
})->name('pelatihan');

Route::get('/beranda', function () {";

if (strpos($web, $search) !== false) {
    $web = str_replace($search, $replace, $web);
    file_put_contents('/var/www/radio/routes/web.php', $web);
    echo "OK: Route /pelatihan added.\n";
} else {
    echo "FAIL: Context not found.\n";
    $lines = file('/var/www/radio/routes/web.php');
    foreach ($lines as $i => $line) {
        if (strpos($line, 'layanan') !== false || strpos($line, 'beranda') !== false) {
            echo ($i+1) . ": " . $line;
        }
    }
}
