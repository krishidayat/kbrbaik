<?php
$f = '/var/www/radio/app/Filament/Resources/Posts/Schemas/PostForm.php';
$c = file_get_contents($f);
$old = "FileUpload::make('featured_image')
                    ->image(),";
$new = "FileUpload::make('featured_image')
                    ->image()
                    ->disk('public'),";
if (strpos($c, $old) !== false) {
    $c = str_replace($old, $new, $c);
    file_put_contents($f, $c);
    echo "OK: Updated PostForm with ->disk('public')\n";
} else {
    echo "FAIL: Old code not found\n";
    // debug
    $lines = file($f);
    foreach ($lines as $i => $l) {
        if (strpos($l, 'FileUpload') !== false) {
            echo ($i+1) . ": " . $l;
        }
    }
}
