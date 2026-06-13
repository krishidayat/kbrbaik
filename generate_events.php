<?php
// Insert program kerja items as events
$station_id = 2; // suara
$now = date('Y-m-d H:i:s');

$programs = [
    // Bidang 1: Umum & Organisasi → type: Sosialisasi & Edukasi
    ['title' => 'Sosialisasi Profiling Data Jemaat', 'type' => 'Sosialisasi & Edukasi', 'organizer' => 'Litbang', 'date' => '2026-03-15', 'location' => 'Online'],
    ['title' => 'FGD Pemetaan Masalah Lintas Komisi', 'type' => 'Rapat & Sidang', 'organizer' => 'Litbang', 'date' => '2026-04-10', 'location' => 'Kantor PGIW'],

    // Bidang 2: Koinonia
    ['title' => 'Pertukaran Pelayanan HUT PGI', 'type' => 'Rapat & Sidang', 'organizer' => 'Bidang Koinonia', 'date' => '2026-05-20', 'location' => '-'],
    ['title' => 'Bina Oikoumene', 'type' => 'Pelatihan & Pengembangan', 'organizer' => 'Bidang Koinonia', 'date' => '2026-06-12', 'location' => '-'],
    ['title' => 'Kampanye 16 Hari Anti Kekerasan', 'type' => 'Sosialisasi & Edukasi', 'organizer' => 'Komisi Anak & Remaja', 'date' => '2026-11-25', 'location' => 'Kolaborasi LAI, PGIS'],
    ['title' => 'Youth Leadership Camp Batch 2', 'type' => 'Pelatihan & Pengembangan', 'organizer' => 'Komisi Pemuda', 'date' => '2026-07-15', 'location' => '-'],
    ['title' => 'Festival Seni & Olahraga', 'type' => 'Pelatihan & Pengembangan', 'organizer' => 'Komisi Pemuda', 'date' => '2026-08-20', 'location' => '-'],
    ['title' => 'Pelatihan Konselor Tahap 2 & 3', 'type' => 'Pelatihan & Pengembangan', 'organizer' => 'Komisi Perempuan', 'date' => '2026-09-10', 'location' => 'WCC Pasundan'],
    ['title' => 'Sosialisasi Gereja Ramah Anak', 'type' => 'Sosialisasi & Edukasi', 'organizer' => 'Desk GRA', 'date' => '2026-05-08', 'location' => 'Sidang PGIS & POUK'],

    // Bidang 3: Marturia → type: Sosialisasi & Edukasi
    ['title' => 'Seminar Moderasi Beragama', 'type' => 'Sosialisasi & Edukasi', 'organizer' => 'Bidang Marturia', 'date' => '2026-06-18', 'location' => '-'],
    ['title' => 'Pelatihan Penanganan Intoleransi', 'type' => 'Pelatihan & Pengembangan', 'organizer' => 'Desk KBB', 'date' => '2026-08-05', 'location' => 'PGIS masing-masing'],

    // Bidang 4: Diakonia
    ['title' => 'Program Diakonia Berkelanjutan', 'type' => 'Pelayanan & Pendampingan', 'organizer' => 'Bidang Diakonia', 'date' => '2026-03-01', 'location' => '-'],
    ['title' => 'Bulan PRB Nasional 2026', 'type' => 'Sosialisasi & Edukasi', 'organizer' => 'Lingkungan Hidup & Bencana', 'date' => '2026-10-15', 'location' => 'Banten'],
    ['title' => 'Edukasi Lingkungan', 'type' => 'Sosialisasi & Edukasi', 'organizer' => 'Lingkungan Hidup & Bencana', 'date' => '2026-04-22', 'location' => 'Karawang'],
    ['title' => 'Data Guru & Siswa Kristen', 'type' => 'Pelayanan & Pendampingan', 'organizer' => 'Komisi Pendidikan', 'date' => '2026-05-12', 'location' => 'Kemenag Jabar'],
    ['title' => 'Pemberdayaan Ekonomi Jemaat', 'type' => 'Pelayanan & Pendampingan', 'organizer' => 'Desk PEJ', 'date' => '2026-07-05', 'location' => 'Online (gform)'],

    // Bidang 5: Sarpras & Keuangan
    ['title' => 'Pengelolaan Keuangan & Sarpras', 'type' => 'Rapat & Sidang', 'organizer' => 'Bidang Sarpras & Keuangan', 'date' => '2026-02-20', 'location' => 'Kantor Sekretariat'],
    ['title' => 'Pendampingan Hukum Gereja', 'type' => 'Pelayanan & Pendampingan', 'organizer' => 'Komisi Hukum & HAM', 'date' => '2026-04-15', 'location' => 'Phone / onsite'],
    ['title' => 'Penyuluhan Hukum', 'type' => 'Media & Informasi', 'organizer' => 'Komisi Hukum & HAM', 'date' => '2026-06-10', 'location' => 'Radio Maestro'],

    // Bidang 6: Kesekretariatan
    ['title' => 'Pengelolaan Administrasi & SK', 'type' => 'Rapat & Sidang', 'organizer' => 'Bidang Kesekretariatan', 'date' => '2026-01-15', 'location' => 'Kantor Sekretariat'],
    ['title' => 'Penguatan Media Sosial', 'type' => 'Media & Informasi', 'organizer' => 'Media & Informasi', 'date' => '2026-03-20', 'location' => 'Medsos / Grup WA'],
];

foreach ($programs as $p) {
    $slug = strtolower(str_replace(' ', '-', $p['title'])) . '-' . substr(md5(microtime()), 0, 6);
    $desc = "Program " . $p['type'] . " — Pelaksana: " . $p['organizer'];
    
    $sql = "INSERT INTO events (station_id, title, slug, description, event_date, location, organizer, type, is_published, created_at, updated_at) 
            VALUES ($station_id, '" . str_replace("'", "''", $p['title']) . "', '$slug', '$desc', '" . $p['date'] . "', '" . str_replace("'", "''", $p['location']) . "', '" . str_replace("'", "''", $p['organizer']) . "', '" . str_replace("'", "''", $p['type']) . "', 1, '$now', '$now')";
    
    echo $sql . "\n";
}
