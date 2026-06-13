<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);
$old = "return view('kbrbaik-studio-show', compact('station', 'community', 'studio', 'episodes'));";
$new = "\$galleries = \App\Models\GalleryItem::where('station_id', \$station?->id ?? 1)->where('is_active', true)->latest()->get();
    return view('kbrbaik-studio-show', compact('station', 'community', 'studio', 'episodes', 'galleries'));";
if (strpos($c, $old) !== false) {
    $c = str_replace($old, $new, $c);
    file_put_contents($f, $c);
    echo "OK\n";
} else {
    echo "FAIL\n";
}
