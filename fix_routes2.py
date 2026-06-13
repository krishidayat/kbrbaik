with open('/var/www/radio/routes/web.php', 'r') as f:
    content = f.read()

old_galeri = "Route::get('/galeri', function () {\n    $station = request('station');\n    $items = \\App\\Models\\GalleryItem::where('station_id', $station?->id)->where('is_active', true)->latest()->get();\n    return view('galeri', compact('station', 'items'));\n})->name('galeri');"
new_galeri = "Route::get('/galeri', function () {\n    $station = request('station');\n    $items = \\App\\Models\\GalleryItem::where('station_id', $station?->id)->where('is_active', true)->latest()->get();\n    $view = $station && $station->slug === 'kbrbaik' ? 'kbrbaik-galeri' : 'galeri';\n    return view($view, compact('station', 'items'));\n})->name('galeri');"

if old_galeri in content:
    content = content.replace(old_galeri, new_galeri, 1)
    print('Galeri route updated')
else:
    print('Galeri route NOT FOUND - checking actual content')
    # Debug: find the actual line
    lines = content.split('\n')
    for i, line in enumerate(lines):
        if "Route::get('/galeri'" in line:
            print(f'Line {i+1}: {line}')
            for j in range(i, i+6):
                if j < len(lines):
                    print(f'  {j+1}: {lines[j]}')

old_radio = "Route::get('/radio', function () {\n    $station = request('station');\n    $items = $station->playlistItems()->where('is_active', true)->orderBy('sort_order')->get();\n    return view('radio', compact('station', 'items'));\n})->name('radio');"
new_radio = "Route::get('/radio', function () {\n    $station = request('station');\n    $items = $station->playlistItems()->where('is_active', true)->orderBy('sort_order')->get();\n    $view = $station && $station->slug === 'kbrbaik' ? 'kbrbaik-radio' : 'radio';\n    return view($view, compact('station', 'items'));\n})->name('radio');"

if old_radio in content:
    content = content.replace(old_radio, new_radio, 1)
    print('Radio route updated')
else:
    print('Radio route NOT FOUND - checking actual content')
    lines = content.split('\n')
    for i, line in enumerate(lines):
        if "Route::get('/radio'" in line:
            print(f'Line {i+1}: {line}')
            for j in range(i, i+6):
                if j < len(lines):
                    print(f'  {j+1}: {lines[j]}')

with open('/var/www/radio/routes/web.php', 'w') as f:
    f.write(content)
