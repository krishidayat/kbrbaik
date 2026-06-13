import re

files = [
    "/var/www/radio/resources/views/kbrbaik.blade.php",
    "/var/www/radio/resources/views/kbrbaik-agenda.blade.php",
    "/var/www/radio/resources/views/kbrbaik-agenda-show.blade.php",
    "/var/www/radio/resources/views/kbrbaik-blog.blade.php",
    "/var/www/radio/resources/views/kbrbaik-post.blade.php",
]

old_nav_desktop = """            <div class="hidden md:flex space-x-6 text-sm">
                <a href="{{ route('home') }}" class="hover:text-sky-200 transition">Beranda</a>
                <a href="{{ route('galeri') }}" class="hover:text-sky-200 transition">Galeri</a>
                <a href="{{ route('musik') }}" class="hover:text-sky-200 transition">Musik</a>
                <a href="{{ route('agenda') }}" class="hover:text-sky-200 transition">Agenda</a>
                <a href="{{ route('radio') }}" class="hover:text-sky-200 transition">Radio</a>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('galeri') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>
            <a href="{{ route('musik') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Musik</a>
            <a href="{{ route('agenda') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>
            <a href="{{ route('radio') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>
        </div>"""

new_nav = """            <div class="hidden md:flex space-x-6 text-sm">
                <a href="{{ route('home') }}" class="hover:text-sky-200 transition">Beranda</a>
                <a href="{{ route('galeri') }}" class="hover:text-sky-200 transition">Galeri</a>
                <a href="{{ route('agenda') }}" class="hover:text-sky-200 transition">Agenda</a>
                <a href="{{ route('komunitas') }}" class="hover:text-sky-200 transition">Komunitas</a>
                <a href="{{ route('services') }}" class="hover:text-sky-200 transition">Layanan</a>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('galeri') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>
            <a href="{{ route('agenda') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>
            <a href="{{ route('komunitas') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>
            <a href="{{ route('services') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Layanan</a>
        </div>"""

for f in files:
    with open(f, "r") as fh:
        content = fh.read()
    if "route('musik')" in content or 'route("musik")' in content:
        content = content.replace(old_nav_desktop, new_nav)
        with open(f, "w") as fh:
            fh.write(content)
        print("Fixed: " + f)
    else:
        # Check for double-quote variant
        old_nav_dq = old_nav_desktop.replace("{{ route('", '{{ route("').replace("') }}", '") }}')
        new_nav_dq = new_nav.replace("{{ route('", '{{ route("').replace("') }}", '") }}')
        if 'route("musik")' in content:
            content = content.replace(old_nav_dq, new_nav_dq)
            with open(f, "w") as fh:
                fh.write(content)
            print("Fixed (dq): " + f)
        else:
            print("No change: " + f)

print("done")
