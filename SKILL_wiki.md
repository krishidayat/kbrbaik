---
name: wiki-kbrbaik
description: "Kelola wiki pengetahuan PGIW Jabar di wiki.kbrbaik.live: proses dokumen, kelola halaman, sync Botpress, tanya jawab konten wiki."
version: 2.0.0
author: OpenCode
license: MIT
metadata:
  hermes:
    tags: [wiki, pgiw, jabar, organisasi, pengetahuan, rapat, dokumen, botpress]
    related_skills: [humas-pgiw-jabar, suara-pgiw-jabar]
    category: domain
---

# Wiki KBRBaik — Pengetahuan Organisasi PGIW Jabar

Kelola pusat pengetahuan PGIW Jawa Barat di https://wiki.kbrbaik.live. 
Dokumen rapat, keputusan sidang, dan materi organisasi diproses jadi halaman wiki terstruktur.

## Akses & Kredensial

- **URL:** https://wiki.kbrbaik.live
- **Admin:** komikpgiwjabar@gmail.com
- **API:** http://localhost:3002/graphql (internal)
- **Gateway AI:** https://wiki.kbrbaik.live/ai/ (Hermes proxy)

## Struktur Kategori (9 Folder)

```
wiki/
├── organisasi/   — Profil, struktur, kepengurusan, sidang MPL
├── rapat/        — Notulen, keputusan rapat
├── kebijakan/    — SOP, tata tertib, pedoman
├── program/      — Program kerja, kegiatan, agenda
├── keuangan/     — Laporan keuangan, anggaran
├── sdm/          — Data anggota, pengurus, struktur SDM
├── dokumentasi/  — Dokumentasi kegiatan, foto
├── publikasi/    — Siaran pers, publikasi media
└── hukum/        — AD/ART, peraturan organisasi
```

## Perintah

### Proses Dokumen ke Wiki

Upload & proses dokumen (PDF/DOCX/MD) ke kategori wiki:

```bash
ssh ubuntu@kbrbaik.live "./kbrbaik-wiki/scripts/wiki-process.sh ~/dokumen.pdf organisasi"
ssh ubuntu@kbrbaik.live "./kbrbaik-wiki/scripts/wiki-process.sh ~/notulen.docx rapat \"fokus pada keputusan anggaran\""
```

### Batch Process Semua File dalam Folder

```bash
ssh ubuntu@kbrbaik.live "./kbrbaik-wiki/scripts/process-all.sh ~/folder-rapat rapat"
```

### Cek Status Git (Provenance)

```bash
ssh ubuntu@kbrbaik.live "cd ~/kbrbaik-wiki && git log --oneline -10"
ssh ubuntu@kbrbaik.live "cd ~/kbrbaik-wiki && git status"
```

### Sync ke Botpress

```bash
ssh ubuntu@kbrbaik.live "./kbrbaik-wiki/scripts/sync-botpress.sh"
```

### Cari di Wiki (via GraphQL API)

```bash
# Cari halaman via API (perlu JWT token dulu)
ssh ubuntu@kbrbaik.live 'bash -s' << 'EOF'
TOKEN=$(curl -s http://localhost:3002/graphql \
  -H "Content-Type: application/json" \
  -d '{"query":"mutation { authentication { login(username: \"komikpgiwjabar@gmail.com\", strategy: \"local\", password: \"'$PASSWORD'\") { jwt } } }"}' | python3 -c "import sys,json; print(json.load(sys.stdin)['data']['authentication']['login']['jwt'])")

curl -s http://localhost:3002/graphql \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{"query":"{ pages { list { title path } } }"}'
EOF
```

### Upload Logo / Ganti Branding

