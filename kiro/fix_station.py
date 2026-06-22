import sqlite3
from datetime import datetime

db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)
now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
SID = 1  # KBRBaik

# Fix schedules ke station 1
conn.execute("UPDATE schedules SET station_id=? WHERE station_id=11", (SID,))
print('Schedules fixed to station 1')

# Fix shows ke station 1 (kecuali yang sudah di station 1)
conn.execute("UPDATE shows SET station_id=? WHERE station_id != ?", (SID, SID))
print('Shows fixed to station 1')

# Fix playlist_items ke station 1
conn.execute("UPDATE playlist_items SET station_id=? WHERE station_id=11", (SID,))
print('Playlist items fixed to station 1')

# Verifikasi schedules
rows = conn.execute("SELECT name,start_time,end_time,station_id FROM schedules WHERE is_active=1 ORDER BY start_time").fetchall()
print('\nSchedules:')
for r in rows:
    print(f'  {r[1]}-{r[2]} {r[0]} (station {r[3]})')

conn.commit()
conn.close()
print('Done')
