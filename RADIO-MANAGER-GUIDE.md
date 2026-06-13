# 📻 Panduan Manajer Radio — KBRBaik / SuaraPGIW

---

## 🔄 Daily Checklist

| Waktu | Task | Perintah |
|-------|------|----------|
| Pagi | Cek status stream & AutoDJ | `ssh kbrbaik "sudo docker ps \| grep azuracast"` |
| Pagi | Cek listener count | Buka https://radio.kbrbaik.live |
| Pagi | Cek queue station | `ssh kbrbaik "sudo docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:sync:run"` |
| Sore | Cek now playing | `curl -s https://radio.kbrbaik.live/api/nowplaying \| python3 -m json.tool \| grep -E '"title"\|"name"\|"listeners"'` |

---

## 📅 Mingguan

| Task | Detail |
|------|--------|
| **Rotasi Playlist** | Tambah/hapus lagu via AzuraCast admin |
| **Cek Jadwal** | Pastikan schedule siaran seminggu ke depan sudah benar |
| **Podcast Baru** | Upload episode baru jika ada |
| **Backup** | Cek disk usage — `ssh kbrbaik "df -h /"` |
| **Disk Cleanup** | `ssh kbrbaik "sudo docker image prune -a -f"` |

---

## 📆 Bulanan

| Task | Detail |
|------|--------|
| **Evaluasi Konten** | Artikel, podcast, playlist — apa yang perlu ditambah |
| **Laporan** | Listener stats, artikel terpopuler |
| **Update** | `ssh kbrbaik "sudo docker pull azuracast/azuracast:latest"` (cek changelog dulu) |
| **SSL Check** | `ssh kbrbaik "sudo certbot renew --dry-run"` |

---

## 🚨 Emergency

| Problem | Solusi |
|---------|--------|
| Stream mati | `ssh kbrbaik "sudo docker restart azuracast"` |
| AutoDJ skip | `ssh kbrbaik "sudo docker exec azuracast php /var/azuracast/www/backend/bin/console azuracast:radio:restart 1"` (atau 2) |
| Disk penuh | `ssh kbrbaik "sudo docker system prune -a -f"` + cek log AzuraCast |
| Website error | `ssh kbrbaik "cd /var/www/radio && php artisan optimize:clear"` |

---

## 🧭 Arsitektur

```
┌─────────────────────────────────────────┐
│  VPS kbrbaik (43.134.87.200)             │
│                                          │
│  ┌──────────────────────────────┐       │
│  │  AZURACAST (Docker)          │       │
│  │  radio.kbrbaik.live:8100     │       │
│  │  ├─ Radio Kabar Baik :8000  │       │
│  │  └─ SuaraPGIW         :8010 │       │
│  └──────────────────────────────┘       │
│                                          │
│  ┌──────────────────────────────┐       │
│  │  LARAVEL WEBSITE             │       │
│  │  kbrbaik.live → PHP 8.3     │       │
│  │  suara.kbrbaik.live → PHP   │       │
│  │  Admin: /admin               │       │
│  └──────────────────────────────┘       │
│                                          │
│  ┌──────────────────────────────┐       │
│  │  OTHER SERVICES              │       │
│  │  ├─ Wiki.js → wiki.         │       │
│  │  ├─ Botpress → chatbot      │       │
│  │  └─ Hermes → AI agent       │       │
│  └──────────────────────────────┘       │
└─────────────────────────────────────────┘
```

---

## 🔑 Login Penting

| System | URL | User |
|--------|-----|------|
| **AzuraCast Admin** | https://radio.kbrbaik.live | kristono@gmail.com |
| **Laravel Admin (Suara)** | https://suara.kbrbaik.live/admin | kristono@gmail.com |
| **Laravel Admin (KBRBaik)** | https://kbrbaik.live/admin | admin@kbrbaik.live |
| **SSH VPS** | `ssh -i vps-key ubuntu@kbrbaik.live` | ubuntu |
| **Wiki.js** | https://wiki.kbrbaik.live | (admin) |

---

## 🎯 Untuk Hermes (nanti)

Setelah struktur mantap, skill Hermes untuk radio akan mencakup:

```
hermes radio status          → cek semua station
hermes radio restart [1|2]   → restart station
hermes radio dj [on|off]     → toggle live DJ
hermes radio queue [station] → lihat queue
hermes radio nowplaying      → lagu yang sedang diputar
```
