<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

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
