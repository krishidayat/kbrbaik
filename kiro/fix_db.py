import sqlite3, os

db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)
conn.execute('''CREATE TABLE IF NOT EXISTS smart_blocks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    station_id INTEGER NOT NULL,
    name VARCHAR NOT NULL,
    description TEXT,
    limit_type VARCHAR DEFAULT 'tracks',
    limit_value INTEGER DEFAULT 10,
    is_active BOOLEAN DEFAULT 1,
    created_at DATETIME,
    updated_at DATETIME
)''')
conn.commit()
conn.close()

# Verifikasi
conn = sqlite3.connect(db)
tables = [r[0] for r in conn.execute("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name")]
conn.close()
print('Tables with smart:', [t for t in tables if 'smart' in t])
print('Done')
