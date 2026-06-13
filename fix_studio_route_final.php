<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

// The entire broken studio block starts at line 173. Let's find and replace it
$old = "Route::get('/studio/{slug}', function () {
     = request('station');
     = AppModelsStudio::where('slug', )->where('station_id', ?->id ?? 1)->where('is_active', true)->with('community')->firstOrFail();
     = ->episodes()->where('is_published', true)->latest()->take(10)->get();
    return view('kbrbaik-studio-show', compact('station', 'studio', 'episodes'));
})->name('studio.show');";

$new = "Route::get('/studio/{slug}', function (\$slug) {
    \$station = request('station');
    \$studio = \App\Models\Studio::where('slug', \$slug)->where('station_id', \$station?->id ?? 1)->where('is_active', true)->with('community')->firstOrFail();
    \$episodes = \$studio->episodes()->where('is_published', true)->latest()->take(10)->get();
    return view('kbrbaik-studio-show', compact('station', 'studio', 'episodes'));
})->name('studio.show');";

if (strpos($c, $old) !== false) {
    $c = str_replace($old, $new, $c);
    file_put_contents($f, $c);
    echo "OK\n";
} else {
    echo "FAIL: pattern not found\n";
}
