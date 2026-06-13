# KBRBaik Wiki — Arsitektur Sistem

## Visi

Satu pusat pengetahuan organisasi yang:
- **Input:** Dokumen rapat, keputusan, Google Docs, PDF → otomatis masuk
- **Proses:** OpenCode (Writer→Editor→Linker) → wiki markdown terstruktur
- **Simpan:** Git (provenance penuh — tau siapa & kapan ngubah apa)
- **Serve:** Botpress knowledge base → Chatbot (WA/Telegram/Web) jawab anggota & publik
- **Analisis:** Hermes agent untuk enrichment + NotebookLM untuk riset

---

## Alur Data

```
[DOKUMEN SUMBER]
  │
  ├── Google Docs (via webhook/Apps Script)
  ├── PDF/Word di-drop (via SCP atau folder share)
  ├── Notulen rapat (dari Sekretaris)
  └── Keputusan organisasi
        │
        ▼
  ┌─────────────────────────────────┐
  │    WEBHOOK ENDPOINT / API       │  ← menerima dokumen dari luar
  │  ┌───────────────────────────┐  │
  │  │  wiki-process.sh          │  │  ← trigger pipeline
  │  └──────────┬────────────────┘  │
  └─────────────┼───────────────────┘
                │
                ▼
  ┌─────────────────────────────────────┐
  │  agentic-wiki-builder (OpenCode)   │
  │                                     │
  │  1. WRITER AGENT                    │  ← ekstrak info dari raw data
  │     - Baca PDF/doc/txt              │     buat halaman wiki markdown
  │     - Ekstrak: keputusan, program,  │
  │       struktur, rekomendasi         │
  │     - Tulis ke wiki/{kategori}/     │
  │                                     │
  │  2. EDITOR AGENT                    │  ← review & refine tulisan
  │     - Verifikasi akurasi            │
  │     - Perbaiki organisasi konten    │
  │     - Tambah link antar halaman     │
  │                                     │
  │  3. LINKER AGENT                    │  ← cross-link seluruh wiki
  │     - duckdb + networkx             │
  │     - Deteksi cluster tak terhubung │
  │     - Tambah link yang relevan      │
  └──────────────┬──────────────────────┘
                 │
                 ▼
  ┌─────────────────────────────────────┐
  │  WIKI MARKDOWN — Git Repository    │
  │                                     │
  │  /home/ubuntu/kbrbaik-wiki/wiki/    │
  │  ├── organisasi/      (struktur,    │
  │  │                    visi-misi,    │
  │  │                    kepengurusan, │
  │  │                    sidang)       │
  │  ├── rapat/           (notulen,     │
  │  │                    keputusan)    │
  │  ├── kebijakan/       (SOP, tata    │
  │  │                    tertib)       │
  │  ├── program/         (prog. kerja, │
  │  │                    kegiatan)     │
  │  ├── keuangan/        (laporan,     │
  │  │                    anggaran)     │
  │  ├── sdm/             (anggota,     │
  │  │                    pengurus)     │
  │  ├── dokumentasi/     (kegiatan,    │
  │  │                    foto)         │
  │  ├── publikasi/       (siaran pers, │
  │  │                    medsos)       │
  │  └── hukum/           (AD/ART,      │
  │                        peraturan)   │
  │                                     │
  │  Git log → full provenance          │
  │  git blame wiki/file.md             │
  │  git log --grep="session-{uuid}"    │
  └──────────────┬──────────────────────┘
                 │
                 ▼
  ┌─────────────────────────────────────┐
  │  BOTPRESS KNOWLEDGE BASE           │
  │                                     │
  │  Sync: script/sync-botpress.sh      │
  │  Format: markdown → Botpress KB     │
  │  Serve: chatbot jawab pertanyaan    │
  └──────────────┬──────────────────────┘
                 │
                 ▼
  ┌─────────────────────────────────────┐
  │  CHANNELS                           │
  │                                     │
  │  ├── WhatsApp (Hermes gateway)      │
  │  ├── Telegram (Bot Hermes)          │
  │  ├── Web (Botpress embedded)        │
  │  └── Discord (Hermes bot)           │
  │                                     │
  │  Anggota: "Apa keputusan rapat      │
  │           tentang anggaran 2026?"   │
  │  Publik: "Bagaimana cara daftar    │
  │          anggota PGIW Jabar?"       │
  └─────────────────────────────────────┘
```

---

## Layer Arsitektur

```
┌────────────────────────────────────────────────────────┐
│                    CHANNEL LAYER                        │
│  WhatsApp | Telegram | Web | Discord                    │
└──────────────────────────┬─────────────────────────────┘
                           │
┌──────────────────────────┴─────────────────────────────┐
│                    BOT LAYER                            │
│  Botpress (knowledge base + NLU) | Hermes (skills)     │
│  ─ jawab pertanyaan berbasis wiki                       │
│  ─ routing ke OpenCode untuk task spesifik              │
└──────────────────────────┬─────────────────────────────┘
                           │
┌──────────────────────────┴─────────────────────────────┐
│                    KNOWLEDGE LAYER                      │
│  Wiki Markdown (git) → Botpress KB sync                │
│  Hermes skills untuk enrichment & monitoring            │
│  NotebookLM untuk riset/analisis (manual export)        │
└──────────────────────────┬─────────────────────────────┘
                           │
┌──────────────────────────┴─────────────────────────────┐
│                    PROCESSING LAYER                     │
│  agentic-wiki-builder (OpenCode engine)                 │
│  ├── Writer Agent   → ekstrak + tulis                   │
│  ├── Editor Agent   → review + refine                   │
│  └── Linker Agent   → cross-link + graph                │
└──────────────────────────┬─────────────────────────────┘
                           │
┌──────────────────────────┴─────────────────────────────┐
│                    INGESTION LAYER                      │
│  Webhook endpoint | SCP | Google Docs API               │
│  Watcher folder | Manual upload                         │
└─────────────────────────────────────────────────────────┘
```

---

## Komponen & Status

| Komponen | Status | Keterangan |
|----------|--------|-----------|
| Wiki struktur (9 kategori) | ✅ Selesai | Sudah ada + isi dari Sidang MPL 2026 |
| agentic-wiki-builder | ✅ Siap | Terinstall di VPS, sudah teruji |
| wiki-process.sh | ✅ Siap | Pipeline Writer→Editor→Linker |
| Git provenance | ✅ Aktif | Setiap session = branch + merge |
| Hermes skill wiki-kbrbaik | ✅ Siap | Bisa dipanggil dari WA/Telegram |
| Botpress sync | ⚠️ Perlu setup | Script ada, tinggal dikonfig |
| Google Docs webhook | ❌ Belum | Endpoint perlu dibuat |
| Watcher folder otomatis | ❌ Belum | Dropbox → auto-process |
| NotebookLM integrasi | ⚠️ Manual | Export → upload ke pipeline |
| Chatbot multi-channel | ⚠️ Sebagian | Hermes udah jalan, Botpress perlu konek |

---

## Prinsip Desain

1. **Git sebagai source of truth** — setiap perubahan punya jejak
2. **Flat file markdown** — portable, readable, versionable
3. **Multi-agent pipeline** — Writer bikin, Editor review, Linker sambung
4. **Bot agnostik** — Botpress atau Hermes bisa serve konten yang sama
5. **Provenance > Citation** — `git blame` lebih reliable dari anchor citation
