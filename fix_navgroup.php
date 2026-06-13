<?php
$f = '/var/www/radio/app/Filament/Resources/RencanaKerjas/RencanaKerjaResource.php';
$c = file_get_contents($f);
$c = str_replace(
    'protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;',
    'protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationGroup = \'Content\';',
    $c
);
file_put_contents($f, $c);
echo "OK\n";
