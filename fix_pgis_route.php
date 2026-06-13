<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

$old = "Route::get('/pgis/{slug}', function (\$slug) {
    \$station = request('station');
    \$item = \App\Models\Category::where('slug', \$slug)->where('station_id', \$station?->id)->where('group', 'pgis')->firstOrFail();
    \$posts = \$item->posts()->where('is_published', true)->latest()->paginate(10);
    return view('suara.group-profile', compact('station', 'item', 'posts'));
})->name('pgis.profile');";

$new = "Route::get('/pgis/{slug}', function (\$slug) {
    \$station = request('station');
    \$item = \App\Models\Category::where('slug', \$slug)->where('station_id', \$station?->id)->where('group', 'pgis')->firstOrFail();
    \$posts = \$item->posts()->where('is_published', true)->latest()->paginate(10);
    return view('suara.pgis-profile', compact('station', 'item', 'posts'));
})->name('pgis.profile');";

$c = str_replace($old, $new, $c);
file_put_contents($f, $c);
echo "OK\n";
