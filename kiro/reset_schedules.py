import sqlite3
from datetime import datetime

db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)
now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
station_id = 11

# Hapus semua schedule lama untuk station ini
conn.execute("DELETE FROM schedules WHERE station_id=?", (station_id,))

schedules = [
    ('nyanyi-sunyi',   51, '00:00', '05:00', '#6644aa'),
    ('kicau-pagi',     52, '05:00', '08:00', '#ff8c00'),
    ('hari-baru',      53, '08:00', '12:00', '#0088cc'),
    ('sapa-siang',     54, '12:00', '15:00', '#00aa66'),
    ('karya-hari-ini', 55, '15:00', '18:00', '#cc6600'),
    ('cerita-senja',   56, '18:00', '20:00', '#cc3366'),
    ('tembang-malam',  57, '20:00', '23:00', '#3344cc'),
    ('nada-doa',       58, '23:00', '24:00', '#445566'),
]

for name, pl_id, start, end, color in schedules:
    conn.execute("""INSERT INTO schedules
        (station_id, name, day_of_week, start_time, end_time, playlist_id, show_type, stream_type,
         is_active, is_recurring, color, priority, lifecycle_status, created_at, updated_at)
        VALUES (?,?,'daily',?,?,?,'playlist','playlist',1,1,?,0,'planned',?,?)""",
        (station_id, name, start, end, pl_id, color, now, now))
    print(f'{start}-{end} {name}')

conn.commit()
conn.close()
print('Done')
