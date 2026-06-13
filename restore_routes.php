<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

$routes = <<<'PHP'

Route::get('/agenda', function () {
    $station = request('station');
    $items = $station?->events()->where('is_published', true)->orderBy('event_date', 'desc')->get();
    $types = collect();
    if ($station && $station->slug === 'kbrbaik') {
        return view('kbrbaik-agenda', compact('station', 'items', 'types'));
    }
    return view('kbrbaik-agenda', compact('station', 'items', 'types'));
})->name('agenda');

Route::get('/komunitas', function () {
    $station = request('station');
    $communities = $station?->communities()->where('is_active', true)->get();
    if ($station && $station->slug === 'kbrbaik') {
        return view('kbrbaik-komunitas', compact('station', 'communities'));
    }
    return view('kbrbaik-komunitas', compact('station', 'communities'));
})->name('komunitas');

Route::get('/layanan', function () {
    $station = request('station');
    if ($station && $station->slug === 'kbrbaik') {
        return view('kbrbaik-services', compact('station'));
    }
    return view('services', compact('station'));
})->name('services');

Route::get('/pelatihan', function () {
    $station = request('station');
    if ($station && $station->slug === 'kbrbaik') {
        return view('kbrbaik-pelatihan', compact('station'));
    }
    return view('pelatihan', compact('station'));
})->name('pelatihan');

Route::get('/radio', function () {
    $station = request('station');
    $items = $station?->playlistItems()->where('is_active', true)->orderBy('sort_order')->get();
    if ($station && $station->slug === 'kbrbaik') {
        return view('kbrbaik-radio', compact('station', 'items'));
    }
    return view('radio', compact('station', 'items'));
})->name('radio');
PHP;

// Insert before the galeri route
$search = "Route::get('/galeri', function () {";
if (strpos($c, $search) !== false) {
    $c = str_replace($search, $routes . "\n" . $search, $c);
    file_put_contents($f, $c);
    echo "OK\n";
} else {
    echo "FAIL\n";
}
