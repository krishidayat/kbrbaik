# azuracast-radio

Kelola radio streaming AzuraCast — cek status station, manage playlist, upload lagu, restart station, troubleshoot.

## Stations

| ID | Name | Shortcode | Port |
|----|------|-----------|------|
| 1 | Radio Kabar Baik | `radio_kabar_baik` | 8000 |
| 2 | SuaraPGIW / Podcast PGIW | `suarapgiw` | 8010 |

## Docker Context

```bash
# Semua command dijalankan di container azuracast
docker exec azuracast <command>
```

## 1. Cek Status Station

### Now Playing

```bash
# Via API (langsung dari host)
curl -s https://radio.kbrbaik.live/api/nowplaying/1 | python3 -m json.tool
curl -s https://radio.kbrbaik.live/api/nowplaying/2 | python3 -m json.tool

# Pingkat: cuma ambil judul lagu
curl -s https://radio.kbrbaik.live/api/nowplaying/1 | python3 -c "import sys,json; d=json.load(sys.stdin); print(d.get('now_playing',{}).get('song',{}).get('title','N/A'))"
```

### Cek Process Status

```bash
# Supervisor status semua station
docker exec azuracast supervisorctl status | grep station

# Output example:
# station_1:station_1_backend   RUNNING   pid 123, uptime 5:23:45
# station_1:station_1_frontend  RUNNING   pid 124, uptime 5:23:45
# station_2:station_2_backend   RUNNING   pid 125, uptime 5:23:45
# station_2:station_2_frontend  RUNNING   pid 126, uptime 5:23:45
```

### Cek Queue

```bash
# Hitung queue
docker exec azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast \
  -e "SELECT station_id, COUNT(*) FROM station_queue GROUP BY station_id;"

# Lihat isi queue (5 lagu berikutnya)
docker exec azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast \
  -e "SELECT s.id, s.artist, s.title, s.duration FROM station_queue s WHERE s.station_id = 1 ORDER BY s.timestamp_cued LIMIT 5;"
```

## 2. Manajemen Playlist

### Daftar Playlist

```bash
docker exec azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast \
  -e "SELECT id, station_id, name, type, is_enabled FROM station_playlists WHERE station_id = [1|2];"
```

### Lihat Lagu di Playlist

```bash
docker exec azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast \
  -e "SELECT sm.artist, sm.title, sm.length FROM station_playlist_media spm JOIN station_media sm ON spm.media_id = sm.id WHERE spm.playlist_id = [playlist_id] ORDER BY spm.weight DESC;"
```

### Tambah Lagu ke Playlist

```bash
# 1. Cari media_id lagu
docker exec azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast \
  -e "SELECT id, artist, title FROM station_media WHERE artist LIKE '%keyword%' OR title LIKE '%keyword%' AND storage_location_id = [storage_id];"

# storage_id: radio_kabar_baik=3, suarapgiw=6

# 2. Tambah ke playlist (ganti playlist_id, media_id, weight)
docker exec -i azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast << SQL
INSERT INTO station_playlist_media (playlist_id, media_id, weight)
VALUES ([playlist_id], [media_id], 1);
SQL

# 3. Sync queue
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:sync:run
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:station-queues:clear
```

### Hapus Lagu dari Playlist

```bash
docker exec -i azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast << SQL
DELETE FROM station_playlist_media WHERE playlist_id = [playlist_id] AND media_id = [media_id];
SQL
```

### Buat Playlist Baru

Via Dashboard: Stations → Pilih station → Playlists → Add Playlist

Atau via SQL:

```bash
docker exec -i azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast << SQL
INSERT INTO station_playlists (station_id, name, type, is_enabled, playback_order, play_per_songs, play_per_minutes, play_per_hour_minute, weight)
VALUES ([station_id], 'Nama Playlist', 'default', 1, 'shuffle', 0, 0, 0, 1);
SQL
```

## 3. Manajemen File Media

### Daftar File di Station

```bash
docker exec azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast \
  -e "SELECT id, artist, title, album, length, path FROM station_media WHERE storage_location_id = [storage_id] ORDER BY artist LIMIT 30;"

# Hitung total file
docker exec azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast \
  -e "SELECT COUNT(*) FROM station_media WHERE storage_location_id = [storage_id];"
```

### Cari File

```bash
docker exec azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast \
  -e "SELECT id, artist, title, path FROM station_media WHERE storage_location_id = [storage_id] AND (artist LIKE '%cari%' OR title LIKE '%cari%');"
```

### Hapus File

```bash
# Via API
curl -X DELETE "https://radio.kbrbaik.live/api/station/1/file/[media_id]" \
  -H "X-API-Key: 394c90c9513d1edcb960ded28d9e142402ed5058925c5211285a351d09ab33d412d9069cd9a3b734db7818c52ad6ace07c37"
```

### Upload File

1. Via Dashboard: Stations → Pilih station → Files → Upload
2. Via SFTP: port 8102, credential dari dashboard station → SFTP Users
3. Maks 200MB per file, format: mp3/ogg/flac/aac/wav

### Reprocess Media (jika metadata tidak terbaca)

```bash
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:media:reprocess [station_id]
```

## 4. Kontrol Station

### Restart Station

```bash
# Restart semua
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:radio:restart

# Restart spesifik (recommended)
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:radio:restart 1
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:radio:restart 2
```

