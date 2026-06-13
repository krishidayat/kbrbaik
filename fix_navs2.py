files = {
    # Pattern 1: Beranda, Project, Galeri, Musik, Radio (agenda views)
    "/var/www/radio/resources/views/kbrbaik-agenda.blade.php": (
        """<a href="{{ route('home') }}" class="hover:text-sky-200 transition">Beranda</a>
                <a href="{{ route('home') }}#projects" class="hover:text-sky-200 transition">Project</a>
                <a href="{{ route('galeri') }}" class="hover:text-sky-200 transition">Galeri</a>
                <a href="{{ route('musik') }}" class="hover:text-sky-200 transition">Musik</a>
                <a href="{{ route('radio') }}" class="hover:text-sky-200 transition">Radio</a>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('galeri') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>
            <a href="{{ route('musik') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Musik</a>
            <a href="{{ route('radio') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>""",
        """<a href="{{ route('home') }}" class="hover:text-sky-200 transition">Beranda</a>
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
            <a href="{{ route('services') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Layanan</a>"""
    ),
    # Pattern 2: Beranda(route beranda), Galeri, Musik, Agenda, Radio (kbrbaik.blade.php)
    "/var/www/radio/resources/views/kbrbaik.blade.php": (
        """<a href="{{ route('beranda') }}" class="hover:text-sky-200 transition">Beranda</a>
                <a href="{{ route('galeri') }}" class="hover:text-sky-200 transition">Galeri</a>
                <a href="{{ route('musik') }}" class="hover:text-sky-200 transition">Musik</a>
                <a href="{{ route('agenda') }}" class="hover:text-sky-200 transition">Agenda</a>
                <a href="{{ route('radio') }}" class="hover:text-sky-200 transition">Radio</a>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route('beranda') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('galeri') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>
            <a href="{{ route('musik') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Musik</a>
            <a href="{{ route('agenda') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>
            <a href="{{ route('radio') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>""",
        """<a href="{{ route('home') }}" class="hover:text-sky-200 transition">Beranda</a>
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
            <a href="{{ route('services') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Layanan</a>"""
    ),
    # Pattern 3: Beranda(route home), Galeri, Musik, Agenda, Radio (blog + post)
    "/var/www/radio/resources/views/kbrbaik-blog.blade.php": (
        """<a href="{{ route('home') }}" class="hover:text-sky-200 transition">Beranda</a>
                <a href="{{ route('galeri') }}" class="hover:text-sky-200 transition">Galeri</a>
                <a href="{{ route('musik') }}" class="hover:text-sky-200 transition">Musik</a>
                <a href="{{ route('agenda') }}" class="hover:text-sky-200 transition">Agenda</a>
                <a href="{{ route('radio') }}" class="hover:text-sky-200 transition">Radio</a>
            </div>
        </div>
    </nav>


        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('galeri') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>
            <a href="{{ route('musik') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Musik</a>
            <a href="{{ route('agenda') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>
            <a href="{{ route('radio') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>""",
        """<a href="{{ route('home') }}" class="hover:text-sky-200 transition">Beranda</a>
                <a href="{{ route('galeri') }}" class="hover:text-sky-200 transition">Galeri</a>
                <a href="{{ route('agenda') }}" class="hover:text-sky-200 transition">Agenda</a>
                <a href="{{ route('komunitas') }}" class="hover:text-sky-200 transition">Komunitas</a>
                <a href="{{ route('services') }}" class="hover:text-sky-200 transition">Layanan</a>
            </div>
        </div>
    </nav>


        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('galeri') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>
            <a href="{{ route('agenda') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>
            <a href="{{ route('komunitas') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>
            <a href="{{ route('services') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Layanan</a>"""
    ),
    "/var/www/radio/resources/views/kbrbaik-post.blade.php": (
        """<a href="{{ route('home') }}" class="hover:text-sky-200 transition">Beranda</a>
                <a href="{{ route('galeri') }}" class="hover:text-sky-200 transition">Galeri</a>
                <a href="{{ route('musik') }}" class="hover:text-sky-200 transition">Musik</a>
                <a href="{{ route('agenda') }}" class="hover:text-sky-200 transition">Agenda</a>
                <a href="{{ route('radio') }}" class="hover:text-sky-200 transition">Radio</a>
            </div>
        </div>
    </nav>


        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('galeri') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>
            <a href="{{ route('musik') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Musik</a>
            <a href="{{ route('agenda') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>
            <a href="{{ route('radio') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>""",
        """<a href="{{ route('home') }}" class="hover:text-sky-200 transition">Beranda</a>
                <a href="{{ route('galeri') }}" class="hover:text-sky-200 transition">Galeri</a>
                <a href="{{ route('agenda') }}" class="hover:text-sky-200 transition">Agenda</a>
                <a href="{{ route('komunitas') }}" class="hover:text-sky-200 transition">Komunitas</a>
                <a href="{{ route('services') }}" class="hover:text-sky-200 transition">Layanan</a>
            </div>
        </div>
    </nav>


        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('galeri') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>
            <a href="{{ route('agenda') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>
            <a href="{{ route('komunitas') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>
            <a href="{{ route('services') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Layanan</a>"""
    ),
}

for fp, (old, new) in files.items():
    with open(fp, "r") as f:
        content = f.read()
    if old in content:
        content = content.replace(old, new)
        with open(fp, "w") as f:
            f.write(content)
        print("Fixed: " + fp)
    else:
        print("NOT MATCHED: " + fp)
        # Show what's different
        import re
        m = re.search(r'hidden md:flex.*?hidden md:hidden', content, re.DOTALL)
        if m:
            print("  Found nav block excerpt: " + repr(m.group()[:200]))

print("done")
