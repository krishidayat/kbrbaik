<?php
$web = file_get_contents('/var/www/radio/routes/web.php');

// Fix /galeri route
$oldGaleri = "Route::get('/galeri', function () {
    \$station = request('station');
    \$items = \App\Models\GalleryItem::where('station_id', \$station?->id)->where('is_active', true)->latest()->get();
    return view('galeri', compact('station', 'items'));
})->name('galeri');";

$newGaleri = "Route::get('/galeri', function () {
    \$station = request('station');
    \$items = \App\Models\GalleryItem::where('station_id', \$station?->id)->where('is_active', true)->latest()->get();
    if (\$station && \$station->slug === 'kbrbaik') {
        return view('kbrbaik-galeri', compact('station', 'items'));
    }
    return view('galeri', compact('station', 'items'));
})->name('galeri');";

// Fix /radio route
$oldRadio = "Route::get('/radio', function () {
    \$station = request('station');
    \$items = \$station->playlistItems()->where('is_active', true)->orderBy('sort_order')->get();
    return view('radio', compact('station', 'items'));
})->name('radio');";

$newRadio = "Route::get('/radio', function () {
    \$station = request('station');
    \$items = \$station->playlistItems()->where('is_active', true)->orderBy('sort_order')->get();
    if (\$station && \$station->slug === 'kbrbaik') {
        return view('kbrbaik-radio', compact('station', 'items'));
    }
    return view('radio', compact('station', 'items'));
})->name('radio');";

$changes = 0;

if (strpos($web, $oldGaleri) !== false) {
    $web = str_replace($oldGaleri, $newGaleri, $web);
    echo "OK: /galeri route fixed.\n";
    $changes++;
} else {
    echo "FAIL: /galeri route not found.\n";
}

if (strpos($web, $oldRadio) !== false) {
    $web = str_replace($oldRadio, $newRadio, $web);
    echo "OK: /radio route fixed.\n";
    $changes++;
} else {
    echo "FAIL: /radio route not found.\n";
}

if ($changes > 0) {
    file_put_contents('/var/www/radio/routes/web.php', $web);
    echo "File saved with $changes changes.\n";
}
