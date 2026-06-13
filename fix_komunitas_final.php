<?php
$f = '/var/www/radio/resources/views/kbrbaik-komunitas.blade.php';
$c = file_get_contents($f);

$old = '            {{-- Filter Sinode --}}
t		@php  = AppModelsCommunity::where(\'station_id\', ?->id ?? 1)->where(\'is_active\', true)->get(); @endphp
            @php $studios = $kom->studios()->where(\'is_active\', true)->get(); @endphp';

$new = '            @php $communities = \App\Models\Community::where(\'station_id\', $station?->id ?? 1)->where(\'is_active\', true)->get(); @endphp
            @forelse ($communities as $kom)
            @php $studios = $kom->studios()->where(\'is_active\', true)->get(); @endphp';

$c = str_replace($old, $new, $c);

// Replace the @foreach with @forelse
$c = str_replace('@foreach ($komunitas as $kom)', '@forelse ($communities as $kom)', $c);

// Remove orphan @endif  
$c = str_replace('@endif

    </script>', '</script>', $c);

file_put_contents($f, $c);
echo "OK\n";
