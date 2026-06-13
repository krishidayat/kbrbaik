<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

$route = "\n\nRoute::get('/studio', function () {
    \$station = request('station');
    if (\$station && \$station->slug === 'kbrbaik') {
        return view('kbrbaik-studio', compact('station'));
    }
    return view('kbrbaik-studio', compact('station'));
})->name('studio');\n";

$search = "Route::get('/layanan', function () {";
$c = str_replace($search, $route . $search, $c);
file_put_contents($f, $c);
echo "OK\n";
