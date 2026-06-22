import sqlite3
from datetime import datetime

db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)
now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
station_id = 11

# Hapus schedule lama yang tidak relevan
conn.execute("DELETE FROM schedules WHERE name != 'tembang-malam'")

# Jadwal harian — nama, playlist_id, start, end
# Berdasarkan nama: kicau-pagi(subuh), hari-baru(pagi), sapa-siang(siang),
# karya-hari-ini(sore), cerita-senja(petang), tembang-malam(malam), nada-doa(larut), nyanyi-sunyi(dini hari)
schedules = [
    ('nyanyi-sunyi',   51, '00:00', '05:00'),  # dini hari — JAM INI (01:38 WIB)
    ('kicau-pagi',     52, '05:00', '08:00'),
    ('hari-baru',      53, '08:00', '12:00'),
    ('sapa-siang',     54, '12:00', '15:00'),
    ('karya-hari-ini', 55, '15:00', '18:00'),
    ('cerita-senja',   56, '18:00', '20:00'),
    ('tembang-malam',  57, '20:00', '23:00'),
    ('nada-doa',       58, '23:00', '24:00'),
]

for name, pl_id, start, end in schedules:
    # Cek sudah ada belum
    existing = conn.execute("SELECT id FROM schedules WHERE name=? AND station_id=?", (name, station_id)).fetchone()
    if existing:
        conn.execute("""UPDATE schedules SET playlist_id=?, start_time=?, end_time=?, day_of_week='daily',
            is_recurring=1, is_active=1, show_type='playlist', stream_type='playlist', updated_at=?
            WHERE id=?""", (pl_id, start, end, now, existing[0]))
        print(f'Updated: {name} {start}-{end}')
    else:
        conn.execute("""INSERT INTO schedules
            (station_id, name, day_of_week, start_time, end_time, playlist_id, show_type, stream_type,
             is_active, is_recurring, color, priority, lifecycle_status, created_at, updated_at)
            VALUES (?,?,'daily',?,?,?,'playlist','playlist',1,1,'#3B82F6',0,'planned',?,?)""",
            (station_id, name, start, end, pl_id, now, now))
        print(f'Created: {name} {start}-{end}')

conn.commit()

# Verifikasi
rows = conn.execute("SELECT name, start_time, end_time FROM schedules WHERE is_active=1 ORDER BY start_time").fetchall()
print('\nSchedules aktif:')
for r in rows:
    print(f'  {r[1]}-{r[2]} {r[0]}')

conn.close()
