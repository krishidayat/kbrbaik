<?php
$f = '/var/www/radio/routes/web.php';

// Read current file
$content = file_get_contents($f);

// Remove the bad autodj lines (lines with . concatenation)
$content = preg_replace('/Route::(get|post)\( \. \/[a-z\/]+,.*autoDj.*\n/', '', $content);

// Find the closing of the pojok domain group and insert autodj routes
$search = "    Route::post('/rss-import', [PojokController::class, 'importRss'])->name('pojok.rss.import');\n});";
$replace = "    Route::post('/rss-import', [PojokController::class, 'importRss'])->name('pojok.rss.import');\n    Route::get('/autodj/status', [PojokController::class, 'autoDjStatus'])->name('pojok.autodj.status');\n    Route::post('/autodj/toggle', [PojokController::class, 'autoDjToggle'])->name('pojok.autodj.toggle');\n});";

if (strpos($content, $search) !== false) {
    $content = str_replace($search, $replace, $content);
    file_put_contents($f, $content);
    echo "Autodj routes inserted in domain group\n";
} else {
    echo "Search string not found - checking alternate...\n";
    // Try alternate - find just the closing
    $pos = strrpos($content, "});\n\nRoute::domain('pojok.kbrbaik.live')");
    if ($pos !== false) {
        $before = substr($content, 0, $pos);
        $after = substr($content, $pos);
        // Insert autodj routes before the closing of the first group
        $closePos = strrpos($before, "});");
        if ($closePos !== false) {
            $before = substr_replace($before, "\n    Route::get('/autodj/status', [PojokController::class, 'autoDjStatus'])->name('pojok.autodj.status');\n    Route::post('/autodj/toggle', [PojokController::class, 'autoDjToggle'])->name('pojok.autodj.toggle');\n", $closePos, 0);
            file_put_contents($f, $before . $after);
            echo "Autodj routes inserted via rpos\n";
        }
    } else {
        echo "Could not find insertion point\n";
    }
}
