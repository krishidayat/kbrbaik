import os

views_dir = "/var/www/radio/resources/views"
files = [
    "beranda.blade.php", "kbrbaik.blade.php", "kbrbaik-agenda.blade.php",
    "kbrbaik-agenda-show.blade.php", "kbrbaik-blog.blade.php", "kbrbaik-post.blade.php",
    "kbrbaik-komunitas.blade.php", "kbrbaik-komunitas-show.blade.php", "kbrbaik-studio-show.blade.php",
    "kbrbaik-pelatihan.blade.php", "kbrbaik-services.blade.php", "kbrbaik-galeri.blade.php",
    "kbrbaik-radio.blade.php",
]

old_logo = '<a href="{{ route(\'home\') }}" class="flex items-center">\n                <img src="{{ asset(\'images/kbrbaik-logo.png\') }}" alt="KBRBaik" class="h-10 w-auto">\n            </a>'

new_nav = '<a href="{{ route(\'home\') }}" class="flex items-center gap-2">\n                <img src="{{ asset(\'images/kbrbaik-logo.png\') }}" alt="KBRBaik" class="h-9 w-auto">\n                <span class="text-lg font-bold tracking-tight">Radio KbrBaik</span>\n            </a>'

for fname in files:
    fp = os.path.join(views_dir, fname)
    if not os.path.exists(fp):
        continue
    with open(fp, 'r') as f:
        content = f.read()
    if old_logo in content:
        content = content.replace(old_logo, new_nav, 1)
        print(f"Updated: {fname}")
    else:
        print(f"NOT FOUND: {fname}")
    with open(fp, 'w') as f:
        f.write(content)
print("done")
