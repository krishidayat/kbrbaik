with open('/var/www/radio/resources/views/layouts/suara.blade.php', 'r') as f:
    content = f.read()

old = '''                    <a href="{{ route('home') }}" class="hover:text-primary-200 transition">Beranda</a>
                    <a href="{{ route('agenda') }}" class="hover:text-primary-200 transition">Agenda</a>
                    <a href="{{ route('bidang') }}" class="hover:text-primary-200 transition">Bidang</a>
                    <a href="{{ route('pgis') }}" class="hover:text-primary-200 transition">PGIS</a>
                    <a href="{{ route('pouk') }}" class="hover:text-primary-200 transition">POUK</a>
                    <a href="{{ route('gereja') }}" class="hover:text-primary-200 transition">Gereja</a>
                    <a href="{{ route('media') }}" class="hover:text-primary-200 transition">Media</a>'''

new = '''                    <a href="{{ route('home') }}" class="hover:text-primary-200 transition">Beranda</a>
                    <a href="{{ route('agenda') }}" class="hover:text-primary-200 transition">Agenda</a>
                    <div class="relative group">
                        <button class="hover:text-primary-200 transition flex items-center gap-1 cursor-pointer">
                            Struktur
                            <svg class="w-3 h-3 mt-0.5 group-hover:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="absolute top-full left-0 mt-1 bg-white text-gray-900 rounded-lg shadow-lg py-2 min-w-[160px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ route('bidang') }}" class="block px-4 py-2 text-sm hover:bg-gray-100 transition">Bidang</a>
                            <a href="{{ route('pgis') }}" class="block px-4 py-2 text-sm hover:bg-gray-100 transition">PGIS</a>
                            <a href="{{ route('pouk') }}" class="block px-4 py-2 text-sm hover:bg-gray-100 transition">POUK</a>
                            <a href="{{ route('gereja') }}" class="block px-4 py-2 text-sm hover:bg-gray-100 transition">Gereja</a>
                        </div>
                    </div>
                    <a href="{{ route('media') }}" class="hover:text-primary-200 transition">Media</a>'''

content = content.replace(old, new)

with open('/var/www/radio/resources/views/layouts/suara.blade.php', 'w') as f:
    f.write(content)

print('Nav updated OK')
