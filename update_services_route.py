with open('/var/www/radio/routes/web.php', 'r') as f:
    content = f.read()

old_route = "Route::get('/layanan', function () {\n    $station = request('station');\n    return view('services', compact('station'));\n})->name('services');"

new_route = "Route::get('/layanan', function () {\n    $station = request('station');\n    $view = $station && $station->slug === 'kbrbaik' ? 'kbrbaik-services' : 'services';\n    return view($view, compact('station'));\n})->name('services');"

content = content.replace(old_route, new_route, 1)

with open('/var/www/radio/routes/web.php', 'w') as f:
    f.write(content)
print('Route updated')
