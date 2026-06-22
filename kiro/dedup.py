import sqlite3
db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)
conn.execute("DELETE FROM schedules WHERE name='tembang-malam' AND end_time='21:00:00'")
conn.commit()
rows = conn.execute("SELECT name,start_time,end_time FROM schedules WHERE is_active=1 ORDER BY start_time").fetchall()
for r in rows: print(r)
conn.close()
