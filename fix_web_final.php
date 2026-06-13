<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

// Fix the broken login route
$c = str_replace(
    "Route::get(/login, function () {
    return redirect(/admin/login);
})->name(login);
    return redirect('/admin/login');
})->name('login');",
    "Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');",
    $c
);

// Also fix the radio -> media change
$c = str_replace(
    "Route::get('/radio', function () {",
    "Route::get('/media', function () {",
    $c
);
$c = str_replace(
    "})->name('radio');",
    "})->name('media');",
    $c
);

file_put_contents($f, $c);
echo "OK\n";
