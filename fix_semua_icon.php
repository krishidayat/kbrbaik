<?php
$f = '/var/www/radio/resources/views/kbrbaik-blog.blade.php';
$c = file_get_contents($f);

$c = str_replace(
    "var icons = {",
    "var icons = {\n" .
    "        'semua': '<svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M4 6h16M4 12h16M4 18h16\"/></svg>',",
    $c
);

file_put_contents($f, $c);
echo "OK\n";
