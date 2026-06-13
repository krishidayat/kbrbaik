<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

$route = <<<'PHP'

Route::get('/struktur-pgiw', function () {
    $station = request('station');
    return view('suara.struktur-pgiw', compact('station'));
})->name('struktur.pgiw');
PHP;

// Insert before the bidang route
$search = "Route::get('/bidang', function () {";
if (strpos($c, $search) !== false) {
    $c = str_replace($search, $route . "\n" . $search, $c);
    file_put_contents($f, $c);
    echo "OK\n";
} else {
    echo "FAIL\n";
}
