<?php
$f = '/var/www/radio/resources/views/kbrbaik-blog.blade.php';
$c = file_get_contents($f);

$c = str_replace(
    "cats.forEach(function(c, i) {",
    "cats.unshift({slug:'semua',name:'Semua',id:0});
            cats.forEach(function(c, i) {",
    $c
);

file_put_contents($f, $c);
echo "OK\n";
