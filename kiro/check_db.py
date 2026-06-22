import sqlite3

db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)

# Cek sample
rows = conn.execute('SELECT id, title, artist FROM audio_tracks LIMIT 10').fetchall()
for r in rows:
    print(r)
conn.close()
