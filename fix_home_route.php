<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

$old = "Route::get('/', function () {
    \$station = request('station');
    return view('home', compact('station'));
})->name('home');";

$new = "Route::get('/', function () {
    \$station = request('station');
    if (\$station && \$station->slug === 'pojok') {
        return view('pojok', compact('station'));
    }
    return view('home', compact('station'));
})->name('home');";

if (strpos($c, $old) !== false) {
    $c = str_replace($old, $new, $c);
    file_put_contents($f, $c);
    echo "OK\n";
} else {
    echo "FAIL: pattern not found\n";
}
