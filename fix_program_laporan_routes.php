<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

$routes = <<<'PHP'

Route::get('/program-kerja', function () {
    $station = request('station');
    return view('suara.program-kerja', compact('station'));
})->name('program.kerja');

Route::get('/laporan', function () {
    $station = request('station');
    return view('suara.laporan', compact('station'));
})->name('laporan');
PHP;

$search = "Route::get('/bidang', function () {";
if (strpos($c, $search) !== false) {
    $c = str_replace($search, $routes . "\n" . $search, $c);
    file_put_contents($f, $c);
    echo "OK\n";
} else {
    echo "FAIL\n";
}
