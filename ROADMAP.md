# Roadmap Wiki PGIW Jabar — 2026

## Status: ✅ Production (v1.0 — 28 Mei 2026)

---

## Fase 1: Fondasi ✅ (Selesai)

- [x] Arsitektur wiki (9 kategori)
- [x] Pipeline agentic-wiki-builder (Writer→Editor→Linker)
- [x] Wiki.js di https://wiki.kbrbaik.live
- [x] Git provenance (setiap session = branch)
- [x] Import data Sidang MPL 2026 (14 halaman)
- [x] Hermes skill `wiki-kbrbaik`
- [x] Dokumentasi arsitektur (ARSITEKTUR.md)

---

## Fase 2: Stabilisasi & Branding ⏳ (Next — 1-3 hari)

- [ ] **Hard refresh cache browser** — biar anggota lihat langsung
- [ ] **Theming Wiki.js** — logo PGIW Jabar, warna brand
- [ ] **Navigasi sidebar** — atur menu sesuai kategori
- [ ] **Role & permission** — admin, officer, anggota, publik
- [ ] **Home page final** — disetujui pengurus
- [ ] **Import dokumen organisasi** — AD/ART, SK, data gereja anggota

---

## Fase 3: Alur Dokumen (Minggu 1-2)

- [ ] **Google Docs webhook** — tiap update doc → otomatis ke wiki
- [ ] **Watcher folder** — drop PDF di folder → auto-proses ke wiki
- [ ] **Officer workflow** — satu orang upload, pipeline jalan
- [ ] **Batch import** — semua notulen rapat tahun sebelumnya
- [ ] **Botpress sync** — wiki → Botpress knowledge base → chatbot

---

## Fase 4: Akses Anggota (Minggu 2-3)

- [ ] **Google login / SSO** — anggota masuk pake email masing-masing
- [ ] **User guide** — panduan singkat pakai wiki buat anggota
- [ ] **Chatbot WA** — "Cari notulen rapat Januari 2025"
- [ ] **Chatbot Telegram** — jawab pertanyaan organisasi
- [ ] **Mobile friendly** — pastikan Wiki.js responsif di HP

---

## Fase 5: Canggih (Minggu 3-4+)

- [ ] **Pelatihan officer** — 1 orang kuasai seluruh sistem
- [ ] **NotebookLM integration** — export riset → wiki
- [ ] **Statistik & analytics** — lihat halaman mana yang paling sering dibaca
- [ ] **Backup otomatis** — git push ke GitHub/GitLab sebagai remote
- [ ] **Multi-wilayah** — struktur bisa diperluas ke tingkat PGIS / kabupaten

---

## Visi Besar

```
2026 (Mei):    Wiki PGIW Jabar live — officer pertama mulai
2026 (Juni):   Semua dokumen organisasi terintegrasi
2026 (Juli):   Anggota bisa akses dari HP 24/7
2026 (Akhir):  Chatbot menjawab 80% pertanyaan anggota & publik
2027+:         Model untuk wilayah-wilayah lain
```

---

## Catatan Teknis

### Jika Wiki.js error lagi:
```bash
ssh ubuntu@kbrbaik.live
sudo docker restart wikijs
sudo docker logs wikijs --tail 20
```

### Jika pipeline gagal:
```bash
ssh ubuntu@kbrbaik.live
source ~/.local/bin/env
cd ~/kbrbaik-wiki
./scripts/wiki-process.sh ~/file.pdf kategori "prompt tambahan"
```

### Akses cepat dari lokal:
```bash
ssh -i C:\Users\lenovo\.ssh\vps-key ubuntu@kbrbaik.live
```

---

*Dokumen ini disimpan di:*
- `D:\kbrbaik\ROADMAP.md` (lokal)
- `/home/ubuntu/kbrbaik-wiki/ROADMAP.md` (VPS)
