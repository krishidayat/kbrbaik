import sqlite3

db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)

# Cek playlist yang match dengan show names
playlists = conn.execute("SELECT id,name FROM playlists WHERE name IN ('nyanyi-sunyi','tembang-malam','nada-doa','cerita-senja','kicau-pagi','hari-baru','sapa-siang','karya-hari-ini')").fetchall()
print("Playlists:", playlists)

# Cek shows
shows = conn.execute("SELECT id,name FROM shows").fetchall()
print("Shows:", shows)

# Cek schedules
scheds = conn.execute("SELECT id,name,day_of_week,start_time,end_time,playlist_id FROM schedules WHERE is_active=1").fetchall()
print("Schedules:", scheds)

# Cek station_id yang ada
station = conn.execute("SELECT id FROM stations LIMIT 1").fetchone()
print("Station:", station)

conn.close()
