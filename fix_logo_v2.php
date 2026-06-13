<?php
$f = '/var/www/radio/resources/views/kbrbaik-komunitas-show.blade.php';
$c = file_get_contents($f);

// Fix the broken $community references
$search = array(
    '>\\n                @if (->logo)',
    'alt="{{ ->name }}"',
    'alt="{{ ->name }}" class="w-20 h-20 rounded-xl object-cover border-2 border-white/20">',
    'alt="{{ $community->name }}" class="w-20 h-20 rounded-xl object-cover border-2 border-white/20">',
    'storage/" . ->logo)',
    'storage/" . ->cover_image)',
    '->logo)',
    '->cover_image)',
);

$replace = array(
    '>',
    '',
    '',
    '',
    'storage/" . $community->logo)',
    'storage/" . $community->cover_image)',
    '$community->logo)',
    '$community->cover_image)',
);

$c = str_replace($search, $replace, $c);

// Fix duplicate flex-1 div
$c = str_replace('<div class="flex-1">' . "\n" . '                <div class="flex-1">', '<div class="flex-1">', $c);

file_put_contents($f, $c);
echo "OK\n";
