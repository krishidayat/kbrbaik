<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

// Remove the broken pojok route at the end
$c = preg_replace('/\n\nRoute::get\(\'\/\', function \(\) \{[^}]+}\)->name\(\'home\'\);/s', '', $c);

// Remove the old home route (the real one)
$c = preg_replace('/Route::get\(\'\/\', function \(\) \{[^}]+}\)->name\(\'home\'\);/s', '', $c);

// Add the new route with poisok check
$newRoute = "\n\nRoute::get('/', function () {
    \$station = request('station');
    if (\$station && \$station->slug === 'pojok') {
        return view('pojok', compact('station'));
    }
    return view('home', compact('station'));
})->name('home');\n";

$c .= $newRoute;
file_put_contents($f, $c);
echo "OK\n";
