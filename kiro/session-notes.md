# Session Notes — Dashboard Radio v2
**Tanggal:** 22 Juni 2026, mulai ~15:40 WIB  
**Status:** Perencanaan selesai, implementasi belum dimulai

---

## Akses VPS

| Server | Host | User | Key |
|---|---|---|---|
| kbrbaik.live (main) | `kbrbaik.live` | `ubuntu` | `C:\Users\lenovo\.ssh\vps-key` |
| Libretime referensi | `radio.tanganterbukamedia.com` | `ubuntu` | `C:\Users\lenovo\.ssh\id_ed25519` |

SSH command:
```bash
ssh -i "C:\Users\lenovo\.ssh\vps-key" ubuntu@kbrbaik.live
```

---

## Apa yang Sudah Dikerjakan Hari Ini

1. **Dipelajari** struktur instalasi radio-dashboard di VPS (`/var/www/radio`) — Laravel 13 + Filament + SQLite + Icecast2
2. **Direbuild** `dashboard.blade.php` → layout split Libretime-style (kiri Tracks, kanan Scheduled Shows)
3. **Ditambah** route `GET /manage/schedules/today-with-tracks` dan method `schedulesTodayWithTracks()` di controller
4. **Diperbaiki** bug modal upload (display:flex vs hidden class conflict) → AJAX upload
5. **Dipelajari** source code Libretime 4.5.0 di server referensi (CSS, HTML, JS)
6. **Disimpan** perencanaan lengkap di `dashboard-radio-plan.md`

---

## Yang Perlu Dikerjakan Malam Ini

**Tugas utama:** Buat `dashboard_v2.blade.php` dari nol (standalone, tidak extend layout lama)

Urutan pengerjaan:
1. Buat file blade standalone dengan CSS Libretime color palette
2. Master panel header (now playing + dual progress)
3. Sidebar navigasi
4. Panel kiri: Track library (AJAX dari `/manage/tracks/json`)
5. Panel kanan: Scheduled Shows (dari `/manage/schedules/today-with-tracks`)
6. Drag & drop: track kiri → show kanan
7. AJAX upload modal
8. Update routing → arahkan `studio.dashboard` ke view baru
9. Test di VPS

---

## Kondisi VPS Saat Ini

- `/var/www/radio/resources/views/studio/dashboard.blade.php` — sudah diubah (ada .bak backup)
- `/var/www/radio/routes/web.php` — sudah ada route `today-with-tracks`
- `/var/www/radio/app/Http/Controllers/StudioController.php` — sudah ada method `schedulesTodayWithTracks()`
- PM2 process `kbrbaik-player` running
- Icecast2, Nginx, Reverb semua running

## Referensi File Lokal

- `D:\KbrBaik\kiro\dashboard-radio-plan.md` — perencanaan lengkap
- `D:\KbrBaik\libretime.jpg` — screenshot referensi tampilan yang diinginkan
