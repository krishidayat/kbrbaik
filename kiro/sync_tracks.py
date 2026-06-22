import sqlite3
from datetime import datetime

db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)
now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
station_id = 11

# Map show name -> playlist id
show_playlist = {
    'nyanyi-sunyi': 51,
    'cerita-senja': 56,
    'tembang-malam': 57,
    'nada-doa': 58,
}
for show_name, pl_id in show_playlist.items():
    conn.execute("UPDATE shows SET default_playlist_id=? WHERE name=? AND station_id=?",
                 (pl_id, show_name, station_id))
    print(f'Linked show {show_name} -> playlist {pl_id}')

# Sync show_tracks ke playlist_items untuk setiap show
shows = conn.execute("SELECT id, name, default_playlist_id FROM shows WHERE station_id=?", (station_id,)).fetchall()
for show_id, show_name, pl_id in shows:
    if not pl_id:
        continue
    # Ambil tracks dari show_tracks
    tracks = conn.execute("""
        SELECT at.id, at.title, at.artist, at.file_path, at.duration, st.sort_order
        FROM show_tracks st JOIN audio_tracks at ON st.audio_track_id = at.id
        WHERE st.show_id=? ORDER BY st.sort_order
    """, (show_id,)).fetchall()

    if not tracks:
        continue

    # Clear existing playlist items untuk playlist ini
    conn.execute("DELETE FROM playlist_items WHERE playlist_id=? AND station_id=?", (pl_id, station_id))

    for t_id, title, artist, file_path, duration, sort_order in tracks:
        conn.execute("""INSERT INTO playlist_items
            (playlist_id, station_id, audio_track_id, title, artist, item_type, audio_file, duration, sort_order, is_active, created_at, updated_at)
            VALUES (?,?,?,?,?,'audio',?,?,?,1,?,?)""",
            (pl_id, station_id, t_id, title, artist or '', file_path, duration, sort_order, now, now))

    print(f'Synced {len(tracks)} tracks: show {show_name} -> playlist {pl_id}')

conn.commit()
conn.close()
print('Done')
