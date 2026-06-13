<?php
$f = '/var/www/radio/routes/api.php';
$c = file_get_contents($f);

$old = "            // Process image with Intervention
            \$manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            \$file = \$request->file('image');
            \$filename = md5(microtime()) . '.jpg';

            // Main image — resize to max 1920px
            \$img = \$manager->decodePath(\$file->getRealPath());
            \$img->resizeDown(1920, 1920);
            \$img->toJpeg(80)->save(storage_path('app/public/gallery/' . \$filename));

            // Thumbnail — 400x400 with letterboxing
            \$thumb = \$manager->decodePath(\$file->getRealPath());
            \$thumb->cover(400, 400);
            \$thumb->toJpeg(80)->save(storage_path('app/public/gallery/thumbs/' . \$filename));";

$new = "            // Process image with Intervention
            \$manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            \$file = \$request->file('image');
            \$filename = md5(microtime()) . '.jpg';

            // Main image — resize to max 1920px
            \$img = \$manager->decodePath(\$file->getRealPath());
            \$img->resizeDown(1920, 1920);
            \Illuminate\Support\Facades\Storage::disk('public')->put(
                'gallery/' . \$filename,
                \$img->encode(new \Intervention\Image\Encoders\JpegEncoder(85))->toString()
            );

            // Thumbnail — 400x400 with letterboxing
            \$thumb = \$manager->decodePath(\$file->getRealPath());
            \$thumb->cover(400, 400);
            \Illuminate\Support\Facades\Storage::disk('public')->put(
                'gallery/thumbs/' . \$filename,
                \$thumb->encode(new \Intervention\Image\Encoders\JpegEncoder(80))->toString()
            );";

$c = str_replace($old, $new, $c);
file_put_contents($f, $c);
echo "OK\n";
