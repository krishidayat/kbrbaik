<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);
$old = "Route::get('/galeri', function () {
    \$station = request('station');
    \$items = \App\Models\GalleryItem::where('station_id', \$station?->id)->where('is_active', true)->latest()->get();
    if (\$station && \$station->slug === 'kbrbaik') {
        return view('kbrbaik-galeri', compact('station', 'items'));
    }
    return view('galeri', compact('station', 'items'));
})->name('galeri');";
$new = "Route::get('/galeri', function () {
    \$station = request('station');
    \$items = \App\Models\GalleryItem::where('station_id', \$station?->id)->where('is_active', true)->latest()->get();
    \$episodes = \App\Models\Episode::where('station_id', \$station?->id)->where('is_published', true)->latest()->take(20)->get();
    \$studios = \App\Models\Studio::where('station_id', \$station?->id)->get();
    if (\$station && \$station->slug === 'kbrbaik') {
        return view('kbrbaik-galeri', compact('station', 'items', 'episodes', 'studios'));
    }
    return view('galeri', compact('station', 'items', 'episodes', 'studios'));
})->name('galeri');";
if (strpos($c, $old) !== false) {
    $c = str_replace($old, $new, $c);
    file_put_contents($f, $c);
    echo "OK\n";
} else {
    echo "FAIL\n";
}