### Start/Stop via Supervisor

```bash
# Stop station
docker exec azuracast supervisorctl stop station_1:station_1_backend
docker exec azuracast supervisorctl stop station_1:station_1_frontend

# Start station
docker exec azuracast supervisorctl start station_1:station_1_backend
docker exec azuracast supervisorctl start station_1:station_1_frontend

# Restart station
docker exec azuracast supervisorctl restart station_2:station_2_backend
docker exec azuracast supervisorctl restart station_2:station_2_frontend
```

## 5. Cek Log

### Liquidsoap Log

```bash
# N baris terakhir
docker exec azuracast tail -30 /var/azuracast/stations/radio_kabar_baik/config/liquidsoap.log
docker exec azuracast tail -30 /var/azuracast/stations/suarapgiw/config/liquidsoap.log

# Follow log (real-time, Ctrl+C to stop)
docker exec azuracast tail -f /var/azuracast/stations/radio_kabar_baik/config/liquidsoap.log
```

### Icecast Log

```bash
docker exec azuracast tail -30 /var/azuracast/stations/radio_kabar_baik/config/icecast.log
```

### Application Log

```bash
docker exec azuracast tail -50 /var/azuracast/www_tmp/app-$(date +%F).log
```

### Nginx Error Log

```bash
docker exec azuracast tail -30 /var/azuracast/www_tmp/service_nginx.log
```

## 6. Troubleshooting

### Station Offline / Queue Kosong

```bash
# 1. Cek supervisor
docker exec azuracast supervisorctl status | grep station

# 2. Cek queue count
docker exec azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast \
  -e "SELECT COUNT(*) FROM station_queue WHERE station_id = [id];"

# 3. Restart station
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:radio:restart [id]

# 4. Jika masih kosong, force insert queue:
docker exec -i azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast << SQL
INSERT INTO station_queue (song_id, station_id, playlist_id, media_id, sent_to_autodj, timestamp_cued, duration, text, artist, title, album, is_played, is_visible)
SELECT m.song_id, [station_id], [playlist_id], m.id, 0, NOW(), m.length, CONCAT(m.artist, ' - ', m.title), m.artist, m.title, m.album, 0, 1
FROM station_media m WHERE m.storage_location_id = [storage_id];
SQL
```

### Permission Denied

```bash
docker exec azuracast chown -R 1000:1000 /var/azuracast/stations/[nama]/
```

### AutoDJ Timeout

```bash
# Restart PHP workers
docker exec azuracast supervisorctl restart php-worker php-nowplaying

# Clear & rebuild queue
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:station-queues:clear
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:sync:run
```

### 403 Too Many Streams

```bash
docker exec azuracast supervisorctl restart station_[id]:station_[id]_frontend
```

### Cek Disk Space

```bash
# Di container
docker exec azuracast df -h

# Di host
df -h
```

## 7. Info Cepat

### Storage Location IDs

| Station | Media | Recordings | Podcasts |
|---------|-------|------------|----------|
| Radio Kabar Baik (1) | 3 | 4 | 5 |
| SuaraPGIW (2) | 6 | 7 | 8 |

### DJ Source Passwords

| Station | DJ Port | Source Password |
|---------|---------|----------------|
| Radio Kabar Baik | 8005 | WPZdX3Zy |
| SuaraPGIW | 8015 | pgiw2026 |

### API Keys

| Station | API Key |
|---------|---------|
| Radio Kabar Baik | `394c90c9513d1edcb960ded28d9e142402ed5058925c5211285a351d09ab33d412d9069cd9a3b734db7818c52ad6ace07c37` |
| SuaraPGIW | `dbe29e6d3ee96cb4ea0b8655670aa2002ebde9d7c45a3a97b3573aa948ac363e75622f04c1d4a976807a4b8375d59dbf1af7` |

### Sync Tasks

```bash
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:sync:run           # All sync tasks
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:station-queues:clear # Clear queue
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:backup              # Backup

# Reprocess all media (after upload)
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:media:reprocess [station_id]
```

## 8. Quick Commands

```bash
# === STATUS ===
# Now playing + process + queue dalam 1x
echo "=== Now Playing ===" && curl -s https://radio.kbrbaik.live/api/nowplaying/1 | python3 -c "import sys,json; d=json.load(sys.stdin); print(d.get('now_playing',{}).get('song',{}).get('title','N/A'))" && echo "=== Process ===" && docker exec azuracast supervisorctl status | grep station && echo "=== Queue Count ===" && docker exec azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast -e "SELECT station_id, COUNT(*) FROM station_queue GROUP BY station_id;"

# === Cek isi playlist ===
docker exec azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast \
  -e "SELECT sp.name playlist, sm.artist, sm.title FROM station_playlist_media spm JOIN station_playlists sp ON spm.playlist_id = sp.id JOIN station_media sm ON spm.media_id = sm.id WHERE sp.station_id = [id] ORDER BY sp.name, sm.artist;"
```

## 9. Format

Semua command harus menjawab 3 hal:
1. **Apa yang terjadi?** — status sekarang
2. **Apa yang user mau?** — action yang diminta
3. **Hasilnya apa?** — setelah command dijalankan

Untuk perintah berbahaya (restart, hapus file), minta konfirmasi dulu.
