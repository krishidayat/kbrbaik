<?php
$f = '/var/www/radio/routes/api.php';
$c = file_get_contents($f);
$c = str_replace(
    "Route::post('/api/autopost'",
    "Route::post('/autopost'",
    $c
);
file_put_contents($f, $c);
echo "OK: Fixed route prefix.\n";
