<?php
$f = '/var/www/radio/app/Models/GalleryItem.php';
$c = file_get_contents($f);
$c = str_replace("'is_active',", "'is_active', 'album',", $c);
file_put_contents($f, $c);
echo "OK\n";
