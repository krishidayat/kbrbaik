<?php
$host = 'kbrbaik.live';
echo 'Host: ' . $host . PHP_EOL;
$station = \App\Models\Station::where('domain', $host)->where('is_active', true)->first();
echo 'Station found: ' . ($station ? 'yes id=' . $station->id : 'no') . PHP_EOL;
$stationId = $station?->id ?? 1;
echo 'StationId: ' . $stationId . PHP_EOL;
$cats = \App\Models\Category::where('station_id', $stationId)->where('group', 'kbrbaik')->get();
echo 'Categories count: ' . $cats->count() . PHP_EOL;
foreach ($cats as $c) echo ' - id=' . $c->id . ' name=' . $c->name . PHP_EOL;
