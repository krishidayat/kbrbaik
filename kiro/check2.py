import sqlite3
from datetime import datetime

db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)
now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

# Map: playlist_id -> show_id (berdasarkan nama yang sama)
mapping = conn.execute("""
    SELECT s.id as show_id, s.name, p.id as pl_id
    FROM shows s JOIN playlists p ON s.name = p.name
    WHERE s.station_id=1
""").fetchall()
print("Show-Playlist mapping:", mapping)

# Cek show_tracks
st = conn.execute("SELECT show_id, count(*) FROM show_tracks GROUP BY show_id").fetchall()
print("Show tracks count:", st)

# Cek playlist_items
pi = conn.execute("SELECT playlist_id, count(*) FROM playlist_items GROUP BY playlist_id").fetchall()
print("Playlist items count:", pi)
conn.close()
