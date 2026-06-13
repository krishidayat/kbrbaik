<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

$old = "Route::get('/', function () {
    \$station = request('station');
    if (\$station && \$station->slug === 'pojok') {
        return view('pojok', compact('station'));
    }
    return view('home', compact('station'));
})->name('home');";

$new = "Route::get('/', function () {
    \$station = request('station');
    if (\$station && \$station->slug === 'pojok') {
        return view('pojok', compact('station'));
    }
    \$schedules = \$station?->schedules()->where('is_active', true)->get();
    \$episodes = \$station?->episodes()->where('is_published', true)->latest()->take(5)->get();
    return view('home', compact('station', 'schedules', 'episodes'));
})->name('home');";

$c = str_replace($old, $new, $c);
file_put_contents($f, $c);
echo "OK\n";
