<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

// Fix the komunitas route - replace broken Community query
$c = str_replace(
    "\$stationAppModelsCommunity::where(\"station_id\", ?->id)->where('is_active', true)->get()",
    "\App\Models\Community::where('station_id', \$station?->id)->where('is_active', true)->get()",
    $c
);

// Also check if there's another broken pattern
$c = str_replace(
    "\$stationAppModelsCommunity",
    "\$station = \App\Models\Community",
    $c
);

file_put_contents($f, $c);
echo "OK\n";
