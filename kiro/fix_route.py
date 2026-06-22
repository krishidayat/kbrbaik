path = '/var/www/radio/app/Http/Controllers/StudioController.php'
content = open(path).read()
new = content.replace("return view('studio.dashboard',", "return view('studio.dashboard_v2',")
open(path, 'w').write(new)
n = new.count("studio.dashboard_v2'")
print(f"OK: {n} replacement(s)")
