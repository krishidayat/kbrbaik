<?php
$f = '/var/www/radio/routes/api.php';
$c = file_get_contents($f);
$changes = 0;

$old1 = "Route::get('/kbrbaik/categories', function () {
    \$station = Station::where('domain', request()->getHost())->where('is_active', true)->first();
    if (!\$station) return response()->json([]);
    return response()->json(Category::where('station_id', \$station->id)->where('group', 'kbrbaik')->get(['id', 'name', 'slug']));
})->name('api.kbrbaik.categories');";

$new1 = "Route::get('/kbrbaik/categories', function () {
    \$station = Station::where('domain', request()->getHost())->where('is_active', true)->first();
    \$stationId = \$station?->id ?? 1;
    return response()->json(Category::where('station_id', \$stationId)->where('group', 'kbrbaik')->get(['id', 'name', 'slug']));
})->name('api.kbrbaik.categories');";

$old2 = "\$station = Station::where('domain', request()->getHost())->where('is_active', true)->first();
    if (!\$station) return response()->json(['data' => []]);

    \$query = Post::where('station_id', \$station->id)->where('is_published', true);";

$new2 = "\$station = Station::where('domain', request()->getHost())->where('is_active', true)->first();
    \$stationId = \$station?->id ?? 1;

    \$query = Post::where('station_id', \$stationId)->where('is_published', true);";

if (strpos($c, $old1) !== false) {
    $c = str_replace($old1, $new1, $c);
    $changes++;
}
if (strpos($c, $old2) !== false) {
    $c = str_replace($old2, $new2, $c);
    $changes++;
}
if ($changes > 0) {
    file_put_contents($f, $c);
    echo "OK: $changes changes made.\n";
} else {
    echo "FAIL\n";
}
