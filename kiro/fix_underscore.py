import sqlite3, re

db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)

rows = conn.execute('SELECT id, title FROM audio_tracks').fetchall()
for id_, title in rows:
    # Ganti underscore yg dipakai sebagai separator jadi spasi
    fixed = title.replace('_', ' ')
    if fixed != title:
        print(f'ID {id_}: {repr(title)} -> {repr(fixed)}')
        conn.execute('UPDATE audio_tracks SET title=? WHERE id=?', (fixed, id_))

conn.commit()
conn.close()
print('Done')
