<?php
$f = '/var/www/radio/routes/api.php';
$c = file_get_contents($f);

$old = "            \$path = \$request->file('image')->store('gallery', 'public');
            \$item = new \App\Models\GalleryItem();
            \$item->station_id = \$studio->station_id;
            \$item->studio_id = \$studio->id;
            \$item->title = \$validated['title'];
            \$item->description = \$validated['description'] ?? null;
            \$item->image_path = str_replace('public/', '', \$path);
            \$item->thumbnail_path = str_replace('public/', '', \$path);";

$new = "            // Process image with Intervention
            \$manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            \$file = \$request->file('image');
            \$filename = md5(microtime()) . '.jpg';

            // Main image — resize to max 1920px
            \$img = \$manager->read(\$file->getRealPath());
            \$img->resizeDown(1920, 1920);
            \$img->toJpeg(80)->save(storage_path('app/public/gallery/' . \$filename));

            // Thumbnail — 400x400 with letterboxing
            \$thumb = \$manager->read(\$file->getRealPath());
            \$thumb->cover(400, 400);
            \$thumb->toJpeg(80)->save(storage_path('app/public/gallery/thumbs/' . \$filename));

            \$item = new \App\Models\GalleryItem();
            \$item->station_id = \$studio->station_id;
            \$item->studio_id = \$studio->id;
            \$item->title = \$validated['title'];
            \$item->description = \$validated['description'] ?? null;
            \$item->image_path = 'gallery/' . \$filename;
            \$item->thumbnail_path = 'gallery/thumbs/' . \$filename;";

$c = str_replace($old, $new, $c);
file_put_contents($f, $c);
echo "OK\n";
