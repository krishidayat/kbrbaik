<?php
$f = '/var/www/radio/app/Providers/Filament/AdminPanelProvider.php';
$c = file_get_contents($f);
$c = str_replace(
    'App\Filament\Resources\RencanaKerjas\RencanaKerjaResource',
    '\App\Filament\Resources\RencanaKerjas\RencanaKerjaResource',
    $c
);
file_put_contents($f, $c);
echo "OK\n";
