<?php
$f = '/var/www/radio/app/Providers/Filament/AdminPanelProvider.php';
$c = file_get_contents($f);
$c = str_replace(
    'AppFilamentResourcesAudioTracksAudioTrackResource',
    '\App\Filament\Resources\AudioTracks\AudioTrackResource',
    $c
);
file_put_contents($f, $c);
echo "OK\n";