```bash
# Upload logo via Nginx + API
scp -i ~/.ssh/vps-key logo.jpg ubuntu@kbrbaik.live:/var/www/wiki-assets/
ssh ubuntu@kbrbaik.live "sudo chmod 644 /var/www/wiki-assets/logo.jpg"

# Set logoUrl via API
TOKEN=$(ssh ubuntu@kbrbaik.live "curl -s http://localhost:3002/graphql -H 'Content-Type: application/json' -d '{\"query\":\"mutation { authentication { login(username: \\\"komikpgiwjabar@gmail.com\\\", strategy: \\\"local\\\", password: \\\"$PASSWORD\\\") { jwt } } }\"}' | python3 -c \"import sys,json; print(json.load(sys.stdin)['data']['authentication']['login']['jwt'])\"")
ssh ubuntu@kbrbaik.live "curl -s http://localhost:3002/graphql -H 'Content-Type: application/json' -H 'Authorization: Bearer $TOKEN' -d '{\"query\":\"mutation { site { updateConfig(logoUrl: \\\"https://wiki.kbrbaik.live/logo/logo.jpg\\\") { responseResult { succeeded } } } }\"}'"
```

### Edit Halaman Langsung via Git

```bash
ssh ubuntu@kbrbaik.live "cd ~/kbrbaik-wiki && nano wiki/organisasi/profil.md"
ssh ubuntu@kbrbaik.live "cd ~/kbrbaik-wiki && git add -A && git commit -m 'update: profil organisasi'"
```

## Alur Kerja Lengkap

1. Dokumen mentah (PDF/DOCX) masuk ke `~/kbrbaik-wiki/sessions/`
2. `wiki-process.sh` → agentic-wiki-builder (Writer → Editor → Linker)
3. Output markdown tersimpan di `wiki/{kategori}/`
4. Git commit otomatis — riwayat perubahan tercatat
5. Wiki.js baca dari repo internal → tampil di web
6. Manual: sync ke Botpress via `sync-botpress.sh`

## Gateway AI (Hermes Proxy)

Hermes gateway berjalan di port 3200, diakses via:
- `https://wiki.kbrbaik.live/ai/` — Proxy ke Hermes
- `https://wiki.kbrbaik.live/api/tokens` — Token management

## Referensi Cepat

| Service | URL | Path |
|---------|-----|------|
| Wiki.js | https://wiki.kbrbaik.live | `/` |
| Hermes AI | https://wiki.kbrbaik.live/ai/ | `/ai/` |
| Logo | https://wiki.kbrbaik.live/logo/logo-pgiw.jpg | `/logo/` |
| Git repo | /home/ubuntu/kbrbaik-wiki/ | remote: - |
| Pipeline | /home/ubuntu/kbrbaik-wiki/scripts/wiki-process.sh | |
| Session data | /home/ubuntu/kbrbaik-wiki/sessions/ | |
| DB file | /home/ubuntu/wiki.js-data/wiki.db | SQLite |

## Verification

```bash
# Cek wiki在线
curl -sI https://wiki.kbrbaik.live | head -1

# Cek jumlah halaman
find /home/ubuntu/kbrbaik-wiki/wiki -name '*.md' | wc -l

# Cek git log
cd /home/ubuntu/kbrbaik-wiki && git log --oneline -5

# Cek container
docker ps --filter name=wikijs
```

## Google Drive Integration

Officer bisa kirim link GDrive via WA/Telegram, otomatis di-download & diproses.

### Proses File dari GDrive

```bash
# Download folder GDrive & proses ke kategori tertentu
ssh ubuntu@kbrbaik.live "./kbrbaik-wiki/scripts/gdrive-process.sh https://drive.google.com/drive/folders/LINK komisi/info-media"

# Download file tunggal
ssh ubuntu@kbrbaik.live "./kbrbaik-wiki/scripts/gdrive-process.sh https://drive.google.com/uc?id=FILE_ID"

# Tanpa kategori (otomatis deteksi oleh AI)
ssh ubuntu@kbrbaik.live "./kbrbaik-wiki/scripts/gdrive-process.sh https://drive.google.com/drive/folders/LINK"
```

