<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

$route = "\n\nRoute::get('/', function () {
    \$station = request('station');
    if (\$station && \$station->slug === 'pojok') {
        return view('pojok', compact('station'));
    }
    return view('kbrbaik-beranda', compact('station'));
})->name('home');\n";

// Replace the existing home route
$old = "Route::get('/', function () {
    \$station = request('station');
    return view('kbrbaik-beranda', compact('station'));
})->name('home');";

$c = str_replace($old, $route, $c);
file_put_contents($f, $c);
echo "OK\n";
