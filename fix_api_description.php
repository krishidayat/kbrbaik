<?php
$f = '/var/www/radio/routes/api.php';
$c = file_get_contents($f);
$c = str_replace(
    "'title' => 'required|string|max:255',\n                'image' => 'required|image|max:10240',",
    "'title' => 'required|string|max:255',\n                'description' => 'nullable|string|max:1000',\n                'image' => 'required|image|max:10240',",
    $c
);
$c = str_replace(
    "\$item->title = \$validated['title'];\n            \$item->image_path",
    "\$item->title = \$validated['title'];\n            \$item->description = \$validated['description'] ?? null;\n            \$item->image_path",
    $c
);
file_put_contents($f, $c);
echo "OK\n";
