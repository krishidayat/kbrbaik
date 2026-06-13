<?php
$f = '/var/www/radio/resources/views/home.blade.php';
$c = file_get_contents($f);
$c = str_replace(
    '<span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-sky-200">menghidupkan</span>',
    '<span id="ketik" class="text-transparent bg-clip-text bg-gradient-to-r from-white to-sky-200 font-bold"></span>',
    $c
);
file_put_contents($f, $c);
echo "OK\n";
