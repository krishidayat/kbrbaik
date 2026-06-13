<?php
$f = '/var/www/radio/routes/api.php';
$c = file_get_contents($f);

$albumRoute = <<<'PHP'

Route::get('/galeri/albums', function () {
    $station = \App\Models\Station::where('domain', request()->getHost())->where('is_active', true)->first();
    $stationId = $station?->id ?? 1;
    $albums = \App\Models\GalleryItem::where('station_id', $stationId)
        ->where('is_active', true)
        ->whereNotNull('album')
        ->where('album', '!=', '')
        ->select('album', \Illuminate\Support\Facades\DB::raw('COUNT(*) as count'))
        ->groupBy('album')
        ->orderBy('album')
        ->get();
    return response()->json($albums);
})->name('api.galeri.albums');
PHP;

$c = rtrim($c) . "\n" . $albumRoute . "\n";
file_put_contents($f, $c);
echo "OK\n";
