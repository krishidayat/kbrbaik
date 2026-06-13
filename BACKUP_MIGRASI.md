# Backup & Migrasi VPS — Panduan Lengkap

## Backup Manual (kapan aja)

```bash
# 1. Backup semua service sekaligus
ssh ubuntu@kbrbaik.live
cd ~
tar czf kbrbaik-full-$(date +%F).tar.gz \
  kbrbaik-wiki/ \
  agentic-wiki-builder/ \
  wiki.js-data/ \
  botpress/ \
  .hermes/skills/wiki-kbrbaik/ \
  docker-compose.wiki.yml \
  --exclude='node_modules' --exclude='.venv' --exclude='__pycache__'

# 2. Tarik ke lokal
scp ubuntu@kbrbaik.live:~/kbrbaik-full-*.tar.gz D:\backup-vps\
```

---

## Backup Otomatis (cron job di VPS)

```bash
# Buat script backup mingguan
cat > ~/scripts/auto-backup.sh << 'EOF'
#!/bin/bash
BACKUP_DIR=~/backups
mkdir -p $BACKUP_DIR
DATE=$(date +%F)

# Backup wiki repo
cd ~/kbrbaik-wiki
git add -A
git commit -m "auto-backup $DATE" --allow-empty

# Tar archive (cadangan fisik)
tar czf $BACKUP_DIR/kbrbaik-$DATE.tar.gz \
  kbrbaik-wiki/ wiki.js-data/ docker-compose.wiki.yml

# Hapus backup lebih dari 30 hari
find $BACKUP_DIR -name "*.tar.gz" -mtime +30 -delete

echo "Backup $DATE selesai"
EOF

chmod +x ~/scripts/auto-backup.sh

# Jadwalkan tiap Minggu jam 2 pagi
crontab -e
# Tambah baris: 0 2 * * 0 ~/scripts/auto-backup.sh
```

---

## Migrasi ke VPS Baru

### Prasyarat
- VPS baru sudah aktif (Ubuntu 22.04+)
- Domain DNS diarahkan ke IP baru
- SSH key sudah terpasang

### Langkah Migrasi

```bash
# 1. Install dependency dasar di VPS baru
ssh ubuntu@vps-baru
sudo apt update && sudo apt upgrade -y
sudo apt install -y curl git python3 python3-pip sqlite3 nginx
curl -fsSL https://get.docker.com | sh
curl -fsSL https://opencode.ai/install | bash
source ~/.bashrc

# 2. Transfer semua data dari VPS lama
# Dari LOKAL jalanin ini:
ssh ubuntu@kbrbaik.live "tar czf ~/migrate-$(date +%F).tar.gz \
  kbrbaik-wiki/ wiki.js-data/ \
  agentic-wiki-builder/ docker-compose.wiki.yml"

scp ubuntu@kbrbaik.live:~/migrate-*.tar.gz .
scp migrate-*.tar.gz ubuntu@vps-baru:~/
ssh ubuntu@vps-baru "tar xzf migrate-*.tar.gz"

# 3. Setup Nginx (copy config)
scp ubuntu@kbrbaik.live:/etc/nginx/sites-enabled/wiki.kbrbaik.live.conf \
  ubuntu@vps-baru:/etc/nginx/sites-enabled/
scp ubuntu@kbrbaik.live:/etc/letsencrypt/live/wiki.kbrbaik.live/* \
  ubuntu@vps-baru:/etc/letsencrypt/live/wiki.kbrbaik.live/

# 4. Jalankan Wiki.js di VPS baru
ssh ubuntu@vps-baru
sudo docker compose -f ~/docker-compose.wiki.yml up -d

# 5. Update DNS — arahkan wiki.kbrbaik.live ke IP baru
# (via panel domain masing-masing)

# 6. Test
curl -I https://wiki.kbrbaik.live   # harus 200
```

### Rollback
Kalau VPS baru bermasalah, tinggal arahkan DNS balik ke IP lama — semuanya masih utuh di sana.

---

## Service yang perlu dipindahin

| Service | Data | Cara |
|---------|------|------|
| **Wiki.js** | `wiki.js-data/` + `kbrbaik-wiki/` | Tar archive + restore |
| **Botpress** | `botpress/` | Tar archive + docker up |
| **Hermes** | `.hermes/` | Tar archive |
| **SSL** | `/etc/letsencrypt/` | Copy folder |
| **Nginx** | `/etc/nginx/sites-enabled/` | Copy config |
| **Git repo** | `kbrbaik-wiki/.git` | Udah termasuk archive |

---

## Estimasi Biaya VPS

| Provider | Harga/bulan | Spek | Catatan |
|----------|-------------|------|---------|
| **Contabo** | ~$5-7 | 4vCPU, 8GB, 200GB | Paling murah, handal |
| **Hetzner** | ~$4-6 | 2vCPU, 4GB, 40GB | Stabil, bagus |
| **DigitalOcean** | ~$6-12 | 1vCPU, 1-2GB | Lebih mahal tapi support bagus |
| **Vultr** | ~$6-12 | 1vCPU, 1-2GB | Sama DO |
| **Linode** | ~$5-12 | 1vCPU, 1-2GB | Sama DO |
| **Hostingan** (SG/ID) | ~$5-10 | 2vCPU, 4GB | Latensi rendah untuk Indonesia |

**Rekomendasi:** Contabo atau Hetzner untuk budget hemat. Kalo butuh latensi rendah buat Indonesia, Hostingan atau IDCloudHost.

---

## Checklist Cepat Pindah VPS

- [ ] Backup semua data dari VPS lama
- [ ] Setup OS dasar di VPS baru (Docker, Nginx, OpenCode)
- [ ] Transfer file
- [ ] Setup SSL / certbot
- [ ] Setup Nginx config
- [ ] Jalankan service (Wiki.js, Botpress, dll)
- [ ] Test semua domain
- [ ] Update DNS
- [ ] Matikan VPS lama (tunggu 1-2 hari untuk pastikan stabil)

---

*Dokumen disimpan di:*
- `D:\kbrbaik\BACKUP_MIGRASI.md`
- `~/kbrbaik-wiki/BACKUP_MIGRASI.md`
