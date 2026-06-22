import sqlite3

db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)

rows = conn.execute('SELECT id, title FROM audio_tracks').fetchall()
for id_, title in rows:
    # Coba decode sebagai latin-1 lalu re-encode utf-8
    try:
        fixed = title.encode('latin-1').decode('utf-8')
        if fixed != title:
            print(f'ID {id_}: {repr(title)} -> {repr(fixed)}')
            conn.execute('UPDATE audio_tracks SET title=? WHERE id=?', (fixed, id_))
    except Exception as e:
        print(f'ID {id_}: skip ({e})')

conn.commit()
conn.close()
print('Done')
