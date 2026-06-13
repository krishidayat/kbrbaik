# AzuraCast Mastering Guide — Radio KbrBaik & SuaraPGIW

## Daftar Isi
1. [Akses & Login](#1-akses--login)
2. [Dashboard Overview](#2-dashboard-overview)
3. [Manajemen Station](#3-manajemen-station)
4. [Upload & Kelola File Musik](#4-upload--kelola-file-musik)
5. [Playlist & AutoDJ](#5-playlist--autodj)
6. [Podcast](#6-podcast)
7. [Streamer / Live DJ](#7-streamer--live-dj)
8. [Mount Points & Stream URL](#8-mount-points--stream-url)
9. [Now Playing & Public Player](#9-now-playing--public-player)
10. [Scheduled Broadcast](#10-scheduled-broadcast)
11. [System Settings](#11-system-settings)
12. [Troubleshooting](#12-troubleshooting)
13. [Quick Reference](#13-quick-reference)

---

## 1. Akses & Login

| Item | Detail |
|------|--------|
| URL | `https://radio.kbrbaik.live` |
| Admin Email | `kristono@gmail.com` |
| Admin Password | `LiveGood#2026` |
| API Key (station 1) | `394c90c9513d1edcb960ded28d9e142402ed5058925c5211285a351d09ab33d412d9069cd9a3b734db7818c52ad6ace07c37` |
| API Key (station 2) | `dbe29e6d3ee96cb4ea0b8655670aa2002ebde9d7c45a3a97b3573aa948ac363e75622f04c1d4a976807a4b8375d59dbf1af7` |

## 2. Dashboard Overview

Setelah login, halaman utama menampilkan:

- **Map** — lokasi pendengar (jika ada)
- **Now Playing** — lagu/siaran yang sedang diputar per station
- **Queue** — antrian lagu berikutnya
- **Statistics** — total listeners, requests, dll
- **System Health** — status CPU, RAM, disk

### Navigation Menu (Sidebar Kiri)

| Menu | Fungsi |
|------|--------|
| Dashboard | Overview semua station |
| Stations | Kelola masing-masing station |
| System Logs | Log aplikasi, nginx, liquidsoap |
| Backups | Backup database & media |
| Users | Kelola akun admin |

---

## 3. Manajemen Station

### Stations Kita Saat Ini

| Station | Shortcode | Port | Public URL |
|---------|-----------|------|------------|
| Radio Kabar Baik | `radio_kabar_baik` | 8000 | `/public/radio_kabar_baik` |
| Podcast PGIW | `suarapgiw` | 8010 | `/public/suarapgiw` |

### Edit Station Settings

1. **Stations → Pilih station → Edit** (icon pensil)
2. Konfigurasi penting:

| Setting | Radio Kabar Baik | SuaraPGIW |
|---------|-----------------|-----------|
| Name | Radio Kabar Baik | Podcast PGIW |
| Short Name | `radio_kabar_baik` | `suarapgiw` |
| Genre | Gospel Jazz | Podcast |
| Country | ID | ID |
| Timezone | Asia/Jakarta | Asia/Jakarta |
| Default Mount | `/radio.mp3` | `/radio.mp3` |
| Broadcast Format | MP3 192kbps | MP3 192kbps |

### Membuat Station Baru

**Via CLI (VPS):**
```bash
# 1. Buat direktori
docker exec azuracast mkdir -p /var/azuracast/stations/[nama]/media

# 2. Buat storage location (dapatkan ID terakhir)
docker exec -i azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast << EOF
INSERT INTO storage_location (type, adapter, path, storage_used)
VALUES ('station_media', 'local', '/var/azuracast/stations/[nama]/media', 0);
EOF

# 3. Buat station (contoh minimal fields)
docker exec -i azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast << EOF
INSERT INTO station (name, short_name, frontend_type, backend_type, is_enabled,
  enable_requests, enable_streamers, enable_public_page, enable_public_api,
  needs_restart, has_started, is_streamer_live, enable_on_demand,
  enable_on_demand_download, enable_hls, api_history_items, request_delay,
  request_threshold, timezone, radio_base_dir, media_storage_location_id,
  recordings_storage_location_id, podcasts_storage_location_id)
VALUES ('Nama Station', 'nama_station', 'icecast', 'liquidsoap',
  1, 0, 0, 1, 1, 0, 1, 0, 0, 1, 0, 5, 5, 15, 'Asia/Jakarta',
  '/var/azuracast/stations/[nama]', [media_id], [rec_id], [pod_id]);
EOF

# 4. Buat mount point
docker exec -i azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast << EOF
INSERT INTO station_mounts (station_id, name, is_default, enable_autodj,
  autodj_format, autodj_bitrate, is_public, display_name,
  is_visible_on_public_pages, listeners_unique, listeners_total,
  max_listener_duration)
VALUES ([id_station], '/radio.mp3', 1, 1, 'mp3', 192, 0, '', 1, 0, 0, 0);
EOF

# 5. Generate config & restart
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:radio:restart [id_station]
```

### Start / Stop / Restart Station

**Via Dashboard:** Stations → Pilih station → Restart (icon 🔄)

**Via CLI:**
```bash
# Restart semua station
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:radio:restart

# Restart station tertentu (by ID)
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:radio:restart 1
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:radio:restart 2

# Via supervisor
docker exec azuracast supervisorctl restart station_1:station_1_backend
docker exec azuracast supervisorctl restart station_1:station_1_frontend
docker exec azuracast supervisorctl restart station_2:station_2_backend
docker exec azuracast supervisorctl restart station_2:station_2_frontend
```

---

## 4. Upload & Kelola File Musik

### Via Web Dashboard

1. **Stations → Pilih station → Files**
2. Upload satu per satu atau batch
3. **Max upload**: 200MB per file

### Via SFTP

AzuraCast built-in SFTP server:
- **Port**: 8102
- **Host**: `radio.kbrbaik.live`
- **User**: (username dari dashboard station)
- **Pass**: (password dari dashboard station)

### Tips Upload

```bash
# Format file didukung
.mp3, .ogg, .flac, .aac, .wav, .wma

# Max bitrate: 320kbps (recommended: 192kbps)
# Sampling rate: 44100Hz (standar)

# Struktur folder:
# media/
#   └── lagu1.mp3
#   └── lagu2.mp3
#   └── folder_album/
#        └── lagu3.mp3
```

---

## 5. Playlist & AutoDJ

### Membuat Playlist Baru

1. **Stations → Pilih station → Playlists → Add Playlist**
2. Tipe playlist:

| Type | Fungsi |
|------|--------|
| **Default** | Putar terus menerus (default) |
| **Once per Hour** | Main setiap jam pada menit tertentu |
| **Once per X Songs** | Main setiap X lagu |
| **Once per X Minutes** | Main setiap X menit |
| **Request** | Lagu yang bisa diminta pendengar |
| **Scheduled** | Main sesuai jadwal waktu |

3. **Playback Order:**
   - **Shuffle** — acak
   - **Sequential** — urut sesuai daftar
   - **Random** — random, ulang jika semua sudah diputar

### Menambahkan Lagu ke Playlist

1. Buka playlist → **Songs** tab
2. Cari lagu → klik tambah
3. Atur **Weight** (prioritas, makin tinggi makin sering muncul)

### AutoDJ Queue

AutoDJ otomatis mengisi antrian dari playlist. Queue direfresh setiap siklus sync (1 menit).

**Jika queue kosong:**
```bash
# Cek queue count
docker exec azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast \
  -e "SELECT COUNT(*) FROM station_queue WHERE station_id = [id];"

# Force insert queue dari media library
docker exec -i azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast << SQL
INSERT INTO station_queue (song_id, station_id, playlist_id, media_id,
  sent_to_autodj, timestamp_cued, duration, text, artist, title, album,
  is_played, is_visible)
SELECT m.song_id, [station_id], [playlist_id], m.id, 0, NOW(), m.length,
  CONCAT(m.artist, ' - ', m.title), m.artist, m.title, m.album, 0, 1
FROM station_media m WHERE m.storage_location_id = [storage_id];
SQL
```

---

## 6. Podcast

### Setup Podcast Station

**SuaraPGIW** sudah dikonfigurasi sebagai station podcast.

### Mengelola Episode Podcast

1. **Stations → Pilih station → Podcasts**
2. **Add Podcast** — buat brand baru
3. **Add Episode**:
   - Judul episode
   - Upload file audio (MP3 recommended)
   - Deskripsi (opsional)
   - Artwork (opsional)
   - Explicit content flag (jika perlu)

### RSS Feed

AzuraCast otomatis generate RSS feed untuk setiap podcast:
```
https://radio.kbrbaik.live/podcast/[station_shortcode]/[podcast_id]/feed
```

---

## 7. Streamer / Live DJ

### Mengaktifkan Streamer

1. **Stations → Edit → Broadcasting**
2. Centang **"Enable Streamers / DJs"**
3. Save

### Konfigurasi DJ

| Setting | Value |
|---------|-------|
| DJ Port | Auto (config) |
| DJ Mount Point | `/` |
| Source Password | Lihat di edit station → Broadcasting |

### Cara DJ Connect (via OBS, Mixxx, dll)

| Parameter | Value |
|-----------|-------|
| Server | `radio.kbrbaik.live` |
| Port | AutoDJ: 8005 (station 1) / 8015 (station 2) |
| Mount | `/` |
| Source Password | `WPZdX3Zy` (station 1) / `pgiw2026` (station 2) |
| Format | MP3 192kbps |

### AutoDJ Fallback

Saat DJ disconnect, AutoDJ otomatis kembali memutar playlist setelah 5 detik.

---

## 8. Mount Points & Stream URL

### Daftar Mount Point

| Station | Mount | Bitrate | Listen URL |
|---------|-------|---------|------------|
| Radio Kabar Baik | `/radio.mp3` | 192 kbps | `/listen/radio_kabar_baik/radio.mp3` |
| SuaraPGIW | `/radio.mp3` | 192 kbps | `/listen/suarapgiw/radio.mp3` |

### Public Player URLs

| Station | URL |
|---------|-----|
| Radio Kabar Baik | `https://radio.kbrbaik.live/public/radio_kabar_baik` |
| SuaraPGIW | `https://radio.kbrbaik.live/public/suarapgiw` |

### Streaming URLs untuk Player External

```bash
# Format PLS
https://radio.kbrbaik.live/public/radio_kabar_baik/playlist.pls
https://radio.kbrbaik.live/public/suarapgiw/playlist.pls

# Format M3U
https://radio.kbrbaik.live/public/radio_kabar_baik/playlist.m3u
https://radio.kbrbaik.live/public/suarapgiw/playlist.m3u

# Direct stream
https://radio.kbrbaik.live/listen/radio_kabar_baik/radio.mp3
https://radio.kbrbaik.live/listen/suarapgiw/radio.mp3
```

---

## 9. Now Playing & Public Player

### Now Playing API

```bash
# Semua station
curl -s https://radio.kbrbaik.live/api/nowplaying

# Station spesifik
curl -s https://radio.kbrbaik.live/api/nowplaying/1
curl -s https://radio.kbrbaik.live/api/nowplaying/2

# Format JSON
curl -s https://radio.kbrbaik.live/api/nowplaying | python3 -m json.tool
```

### Integrasi Wiki

Untuk nampilin now playing di Wiki.js:
```html
<iframe src="https://radio.kbrbaik.live/public/radio_kabar_baik" 
  width="100%" height="200" frameborder="0"></iframe>
```

### Customize Public Player

1. **Stations → Pilih station → Edit → Branding**
2. Atur:
   - **Custom CSS** — ubah tampilan player
   - **Custom JS** — tambah fungsi
   - **Album Art URL** — ganti default cover

---

## 10. Scheduled Broadcast

### Setup Jadwal

1. **Stations → Pilih station → Playlists → Add Playlist**
2. Pilih type: **Scheduled**
3. Set waktu:
   - Start time
   - End time
   - Days of week
   - Play once / Loop

### Contoh Jadwal

| Jam | Playlist | Deskripsi |
|-----|----------|-----------|
| 05:00-06:00 | Morning Worship | Renungan pagi |
| 06:00-18:00 | Daily Mix | Musik sepanjang hari |
| 18:00-19:00 | Evening Prayer | Doa malam |

### Priority & Fallback

- Playlist dengan jadwal spesifik memiliki prioritas lebih tinggi
- Default playlist sebagai fallback saat tidak ada jadwal aktif

---

## 11. System Settings

### Admin Settings

| Menu | Fungsi |
|------|--------|
| Settings → General | Base URL, instance name, timezone |
| Settings → Broadcasting | Default port range, pengaturan siaran |
| Settings → Security | API access control, CORS |
| Settings → Customization | Tema, CSS/JS kustom |
| Users | Tambah admin baru |
| Backups | Backup/restore database |

### CLI Settings

```bash
# Cek status supervisor
docker exec azuracast supervisorctl status

# Backup database
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:backup

# Sync all tasks
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:sync:run

# Clear station queue
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:station-queues:clear
```

### Port Ranges Used

| Port | Service |
|------|---------|
| 8000 | Icecast (Radio Kabar Baik) |
| 8004 | Liquidsoap Telnet (station 1) |
| 8005 | DJ Port (station 1) |
| 8010 | Icecast (SuaraPGIW) |
| 8014 | Liquidsoap Telnet (station 2) |
| 8015 | DJ Port (station 2) |
| 8100-8106 | AzuraCast web, SFTP |

---

## 12. Troubleshooting

### "Station is offline" / Queue Kosong

```bash
# Cek supervisor
docker exec azuracast supervisorctl status | grep station

# Restart
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:radio:restart [id]

# Cek queue
docker exec azuracast mariadb -u azuracast -p'AzuraCast2026!' azuracast \
  -e "SELECT COUNT(*) FROM station_queue WHERE station_id = [id];"

# Force insert queue jika kosong
```

### "Unable to create directory / Permission denied"

```bash
# Fix ownership
docker exec azuracast chown -R 1000:1000 /var/azuracast/stations/[name]/
```

### "Liquidsoap connection failed: 403, too many streams"

```bash
# Restart icecast frontend
docker exec azuracast supervisorctl restart station_[id]:station_[id]_frontend
```

### "File upload fails"

```bash
# Cek disk space
docker exec azuracast df -h

# Cek max upload di nginx
docker exec azuracast grep client_max /etc/nginx/nginx.conf

# Cek PHP limits
docker exec azuracast php -i | grep upload_max
```

### Log Files

```bash
# Liquidsoap log
docker exec azuracast tail -50 /var/azuracast/stations/[name]/config/liquidsoap.log

# Icecast log
docker exec azuracast tail -50 /var/azuracast/stations/[name]/config/icecast.log

# Application log
docker exec azuracast tail -50 /var/azuracast/www_tmp/app-$(date +%F).log

# Nginx error log
docker exec azuracast tail -50 /var/azuracast/www_tmp/service_nginx.log
```

### "AutoDJ could not be initialized within the specified timeout"

```bash
# Restart PHP worker
docker exec azuracast supervisorctl restart php-worker php-nowplaying

# Clear & rebuild queue
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:station-queues:clear
docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:sync:run
```

---

## 13. Quick Reference

```bash
# === DOCKER ===
docker exec azuracast [command]          # Run command in AzuraCast container
docker exec -i azuracast mariadb ...      # MySQL query
docker exec azuracast supervisorctl ...   # Process management

# === CLI CONSOLE ===
php /var/azuracast/www/backend/bin/console [command]

# === KEY COMMANDS ===
azuracast:radio:restart [id]             # Restart station
azuracast:sync:run                        # Run all sync tasks
azuracast:station-queues:clear            # Clear queues
azuracast:setup --update                  # Update/config regenerate
azuracast:media:reprocess [id]            # Reprocess media metadata

# === SUPERVISOR ===
supervisorctl status                      # Check all processes
supervisorctl restart station_[id]:*      # Restart station processes
supervisorctl restart php-worker          # Restart PHP worker
supervisorctl restart php-nowplaying      # Restart nowplaying

# === STORAGE LOCATIONS ===
# station 1: media=3, recordings=4, podcasts=5
# station 2: media=6, recordings=7, podcasts=8
```

---

*Last updated: May 2026 — Radio KbrBaik & SuaraPGIW @ kbrbaik.live*
