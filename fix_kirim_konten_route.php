<?php
$web = file_get_contents('/var/www/radio/routes/web.php');

$search = "Route::get('/pelatihan', function () {
    \$station = request('station');
    if (\$station && \$station->slug === 'kbrbaik') {
        return view('kbrbaik-pelatihan', compact('station'));
    }
    return view('pelatihan', compact('station'));
})->name('pelatihan');";

$insert = "\nRoute::get('/kirim-konten', function () {
    \$station = request('station');
    \$categories = \App\Models\Category::where('station_id', \$station?->id ?? 1)->get();
    if (\$station && \$station->slug === 'kbrbaik') {
        return view('kbrbaik-kirim-konten', compact('station', 'categories'));
    }
    return view('kirim-konten', compact('station', 'categories'));
})->name('kirim-konten');";

if (strpos($web, $search) !== false) {
    $web = str_replace($search, $search . $insert, $web);
    file_put_contents('/var/www/radio/routes/web.php', $web);
    echo "OK: Route /kirim-konten added.\n";
} else {
    echo "FAIL: pelatihan route not found.\n";
}
