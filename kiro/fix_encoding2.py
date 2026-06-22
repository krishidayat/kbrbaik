path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'

# Baca raw bytes, decode latin-1 (tidak ada byte yang invalid)
raw = open(path, 'rb').read()
content = raw.decode('latin-1')

# Map: karakter latin-1 hasil miskode dari UTF-8 emoji -> teks pengganti
# Deteksi dengan melihat output grep tadi
replacements = [
    # sidebar icons
    ('\xc3\xb0\xc5\xb8\xa0', ''),          # 🏠 -> kosong (hapus icon)
    ('\xc3\xb0\xc5\xb8\x8e\xc2\xb5', ''),  # 🎵
    ('\xc3\xb0\xc5\xb8\x93\x8b', ''),      # 📋
    ('\xc3\xa2\xc5\xa1\xc2\xa1', ''),      # ⚡
    ('\xc3\xb0\xc5\xb8\x93\xc2\xba', ''), # 📺
    ('\xc3\xb0\xc5\xb8\x8e\xe2\x80\x99', ''), # 🎙
    ('\xc3\xb0\xc5\xb8\x93\xe2\x80\xa6', ''), # 📅
    ('\xc3\xa2\xe2\x80\x96\xc2\xb6', '>'), # ▶
    ('\xc3\xb0\xc5\xb8\x93\xc2\xa1', ''), # 📡
    ('\xc3\xb0\xc5\xb8\x94', ''),          # 🔁
    ('\xc3\xa2\xe2\x81\xa0\xe2\x80\xa0', '^'), # ⬆
    ('\xc3\xa2\xc5\xa1\x99', '*'),          # ⚙
    ('\xc3\xb0\xc5\xb8\x97\x91', '[del]'), # 🗑
    ('\xc3\xa2\xe2\x86\xba', 'R'),          # ↺
    ('\xc3\xb0\xc5\xb8\x94\x8d', 'Q'),     # 🔍
    ('\xc3\xb0\xc5\xb8\x94\x8a', '>>'),    # 🔊
    ('\xc3\xa2\x99\xab', '~'),              # ♫
    ('\xc3\xa2\x96\xbe', 'v'),              # ▾
]

for old, new in replacements:
    content = content.replace(old, new)

# Tulis sebagai UTF-8
open(path, 'w', encoding='utf-8').write(content)

# Verifikasi tidak ada karakter aneh
check = open(path, encoding='utf-8').read()
weird = [c for c in check if ord(c) > 127 and ord(c) < 256 and c not in 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ']
print(f'Done. Remaining non-ASCII chars: {len(set(weird))}')
if weird:
    print('Sample:', repr(set(list(weird)[:10])))
