<?php
require_once '/var/www/radio/vendor/autoload.php';
$app = require_once '/var/www/radio/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$station_id = 2;
$now = now();

$programs = [
    ['Sosialisasi Profiling Data Jemaat', 'Sosialisasi & Edukasi', 'Litbang', '2026-03-15', 'Online'],
    ['FGD Pemetaan Masalah Lintas Komisi', 'Rapat & Sidang', 'Litbang', '2026-04-10', 'Kantor PGIW'],
    ['Pertukaran Pelayanan HUT PGI', 'Rapat & Sidang', 'Bidang Koinonia', '2026-05-20', '-'],
    ['Bina Oikoumene', 'Pelatihan & Pengembangan', 'Bidang Koinonia', '2026-06-12', '-'],
    ['Kampanye 16 Hari Anti Kekerasan', 'Sosialisasi & Edukasi', 'Komisi Anak & Remaja', '2026-11-25', 'Kolaborasi LAI, PGIS'],
    ['Youth Leadership Camp Batch 2', 'Pelatihan & Pengembangan', 'Komisi Pemuda', '2026-07-15', '-'],
    ['Festival Seni & Olahraga', 'Pelatihan & Pengembangan', 'Komisi Pemuda', '2026-08-20', '-'],
    ['Pelatihan Konselor Tahap 2 & 3', 'Pelatihan & Pengembangan', 'Komisi Perempuan', '2026-09-10', 'WCC Pasundan'],
    ['Sosialisasi Gereja Ramah Anak', 'Sosialisasi & Edukasi', 'Desk GRA', '2026-05-08', 'Sidang PGIS & POUK'],
    ['Seminar Moderasi Beragama', 'Sosialisasi & Edukasi', 'Bidang Marturia', '2026-06-18', '-'],
    ['Pelatihan Penanganan Intoleransi', 'Pelatihan & Pengembangan', 'Desk KBB', '2026-08-05', 'PGIS masing-masing'],
    ['Program Diakonia Berkelanjutan', 'Pelayanan & Pendampingan', 'Bidang Diakonia', '2026-03-01', '-'],
    ['Bulan PRB Nasional 2026', 'Sosialisasi & Edukasi', 'Lingkungan Hidup & Bencana', '2026-10-15', 'Banten'],
    ['Edukasi Lingkungan', 'Sosialisasi & Edukasi', 'Lingkungan Hidup & Bencana', '2026-04-22', 'Karawang'],
    ['Data Guru & Siswa Kristen', 'Pelayanan & Pendampingan', 'Komisi Pendidikan', '2026-05-12', 'Kemenag Jabar'],
    ['Pemberdayaan Ekonomi Jemaat', 'Pelayanan & Pendampingan', 'Desk PEJ', '2026-07-05', 'Online (gform)'],
    ['Pengelolaan Keuangan & Sarpras', 'Rapat & Sidang', 'Bidang Sarpras & Keuangan', '2026-02-20', 'Kantor Sekretariat'],
    ['Pendampingan Hukum Gereja', 'Pelayanan & Pendampingan', 'Komisi Hukum & HAM', '2026-04-15', 'Phone / onsite'],
    ['Penyuluhan Hukum', 'Media & Informasi', 'Komisi Hukum & HAM', '2026-06-10', 'Radio Maestro'],
    ['Pengelolaan Administrasi & SK', 'Rapat & Sidang', 'Bidang Kesekretariatan', '2026-01-15', 'Kantor Sekretariat'],
    ['Penguatan Media Sosial', 'Media & Informasi', 'Media & Informasi', '2026-03-20', 'Medsos / Grup WA'],
];

$count = 0;
foreach ($programs as $p) {
    $existing = \App\Models\Event::where('station_id', $station_id)->where('title', $p[0])->first();
    if ($existing) continue;
    
    $event = new \App\Models\Event();
    $event->station_id = $station_id;
    $event->title = $p[0];
    $event->slug = \Illuminate\Support\Str::slug($p[0]) . '-' . substr(md5(microtime()), 0, 6);
    $event->description = 'Program ' . $p[1] . ' — Pelaksana: ' . $p[2];
    $event->event_date = $p[3];
    $event->location = $p[4];
    $event->organizer = $p[2];
    $event->type = $p[1];
    $event->is_published = true;
    $event->save();
    $count++;
}

echo "Inserted: $count events\n";
echo "Total suara events: " . \App\Models\Event::where('station_id', $station_id)->count() . "\n";
