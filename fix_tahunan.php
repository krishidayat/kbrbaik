<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

$route = "\n\nRoute::get('/agenda/tahunan', function () {
    \$station = request('station');
    \$year = request('year', date('Y'));
    \$events = \$station?->events()
        ->where('is_published', true)
        ->whereYear('event_date', \$year)
        ->orderBy('event_date', 'asc')
        ->get()
        ->groupBy(function(\$e) {
            return \$e->event_date->format('F');
        });
    \$view = \$station && \$station->slug === 'kbrbaik' ? 'kbrbaik-agenda-tahunan' : 'suara.agenda-tahunan';
    return view(\$view, compact('station', 'events', 'year'));
})->name('agenda.tahunan');\n";

$search = "Route::get('/agenda/kalender',";
if (strpos($c, $search) !== false) {
    $c = str_replace($search, $route . "\n" . $search, $c);
    file_put_contents($f, $c);
    echo "OK\n";
} else {
    echo "FAIL\n";
}
