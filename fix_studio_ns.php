<?php
$f = '/var/www/radio/resources/views/kbrbaik-studio-show.blade.php';
$c = file_get_contents($f);
$c = str_replace('AppModelsPost', '\App\Models\Post', $c);
file_put_contents($f, $c);
echo "OK\n";
