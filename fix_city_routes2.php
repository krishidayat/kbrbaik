<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

$route = "\n\nRoute::get('/{city}', function (\$city) {
    \$station = request('station');
    \$allKom = \App\Models\Community::where('station_id', \$station?->id ?? 1)->where('is_active', true)->get();
    foreach (\$allKom as \$kom) {
        \$slugCity = \Illuminate\Support\Str::after(\$kom->slug, '-');
        if (!\$slugCity) \$slugCity = \$kom->slug;
        if (strtolower(\$city) === strtolower(\$slugCity)) {
            return redirect()->route('komunitas.show', \$kom->slug);
        }
    }
    abort(404);
})->name('komunitas.city');\n";

file_put_contents($f, $c . $route);
echo "OK\n";
