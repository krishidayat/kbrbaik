<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

// Try to find and replace the old home route with new one
// Old route pattern - the real original one
$old1 = "Route::get('/', function () {
    \$station = request('station');
    return view('home', compact('station'));
})->name('home');";

// The broken pojok route
$old2 = "Route::get('/', function () {
    return view('pojok', compact('station'));
})->name('home');";

$new = "Route::get('/', function () {
    \$station = request('station');
    if (\$station && \$station->slug === 'pojok') {
        return view('pojok', compact('station'));
    }
    return view('home', compact('station'));
})->name('home');";

if (strpos($c, $old1) !== false) {
    $c = str_replace($old1, $new, $c);
} elseif (strpos($c, $old2) !== false) {
    $c = str_replace($old2, $new, $c);
} else {
    // Remove ANY home route definition at the end
    $c = preg_replace('/Route::get\(\'\/\'.*?->name\(\'home\'\);\n/s', '', $c);
    $c .= "\n\n" . $new;
}

file_put_contents($f, $c);
echo "OK\n";
