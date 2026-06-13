<?php
$f = '/var/www/radio/resources/views/kbrbaik-services.blade.php';
$c = file_get_contents($f);

$c = str_replace(
    'Aktivitas <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-sky-200">Baik</span>',
    'Wiki Kabar Baik',
    $c
);

file_put_contents($f, $c);
echo "OK\n";
