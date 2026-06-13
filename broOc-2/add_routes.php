<?php
$f = '/var/www/radio/routes/web.php';
$lines = file($f);
$newLines = [];
$inserted = false;
foreach ($lines as $line) {
    $newLines[] = $line;
    if (!$inserted && strpos($line, 'reorder') !== false) {
        $newLines[] = "    Route::get('/playlist/{period}/library', [PojokController::class, 'library'])->name('pojok.library');\n";
        $newLines[] = "    Route::post('/playlist/{period}/add-from-library', [PojokController::class, 'addFromLibrary'])->name('pojok.addFromLibrary');\n";
        $inserted = true;
    }
}
file_put_contents($f, implode('', $newLines));
echo "Done\n";
