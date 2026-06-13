import os, glob

views_dir = "/var/www/radio/resources/views"
files = [
    "beranda.blade.php",
    "kbrbaik.blade.php",
    "kbrbaik-agenda.blade.php",
    "kbrbaik-agenda-show.blade.php",
    "kbrbaik-blog.blade.php",
    "kbrbaik-post.blade.php",
    "kbrbaik-komunitas.blade.php",
    "kbrbaik-komunitas-show.blade.php",
    "kbrbaik-studio-show.blade.php",
    "kbrbaik-pelatihan.blade.php",
    "kbrbaik-services.blade.php",
    "kbrbaik-galeri.blade.php",
    "kbrbaik-radio.blade.php",
]

logo_html = '<a href="{{ route(\'home\') }}" class="flex items-center">\n                <img src="{{ asset(\'images/kbrbaik-logo.png\') }}" alt="KBRBaik" class="h-10 w-auto">\n            </a>'

for fname in files:
    fp = os.path.join(views_dir, fname)
    if not os.path.exists(fp):
        print(f"SKIP: {fname} not found")
        continue
    with open(fp, 'r') as f:
        content = f.read()

    # Pattern 1: <span class="text-xl font-bold tracking-tight">{{ $station?->name ?? 'KBRBaik' }}</span>
    old1 = "<span class=\"text-xl font-bold tracking-tight\">{{ $station?->name ?? 'KBRBaik' }}</span>"
    # Pattern 2: <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight hover:text-sky-200 transition">{{ $station?->name ?? 'KBRBaik' }}</a>
    old2 = "<a href=\"{{ route('home') }}\" class=\"text-xl font-bold tracking-tight hover:text-sky-200 transition\">{{ $station?->name ?? 'KBRBaik' }}</a>"
    # Pattern 3: double quote version for komunitas files
    old3 = "<span class=\"text-xl font-bold tracking-tight\">{{ $station?->name ?? \"KBRBaik\" }}</span>"

    if old1 in content:
        content = content.replace(old1, logo_html, 1)
        print(f"Fixed (span): {fname}")
    elif old2 in content:
        content = content.replace(old2, logo_html, 1)
        print(f"Fixed (a): {fname}")
    elif old3 in content:
        content = content.replace(old3, logo_html, 1)
        print(f"Fixed (span double): {fname}")
    else:
        print(f"NOT FOUND: {fname}")

    with open(fp, 'w') as f:
        f.write(content)

print("done")
