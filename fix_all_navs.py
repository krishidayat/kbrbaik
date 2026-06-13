import re

files = [
    "/var/www/radio/resources/views/kbrbaik.blade.php",
    "/var/www/radio/resources/views/beranda.blade.php",
    "/var/www/radio/resources/views/kbrbaik-agenda.blade.php",
    "/var/www/radio/resources/views/kbrbaik-agenda-show.blade.php",
    "/var/www/radio/resources/views/kbrbaik-blog.blade.php",
    "/var/www/radio/resources/views/kbrbaik-post.blade.php",
    "/var/www/radio/resources/views/kbrbaik-komunitas.blade.php",
    "/var/www/radio/resources/views/kbrbaik-komunitas-show.blade.php",
    "/var/www/radio/resources/views/kbrbaik-studio-show.blade.php",
]

nav_items = [
    ('home', 'Beranda'),
    ('agenda', 'Agenda'),
    ('komunitas', 'Komunitas'),
    ('services', 'Layanan'),
    ('pelatihan', 'Pelatihan'),
    ('galeri', 'Galeri'),
    ('radio', 'Radio'),
]

def make_desktop(items, quote):
    lines = []
    for route_name, label in items:
        active = 'hover:text-sky-200 transition'
        if quote == "single":
            lines.append(f'                <a href="{{{{ route(\'{route_name}\') }}}}" class="{active}">{label}</a>')
        else:
            lines.append(f'                <a href="{{{{ route("{route_name}") }}}}" class="{active}">{label}</a>')
    return '\n'.join(lines)

def make_mobile_single(items):
    lines = []
    for route_name, label in items:
        lines.append(f'            <a href="{{{{ route(\'{route_name}\') }}}}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">{label}</a>')
    return '\n'.join(lines)

def make_mobile_double(items):
    lines = []
    for route_name, label in items:
        lines.append(f'            <a href="{{{{ route("{route_name}") }}}}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">{label}</a>')
    return '\n'.join(lines)

desktop_single = make_desktop(nav_items, "single")
desktop_double = make_desktop(nav_items, "double")
mobile_single = make_mobile_single(nav_items)
mobile_double = make_mobile_double(nav_items)

replacements = {
    "kbrbaik.blade.php": {
        "quote": "single",
        "has_mobile": True,
        "komunitas_active": False,
    },
    "beranda.blade.php": {
        "quote": "single",
        "has_mobile": True,
        "komunitas_active": False,
    },
    "kbrbaik-agenda.blade.php": {
        "quote": "single",
        "has_mobile": True,
        "komunitas_active": False,
    },
    "kbrbaik-agenda-show.blade.php": {
        "quote": "single",
        "has_mobile": True,
        "komunitas_active": False,
    },
    "kbrbaik-blog.blade.php": {
        "quote": "single",
        "has_mobile": False,
        "komunitas_active": False,
    },
    "kbrbaik-post.blade.php": {
        "quote": "single",
        "has_mobile": False,
        "komunitas_active": False,
    },
    "kbrbaik-komunitas.blade.php": {
        "quote": "double",
        "has_mobile": True,
        "komunitas_active": True,
    },
    "kbrbaik-komunitas-show.blade.php": {
        "quote": "double",
        "has_mobile": True,
        "komunitas_active": False,
    },
    "kbrbaik-studio-show.blade.php": {
        "quote": "single",
        "has_mobile": True,
        "komunitas_active": False,
    },
}

for fp in files:
    fname = fp.split("/")[-1]
    cfg = replacements[fname]
    quote = cfg["quote"]
    has_mobile = cfg["has_mobile"]
    komunitas_active = cfg["komunitas_active"]

    desktop = desktop_double if quote == "double" else desktop_single
    mobile = mobile_double if quote == "double" else mobile_single

    if komunitas_active:
        desktop = desktop.replace(
            'hover:text-sky-200 transition">Komunitas</a>',
            'text-sky-200 font-semibold transition">Komunitas</a>'
        )

    with open(fp, "r") as f:
        content = f.read()

    # Replace desktop nav
    desktop_pattern_start = '<div class="hidden md:flex space-x-6 text-sm">'
    desktop_pattern_end = '</div>'

    # Find desktop nav section
    start_idx = content.find(desktop_pattern_start)
    if start_idx == -1:
        print(f"ERROR: desktop nav start not found in {fname}")
        continue

    # Find the first </div> after desktop nav start (the one closing the nav div)
    after_start = start_idx + len(desktop_pattern_start)
    end_idx = content.find(desktop_pattern_end, after_start)
    if end_idx == -1:
        print(f"ERROR: desktop nav end not found in {fname}")
        continue

    # The content between is the old nav - replace everything including the div
    old_desktop_block = content[start_idx:end_idx + len(desktop_pattern_end)]
    new_desktop_block = f'{desktop_pattern_start}\n{desktop}\n            {desktop_pattern_end}'
    content = content.replace(old_desktop_block, new_desktop_block, 1)

    if has_mobile:
        mobile_pattern_start = '<div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">'
        mobile_pattern_end = '</div>'

        start_idx = content.find(mobile_pattern_start)
        if start_idx == -1:
            print(f"WARNING: mobile nav start not found in {fname}")
        else:
            after_start = start_idx + len(mobile_pattern_start)
            end_idx = content.find(mobile_pattern_end, after_start)
            if end_idx == -1:
                print(f"WARNING: mobile nav end not found in {fname}")
            else:
                old_mobile_block = content[start_idx:end_idx + len(mobile_pattern_end)]
                new_mobile_block = f'{mobile_pattern_start}\n{mobile}\n        {mobile_pattern_end}'
                content = content.replace(old_mobile_block, new_mobile_block, 1)

    # Clean up duplicate Galeri if it appears twice in mobile (from previous bad fix)
    # This handles the agenda files that had duplicate Galeri in mobile
    if has_mobile:
        # Check for duplicate Galeri in mobile section (occurring twice)
        galeri_count = content.count('Galeri</a>')
        if galeri_count > 2:  # Once in desktop, duplicate in mobile
            # Remove the duplicate Galeri in mobile - find second occurrence in mobile section
            pass  # The replacement above should fix it cleanly

    # Remove old Project links if present
    content = content.replace(
        '<a href="{{ route(\'home\') }}#projects" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Project</a>\n',
        ''
    )
    content = content.replace(
        '<a href="{{ route("home") }}#projects" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Project</a>\n',
        ''
    )
    # Also handle inline (non-trailing newline)
    content = content.replace(
        '<a href="{{ route(\'home\') }}#projects" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Project</a>',
        ''
    )
    content = content.replace(
        '<a href="{{ route("home") }}#projects" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Project</a>',
        ''
    )

    # Remove duplicate Beranda in blog/post (they had two Beranda links)
    if 'kbrbaik-blog' in fname or 'kbrbaik-post' in fname:
        lines = content.split('\n')
        new_lines = []
        beranda_count = 0
        for line in lines:
            if 'Beranda</a>' in line:
                beranda_count += 1
                if beranda_count > 1:
                    continue  # Skip duplicate Beranda
            new_lines.append(line)
        content = '\n'.join(new_lines)

    with open(fp, "w") as f:
        f.write(content)
    print(f"Fixed: {fname}")

print("done")
