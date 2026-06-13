<?php
$f = '/var/www/radio/resources/views/kbrbaik-komunitas-show.blade.php';
$c = file_get_contents($f);

$old = '<div class="flex-1">
                @if ($community->logo)
                <img src="{{ asset("storage/" . $community$community->logo) }}"  class="w-20 h-20 rounded-xl object-cover border-2 border-white/20">
                @elseif ($community->cover_image)
                <img src="{{ asset("storage/" . $community$community->cover_image) }}"  class="w-20 h-20 rounded-xl object-cover border-2 border-white/20">
                @endif
                <div class="flex-1">';

$new = '<div class="flex-1">
                    @if ($community->logo)
                    <img src="{{ asset(\'storage/\' . $community->logo) }}" alt="{{ $community->name }}" class="w-20 h-20 rounded-xl object-cover border-2 border-white/20">
                    @elseif ($community->cover_image)
                    <img src="{{ asset(\'storage/\' . $community->cover_image) }}" alt="{{ $community->name }}" class="w-20 h-20 rounded-xl object-cover border-2 border-white/20">
                    @endif
                    <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-white/70">Komunitas Stasiun Lokal</span>';

$c = str_replace($old, $new, $c);
file_put_contents($f, $c);
echo "OK\n";
