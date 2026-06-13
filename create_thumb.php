<?php
require '/var/www/radio/vendor/autoload.php';
$manager = new Intervention\Image\ImageManager(new Intervention\Image\Drivers\Gd\Driver());
$img = $manager->decodePath('/var/www/radio/storage/app/public/gallery/OdnQO8tX8K5rPXijrkY9TRpsIvjRh1Sf0xG0tVST.jpg');
$img->cover(400, 400);
$img->toJpeg(80)->save('/var/www/radio/storage/app/public/gallery/thumbs/OdnQO8tX8K5rPXijrkY9TRpsIvjRh1Sf0xG0tVST.jpg');
echo "Thumbnail created\n";
