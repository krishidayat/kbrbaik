import re

path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'
raw = open(path, 'rb').read()

# File ditulis Windows cp1252, decode dulu
content = raw.decode('cp1252', errors='replace')

# Sekarang replace semua karakter non-ASCII di dalam atribut HTML dan teks
# dengan teks yang aman - pakai regex untuk temukan span.sb-icon dan row-icon
# Ganti semua karakter replacement dengan string kosong atau simbol ASCII
import unicodedata

def strip_non_ascii(s):
    result = []
    i = 0
    while i < len(s):
        c = s[i]
        if ord(c) < 128:
            result.append(c)
        else:
            # Skip non-ASCII
            result.append('')
        i += 1
    return ''.join(result)

# Ganti blok sb-icon dan row-icon content
# Juga bersihkan tombol-tombol
lines = content.split('\n')
clean_lines = []
for line in lines:
    # Bersihkan karakter non-ASCII dari dalam tag HTML
    if any(ord(c) > 127 for c in line):
        new_line = ''
        for c in line:
            if ord(c) < 128:
                new_line += c
            # skip emoji/non-ascii
        line = new_line
    clean_lines.append(line)

result = '\n'.join(clean_lines)

# Fix beberapa label yang jadi kosong karena emoji dihapus
result = result.replace('<span class="sb-icon"></span>Dashboard', '<span class="sb-icon">&#8962;</span>Dashboard')
result = result.replace('<span class="sb-icon"></span>Tracks', '<span class="sb-icon">&#9834;</span>Tracks')
result = result.replace('<span class="sb-icon"></span>Playlists', '<span class="sb-icon">&#9776;</span>Playlists')
result = result.replace('<span class="sb-icon"></span>Smart Blk', '<span class="sb-icon">&#9733;</span>Smart Blk')
result = result.replace('<span class="sb-icon"></span>Shows', '<span class="sb-icon">&#9654;</span>Shows')
result = result.replace('<span class="sb-icon"></span>Podcasts', '<span class="sb-icon">&#9685;</span>Podcasts')
result = result.replace('<span class="sb-icon"></span>Calendar', '<span class="sb-icon">&#9776;</span>Calendar')
result = result.replace('<span class="sb-icon"></span>Rundown', '<span class="sb-icon">&#9654;</span>Rundown')
result = result.replace('<span class="sb-icon"></span>Webstream', '<span class="sb-icon">&#9474;</span>Webstream')
result = result.replace('<span class="sb-icon"></span>Relay', '<span class="sb-icon">&#8635;</span>Relay')
result = result.replace('<span class="sb-icon"></span>Upload', '<span class="sb-icon">&#8679;</span>Upload')
result = result.replace('<span class="sb-icon"></span>Admin', '<span class="sb-icon">&#9881;</span>Admin')

# Fix toolbar buttons
result = result.replace('> Upload</button>', '&#8679; Upload</button>')
result = result.replace('>R Refresh</button>', '&#8634; Refresh</button>')
result = result.replace('> Hapus</button>', '&#128465; Hapus</button>')
result = result.replace('Cari judul, artis, album...', 'Cari judul, artis, album...')

# Fix row icons
result = result.replace('<div class="row-icon"></div>', '<div class="row-icon">&#9834;</div>')
result = result.replace("'<div class=\"row-icon\"></div>'", "'<div class=\"row-icon\">&#9834;</div>'")
result = result.replace('>&#9834;</div>', '>&#9834;</div>')

# Fix dalam javascript template literals
result = re.sub(r'<div class="row-icon">[^<]*</div>', '<div class="row-icon">&#9834;</div>', result)
result = re.sub(r'<span class="row-icon">[^<]*</span>', '<span class="row-icon">&#9654;</span>', result)

open(path, 'w', encoding='utf-8').write(result)
print('Done - file rewritten as clean UTF-8')
print('File size:', len(result), 'chars')
