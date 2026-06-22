import sqlite3
from datetime import datetime

db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)
now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
station_id = 11

# Cek shows
shows = conn.execute("SELECT id, name, station_id, default_playlist_id FROM shows").fetchall()
print("Shows:", shows)

# Cek show_tracks
st = conn.execute("SELECT show_id, audio_track_id, sort_order FROM show_tracks").fetchall()
print("Show tracks:", st)

# Force sync tembang-malam (show_id=4) ke playlist 57
pl_id = 57
tracks = conn.execute("""
    SELECT at.id, at.title, at.artist, at.file_path, at.duration, st.sort_order
    FROM show_tracks st JOIN audio_tracks at ON st.audio_track_id = at.id
    WHERE st.show_id=4 ORDER BY st.sort_order
""").fetchall()
print(f"Tracks untuk show_id=4: {len(tracks)}")

conn.execute("DELETE FROM playlist_items WHERE playlist_id=?", (pl_id,))
for t_id, title, artist, file_path, duration, sort_order in tracks:
    conn.execute("""INSERT INTO playlist_items
        (playlist_id, station_id, audio_track_id, title, artist, item_type, audio_file, duration, sort_order, is_active, created_at, updated_at)
        VALUES (?,?,?,?,?,'audio',?,?,?,1,?,?)""",
        (pl_id, station_id, t_id, title, artist or '', file_path, duration, sort_order, now, now))
    print(f'  Added: {title}')

# Update station_id shows
conn.execute("UPDATE shows SET station_id=? WHERE station_id != ?", (station_id, station_id))

conn.commit()
conn.close()
print('Done')
