<?php
require '/var/www/radio/vendor/autoload.php';
$app = require_once '/var/www/radio/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

$source = '/var/www/radio/storage/app/public/gallery/OdnQO8tX8K5rPXijrkY9TRpsIvjRh1Sf0xG0tVST.jpg';
$thumbPath = 'gallery/thumbs/OdnQO8tX8K5rPXijrkY9TRpsIvjRh1Sf0xG0tVST.jpg';

$manager = new ImageManager(new Driver());
$img = $manager->decodePath($source);
$img->cover(400, 400);
\Illuminate\Support\Facades\Storage::disk('public')->put($thumbPath, $img->encode(new JpegEncoder(80))->toString());
echo "OK\n";
