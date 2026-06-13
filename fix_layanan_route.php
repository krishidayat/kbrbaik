<?php
$web = file_get_contents('/var/www/radio/routes/web.php');

$old = "Route::get('/layanan', function () {
    \$station = request('station');
    return view('services', compact('station'));
})->name('services');";

$new = "Route::get('/layanan', function () {
    \$station = request('station');
    if (\$station && \$station->slug === 'kbrbaik') {
        return view('kbrbaik-services', compact('station'));
    }
    return view('services', compact('station'));
})->name('services');";

if (strpos($web, $old) !== false) {
    $web = str_replace($old, $new, $web);
    file_put_contents('/var/www/radio/routes/web.php', $web);
    echo "OK: Route /layanan fixed.\n";
} else {
    echo "FAIL: Old route not found. grep output:\n";
    $lines = file('/var/www/radio/routes/web.php');
    foreach ($lines as $i => $line) {
        if (strpos($line, 'layanan') !== false) {
            echo ($i+1) . ": " . $line;
        }
    }
}
