<?php
$f = '/var/www/radio/routes/web.php';
$lines = file($f);
$new = [];
foreach ($lines as $line) {
    $new[] = $line;
}
$new[] = "    Route::get('/autodj/status', [PojokController::class, 'autoDjStatus'])->name('pojok.autodj.status');\n";
$new[] = "    Route::post('/autodj/toggle', [PojokController::class, 'autoDjToggle'])->name('pojok.autodj.toggle');\n";
file_put_contents($f, implode('', $new));
echo "Done\n";
