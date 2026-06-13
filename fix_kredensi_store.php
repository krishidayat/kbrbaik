<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

$old = "    \$validated = \$request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'lead' => 'nullable|string|max:500',
        'category_id' => 'nullable|exists:categories,id',
        'studio_id' => 'nullable|exists:studios,id',
    ]);";

$new = "    \$validated = \$request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'lead' => 'nullable|string|max:500',
        'category_id' => 'nullable|exists:categories,id',
        'studio_id' => 'nullable|exists:studios,id',
        'image' => 'nullable|image|max:5120',
    ]);";

$c = str_replace($old, $new, $c);

// Add image processing after body_format
$old2 = "    \$post->body_format = 'markdown';";
$new2 = "    \$post->body_format = 'markdown';
    if (\$request->hasFile('image')) {
        \$manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
        \$filename = md5(microtime()) . '.jpg';
        \$img = \$manager->decodePath(\$request->file('image')->getRealPath());
        \$img->resizeDown(1920, 1920);
        \Illuminate\Support\Facades\Storage::disk('public')->put(
            'featured/' . \$filename,
            \$img->encode(new \Intervention\Image\Encoders\JpegEncoder(85))->toString()
        );
        \$post->featured_image = 'featured/' . \$filename;
    }";

$c = str_replace($old2, $new2, $c);
file_put_contents($f, $c);
echo "OK\n";
