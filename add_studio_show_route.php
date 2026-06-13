<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

$route = "\n\nRoute::get('/studio/{slug}', function (\$slug) {
    \$station = request('station');
    \$studio = \App\Models\Studio::where('slug', \$slug)->where('station_id', \$station?->id ?? 1)->where('is_active', true)->with('community')->firstOrFail();
    if (\$station && \$station->slug === 'kbrbaik') {
        return view('kbrbaik-studio-show', compact('station', 'studio'));
    }
    return view('kbrbaik-studio-show', compact('station', 'studio'));
})->name('studio.show');\n";

// Insert before galeri route
$search = "Route::get('/galeri', function () {";
$c = str_replace($search, $route . $search, $c);
file_put_contents($f, $c);
echo "OK\n";
