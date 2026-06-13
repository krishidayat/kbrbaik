<?php
$liq = '#!/usr/bin/liquidsoap

set("log.file", true)
set("log.file.path", "/var/log/liquidsoap/purwodadi.log")
set("log.level", 3)

# Playlists by time of day
pagi = playlist("/var/radio/audio/purwodadi/pagi/")
siang = playlist("/var/radio/audio/purwodadi/siang/")
malam = playlist("/var/radio/audio/purwodadi/malam/")

# Time-based switching
radio = switch(track_sensitive=true,
    [({6h00m-12h00m}, pagi),
     ({12h00m-18h00m}, siang),
     ({18h00m-06h00m}, malam)]
)

# Live input via BUTT (port 8006)
live = input.harbor("purwodadi.live", port=8006, buffer=5.0, max=30.)

# Fallback: live when available, otherwise AutoDJ
final = fallback(track_sensitive=false, [live, radio])

# Output to Icecast
output.icecast(%mp3(bitrate=128, stereo=true),
    host="localhost", port=8000,
    mount="purwodadi", password="hackme",
    name="Kabar Purwodadi", genre="Christian",
    url="https://kbrbaik.live", description="Radio Komunitas Kabar Purwodadi",
    final
)
';

file_put_contents('/etc/liquidsoap/purwodadi.liq', $liq);
echo "OK\n";
