<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);
$c = str_replace('AppModelsCommunity::', '\App\Models\Community::', $c);
file_put_contents($f, $c);
echo "OK\n";
