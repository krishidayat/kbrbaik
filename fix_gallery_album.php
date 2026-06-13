<?php
$f = '/var/www/radio/app/Http/Controllers/GalleryItemController.php';
$c = file_get_contents($f);

$c = str_replace(
    "'description' => 'nullable|string|max:1000',",
    "'description' => 'nullable|string|max:1000',
            'album' => 'nullable|string|max:100',",
    $c
);

// Also pass album to processAndSave - find the call
$c = str_replace(
    "\$station->id, auth()->id(), \$data['title'], \$data['description'] ?? null, \$tempPath, \$filename, \$request",
    "\$station->id, auth()->id(), \$data['title'], \$data['description'] ?? null, \$data['album'] ?? null, \$tempPath, \$filename, \$request",
    $c
);

// Update processAndSave to accept album
$c = str_replace(
    "protected function processAndSave(int \$stationId, ?int \$userId, string \$title, ?string \$description, string \$tempPath, string \$filename, ?Request \$request = null): mixed
    {
        try {",
    "protected function processAndSave(int \$stationId, ?int \$userId, string \$title, ?string \$description, ?string \$album, string \$tempPath, string \$filename, ?Request \$request = null): mixed
    {
        try {",
    $c
);

// Add album to create call
$c = str_replace(
    "'description' => \$description,",
    "'description' => \$description,
                'album' => \$album,",
    $c
);

file_put_contents($f, $c);
echo "OK\n";
