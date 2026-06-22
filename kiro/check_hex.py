import sqlite3

db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)
rows = conn.execute('SELECT id, title FROM audio_tracks WHERE id IN (3,4,6)').fetchall()
for id_, title in rows:
    b = title.encode('utf-8')
    # Cari posisi byte aneh
    for i, byte in enumerate(b):
        if byte > 127:
            print(f'ID {id_} pos {i}: {b[max(0,i-5):i+5].hex()} => char context: {repr(title[max(0,i-3):i+3])}')
            break
    print(f'ID {id_} title: {repr(title)}')
conn.close()
