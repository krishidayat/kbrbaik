with open('/var/www/radio/routes/web.php', 'r') as f:
    lines = f.readlines()

new_route = "Route::get('/pelatihan', function () {\n    $station = request('station');\n    return view('kbrbaik-pelatihan', compact('station'));\n})->name('pelatihan');\n\n"

for i, line in enumerate(lines):
    if "Route::get('/layanan'" in line:
        lines.insert(i, new_route)
        break

with open('/var/www/radio/routes/web.php', 'w') as f:
    f.writelines(lines)

print('Route added')
