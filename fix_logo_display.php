<?php
$f = '/var/www/radio/resources/views/kbrbaik-komunitas-show.blade.php';
$c = file_get_contents($f);

$c = str_replace('@if (->logo)', '@if ($community->logo)', $c);
$c = str_replace('->logo)', '$community->logo)', $c);
$c = str_replace('->cover_image)', '$community->cover_image)', $c);
$c = str_replace('->name)', '$community->name)', $c);
$c = str_replace('. . $community', '. $community', $c); // fix any double dots

// Remove duplicate <div class="flex-1">
$c = str_replace('<div class="flex-1">' . "\n" . '                <div class="flex-1">", "<div class="flex-1">", $c);

// Actually just fix specifically
$c = str_replace('">\n                @if ($community->logo)
                <img src="{{ asset("storage/" . $community->logo) }}" alt="{{ $community->name }}" class="w-20 h-20 rounded-xl object-cover border-2 border-white/20">
                @elseif ($community->cover_image)
                <img src="{{ asset("storage/" . $community->cover_image) }}" alt="{{ $community->name }}" class="w-20 h-20 rounded-xl object-cover border-2 border-white/20">
                @endif
                <div class="flex-1">
                <div class="flex-1">',
'">
                @if ($community->logo)
                <img src="{{ asset("storage/" . $community->logo) }}" alt="{{ $community->name }}" class="w-20 h-20 rounded-xl object-cover border-2 border-white/20">
                @elseif ($community->cover_image)
                <img src="{{ asset("storage/" . $community->cover_image) }}" alt="{{ $community->name }}" class="w-20 h-20 rounded-xl object-cover border-2 border-white/20">
                @endif
                <div class="flex-1">', $c);

file_put_contents($f, $c);
echo "OK\n";
