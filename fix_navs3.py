import re

nav_desktop = (
    'route(\'home\') }}" class="hover:text-sky-200 transition">Beranda</a>\n'
    '                <a href="{{ route(\'agenda\') }}" class="hover:text-sky-200 transition">Agenda</a>\n'
    '                <a href="{{ route(\'komunitas\') }}" class="hover:text-sky-200 transition">Komunitas</a>\n'
    '                <a href="{{ route(\'services\') }}" class="hover:text-sky-200 transition">Layanan</a>\n'
    '                <a href="{{ route(\'pelatihan\') }}" class="hover:text-sky-200 transition">Pelatihan</a>\n'
    '                <a href="{{ route(\'galeri\') }}" class="hover:text-sky-200 transition">Galeri</a>\n'
    '                <a href="{{ route(\'radio\') }}" class="hover:text-sky-200 transition">Radio</a>'
)

nav_mobile = (
    'route(\'galeri\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>\n'
    '            <a href="{{ route(\'agenda\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>\n'
    '            <a href="{{ route(\'komunitas\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>\n'
    '            <a href="{{ route(\'services\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Layanan</a>\n'
    '            <a href="{{ route(\'pelatihan\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Pelatihan</a>\n'
    '            <a href="{{ route(\'galeri\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>\n'
    '            <a href="{{ route(\'radio\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>'
)

fixes = {
    "/var/www/radio/resources/views/kbrbaik-agenda.blade.php": [
        (
            'route(\'home\') }}" class="hover:text-sky-200 transition">Beranda</a>\n'
            '                <a href="{{ route(\'home\') }}#projects" class="hover:text-sky-200 transition">Project</a>\n'
            '                <a href="{{ route(\'galeri\') }}" class="hover:text-sky-200 transition">Galeri</a>\n'
            '                <a href="{{ route(\'musik\') }}" class="hover:text-sky-200 transition">Musik</a>\n'
            '                <a href="{{ route(\'radio\') }}" class="hover:text-sky-200 transition">Radio</a>',
            nav_desktop
        ),
        (
            'route(\'galeri\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>\n'
            '            <a href="{{ route(\'musik\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Musik</a>\n'
            '            <a href="{{ route(\'radio\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>',
            'route(\'galeri\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>\n'
            '            <a href="{{ route(\'agenda\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>\n'
            '            <a href="{{ route(\'komunitas\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>\n'
            '            <a href="{{ route(\'services\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Layanan</a>\n'
            '            <a href="{{ route(\'pelatihan\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Pelatihan</a>\n'
            '            <a href="{{ route(\'galeri\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>\n'
            '            <a href="{{ route(\'radio\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>'
        ),
    ],
    "/var/www/radio/resources/views/kbrbaik-agenda-show.blade.php": [
        (
            'route(\'home\') }}" class="hover:text-sky-200 transition">Beranda</a>\n'
            '                <a href="{{ route(\'home\') }}#projects" class="hover:text-sky-200 transition">Project</a>\n'
            '                <a href="{{ route(\'galeri\') }}" class="hover:text-sky-200 transition">Galeri</a>\n'
            '                <a href="{{ route(\'musik\') }}" class="hover:text-sky-200 transition">Musik</a>\n'
            '                <a href="{{ route(\'radio\') }}" class="hover:text-sky-200 transition">Radio</a>',
            nav_desktop
        ),
        (
            'route(\'galeri\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>\n'
            '            <a href="{{ route(\'musik\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Musik</a>\n'
            '            <a href="{{ route(\'radio\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>',
            'route(\'galeri\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>\n'
            '            <a href="{{ route(\'agenda\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>\n'
            '            <a href="{{ route(\'komunitas\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>\n'
            '            <a href="{{ route(\'services\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Layanan</a>\n'
            '            <a href="{{ route(\'pelatihan\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Pelatihan</a>\n'
            '            <a href="{{ route(\'galeri\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>\n'
            '            <a href="{{ route(\'radio\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>'
        ),
    ],
    "/var/www/radio/resources/views/kbrbaik-blog.blade.php": [
        (
            'route(\'galeri\') }}" class="hover:text-sky-200 transition">Galeri</a>\n'
            '                <a href="{{ route(\'musik\') }}" class="hover:text-sky-200 transition">Musik</a>\n'
            '                <a href="{{ route(\'agenda\') }}" class="hover:text-sky-200 transition">Agenda</a>\n'
            '                <a href="{{ route(\'radio\') }}" class="hover:text-sky-200 transition">Radio</a>',
            nav_desktop
        ),
        (
            'route(\'galeri\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>\n'
            '            <a href="{{ route(\'musik\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Musik</a>\n'
            '            <a href="{{ route(\'agenda\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>\n'
            '            <a href="{{ route(\'radio\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>',
            'route(\'galeri\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>\n'
            '            <a href="{{ route(\'agenda\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>\n'
            '            <a href="{{ route(\'komunitas\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>\n'
            '            <a href="{{ route(\'services\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Layanan</a>\n'
            '            <a href="{{ route(\'pelatihan\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Pelatihan</a>\n'
            '            <a href="{{ route(\'galeri\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>\n'
            '            <a href="{{ route(\'radio\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>'
        ),
    ],
    "/var/www/radio/resources/views/kbrbaik-post.blade.php": [
        (
            'route(\'galeri\') }}" class="hover:text-sky-200 transition">Galeri</a>\n'
            '                <a href="{{ route(\'musik\') }}" class="hover:text-sky-200 transition">Musik</a>\n'
            '                <a href="{{ route(\'agenda\') }}" class="hover:text-sky-200 transition">Agenda</a>\n'
            '                <a href="{{ route(\'radio\') }}" class="hover:text-sky-200 transition">Radio</a>',
            nav_desktop
        ),
        (
            'route(\'galeri\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>\n'
            '            <a href="{{ route(\'musik\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Musik</a>\n'
            '            <a href="{{ route(\'agenda\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>\n'
            '            <a href="{{ route(\'radio\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>',
            'route(\'galeri\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>\n'
            '            <a href="{{ route(\'agenda\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>\n'
            '            <a href="{{ route(\'komunitas\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>\n'
            '            <a href="{{ route(\'services\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Layanan</a>\n'
            '            <a href="{{ route(\'pelatihan\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Pelatihan</a>\n'
            '            <a href="{{ route(\'galeri\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>\n'
            '            <a href="{{ route(\'radio\') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>'
        ),
    ],
}

for fp, replacements in fixes.items():
    with open(fp, "r") as f:
        content = f.read()
    for old, new in replacements:
        if old in content:
            content = content.replace(old, new)
            print("Fixed: " + fp)
        else:
            print("NOT FOUND in " + fp)
    with open(fp, "w") as f:
        f.write(content)

print("done")