### Alur untuk Officer

1. Officer upload file ke folder Google Drive
2. Chat Hermes: "Proses file baru di GDrive folder wiki"
3. Hermes download semua file via `gdrive-process.sh`
4. Setiap file diproses pipeline Writer → Editor → Linker
5. Hasilnya masuk ke wiki, otomatis terbit

### Contoh Chat Officer

| Pesan Officer | Respon Hermes |
|--------------|---------------|
| "Bro, ada file baru di GDrive" | Download folder, minta kategori |
| "Prosesno file rapat MPH" | Download + proses ke kategori rapat/ |
| "Upload notulen ke wiki" | Download docx + pipeline |

### Web Upload FormPak Arman juga bisa upload lewat browser:- **URL:** https://wiki.kbrbaik.live/upload/- **Password:** pgiw2026- Login sekali, cookie berlaku 7 hari- Drag & drop atau klik untuk pilih file- Format: PDF, DOCX, DOC, TXT, MD (maks 100MB)- Ceklis "Proses otomatis ke wiki" untuk langsung proses- File tersimpan di `/var/www/wiki/sandbox/`
## Sandbox Upload (Pak Arman)

Folder upload khusus untuk Pak Arman dan kantor PGIW.

### Alur Upload

1. Pak Arman upload file ke subfolder sesuai kategori lewat SCP
2. Proses semua file di sandbox: `scripts/process-all.sh /var/www/wiki/sandbox/rapat rapat`
3. Atau per file: `scripts/wiki-process.sh /var/www/wiki/sandbox/rapat/laporan.docx rapat`

### Chat WA/Telegram (via Hermes)

Pak Arman cukup chat:
- "Bro, upload file rapat" → kirim file, Hermes simpan & proses
- "Proseskan file di sandbox" → Hermes proses semua
- "Apa saja file di sandbox?" → Hermes list file

File yang sudah diproses dipindah ke sandbox/processed/

## Auto-Filtering (Klasifikasi Otomatis)

Ini skill inti: AI bisa nentuin kategori file secara otomatis berdasarkan isi dokumen.

### Cara Kerja

1. File masuk (dari GDrive, sandbox, atau chat)
2. Baca konten: judul, isi, jenis dokumen
3. Analisa dan cocokkan dengan kategori PGIW:

| Isi Dokumen | Kategori Tujuan |
|-------------|-----------------|
| Susunan pengurus, struktur, SK pengangkatan | pimpinan/ |
| Keputusan MPL, sidang, kredensi | sidang/ |
| Notulen rapat, agenda rapat | rapat/ |
| Program kerja, renstra, rencana kegiatan | renstra/ |
| Laporan pertanggungjawaban | laporan/ |
| Anggaran, keuangan, dana | keuangan/ |
| Siaran pers, berita, dokumentasi | publikasi/ |
| AD/ART, peraturan, KBB | hukum/ |
| Data anggota, personalia | sdm/ |
| Riset, penelitian | komisi/litbang/ |
| Ekumenis, kerjasama gereja | komisi/koinonia/ |
| Pembinaan anak/remaja | komisi/anak-remaja/ |
| Kepemudaan | komisi/pemuda/ |
| Pemberdayaan perempuan | komisi/perempuan/ |
| Hukum, HAM, advokasi | komisi/hukum-ham/ |
| Kesaksian, pelayanan | komisi/marturia/ |
| Media, publikasi, informasi | komisi/info-media/ |
| Gereja ramah anak | komisi/geraja-ramah-anak/ |
| Campuran / general | kategori utama (profil/pimpinan) |

### Prompt ke AI (Writer Agent)

Kalo Hermes minta AI nentuin kategori:
```
Kategorikan dokumen ini ke folder wiki yang sesuai dengan struktur PGIW Jabar.
Pertimbangkan: isi, topik, jenis dokumen, dan komisi terkait.
Output: wiki/{kategori}/nama_file.md
```
