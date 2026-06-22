import sqlite3
from datetime import datetime

db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)
now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

pl_id = 51  # nyanyi-sunyi
station_id = 1

# Ambil semua track aktif station 1
tracks = conn.execute("""
    SELECT id, title, artist, file_path, duration
    FROM audio_tracks WHERE station_id=? AND is_active=1 ORDER BY title
""", (station_id,)).fetchall()

# Clear existing
conn.execute("DELETE FROM playlist_items WHERE playlist_id=?", (pl_id,))

for i, (t_id, title, artist, file_path, duration) in enumerate(tracks):
    conn.execute("""INSERT INTO playlist_items
        (playlist_id,station_id,audio_track_id,title,artist,item_type,audio_file,duration,sort_order,is_active,created_at,updated_at)
        VALUES (?,?,?,?,?,'audio',?,?,?,1,?,?)""",
        (pl_id, station_id, t_id, title, artist or '', file_path, duration, i, now, now))
    print(f'  {i+1}. {title}')

conn.commit()
conn.close()
print(f'Done: {len(tracks)} tracks added to playlist {pl_id} (nyanyi-sunyi)')
