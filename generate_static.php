<?php
$f = '/var/www/radio/resources/views/pojok.blade.php';
$c = file_get_contents($f);
$c = preg_replace('/@auth.*?@endauth/s', '', $c);
$c = str_replace("{{ date('Y') }}", '2026', $c);
file_put_contents('/var/www/pojok/index.html', $c);
echo "OK\n";
