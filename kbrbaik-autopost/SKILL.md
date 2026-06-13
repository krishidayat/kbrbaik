---
name: kbrbaik-autopost
description: "Autoposting ke blog KbrBaik dan Suara PGIW: buat artikel, upload gambar, pilih kategori."
version: 1.0.0
author: KbrBaik
---

# KbrBaik Autopost Skill

Skill ini memungkinkan user mengirim konten (artikel, berita, ide) ke blog KbrBaik.live atau Suara PGIW secara otomatis via API.

## Target Station

User bisa menentukan target dengan menyebut:
- `kbrbaik` atau `kbrbaik.live` → posting ke Radio Kabar Baik (station_id=1)
- `suara` atau `suara.kbrbaik.live` → posting ke Suara PGIW Jabar (station_id=2)
- Jika tidak disebut, **default ke kbrbaik**

## Format Input

User bisa kirim dalam format bebas. Extrak informasi berikut:

### Wajib
- **Judul** — judul artikel
- **Isi** — konten utama (bisa plain text atau markdown)

### Opsional
- **Kategori** — pilih dari: Kabar, Inspirasi, Opini, Cerita, Puisi, Lagu, Buku (kbrbaik) atau kategori lain sesuai station
- **Nama penulis** — default "Kontributor"
- **Gambar** — file gambar yang diupload user

## Cara Posting

Gunakan `terminal` tool untuk mengirim POST request:

```bash
# Untuk kbrbaik (default)
curl -s -X POST https://kbrbaik.live/api/autopost \
  -F "title=Judul Artikel" \
  -F "body=Isi konten di sini..." \
  -F "author=Nama Penulis" \
  -F "category_id=ID_KATEGORI" \
  -F "image=@/path/gambar.jpg"

# Untuk suara
curl -s -X POST https://suara.kbrbaik.live/api/autopost \
  -F "title=Judul Artikel" \
  -F "body=Isi konten..." \
  -F "author=Nama" \
  -F "category_id=ID" \
  -F "station_id=2" \
  -F "image=@/path/gambar.jpg"
```

## Kategori Mapping

### KbrBaik (station_id=1)
| Kategori | ID |
|----------|----|
| Kabar | 122 |
| Inspirasi | 123 |
| Opini | 124 |
| Cerita | 125 |
| Puisi | 126 |
| Lagu | 127 |
| Buku | 128 |

### Suara PGIW (station_id=2)
Gunakan API `/api/categories` untuk mendapatkan daftar kategori terkini.

## Alur

1. User kirim pesan (via WhatsApp atau WebUI) berisi konten
2. Tanyakan yang kurang jika belum lengkap (minimal judul + isi)
3. Konfirmasi ke user sebelum posting
4. Panggil API via curl
5. Laporkan hasil: URL artikel yang sudah publish

## Catatan

- Gambar dikirim sebagai file attachment (WhatsApp) atau upload (WebUI)
- Gambar yang dikirim akan otomatis jadi featured_image artikel
- Semua konten langsung publish (is_published=true)
- Gunakan markdown untuk formatting konten
