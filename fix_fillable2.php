<?php
$f = '/var/www/radio/app/Models/GalleryItem.php';
$c = file_get_contents($f);
$old = "\$fillable = [
        'station_id', 'uploaded_by', 'title', 'description',
        'image_path', 'thumbnail_path', 'is_active,
        album,',
    ];";
$new = "\$fillable = [
        'station_id', 'uploaded_by', 'title', 'description',
        'image_path', 'thumbnail_path', 'is_active', 'album',
    ];";
$c = str_replace($old, $new, $c);
file_put_contents($f, $c);
echo "OK\n";
