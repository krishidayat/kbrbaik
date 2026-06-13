with open('/var/www/radio/routes/web.php', 'r') as f:
    content = f.read()

# Update galeri route
old_galeri = "Route::get('/galeri', function () {\n    $station = request('station');\n    $items = $station->galleryItems()->orderBy('created_at', 'desc')->get();\n    return view('galeri', compact('station', 'items'));\n})->name('galeri');"

new_galeri = "Route::get('/galeri', function () {\n    $station = request('station');\n    $items = $station->galleryItems()->orderBy('created_at', 'desc')->get();\n    $view = $station && $station->slug === 'kbrbaik' ? 'kbrbaik-galeri' : 'galeri';\n    return view($view, compact('station', 'items'));\n})->name('galeri');"

content = content.replace(old_galeri, new_galeri, 1)

# Update radio route
old_radio = "Route::get('/radio', function () {\n    $station = request('station');\n    $items = App\\Models\\SongRequest::where('station_id', $station->id)->where('is_active', true)->orderBy('order')->get();\n    return view('radio', compact('station', 'items'));\n})->name('radio');"

new_radio = "Route::get('/radio', function () {\n    $station = request('station');\n    $items = App\\Models\\SongRequest::where('station_id', $station->id)->where('is_active', true)->orderBy('order')->get();\n    $view = $station && $station->slug === 'kbrbaik' ? 'kbrbaik-radio' : 'radio';\n    return view($view, compact('station', 'items'));\n})->name('radio');"

content = content.replace(old_radio, new_radio, 1)

with open('/var/www/radio/routes/web.php', 'w') as f:
    f.write(content)
print('Routes updated')
