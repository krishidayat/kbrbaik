<?php
require_once '/var/www/radio/vendor/autoload.php';
$app = require_once '/var/www/radio/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$station_id = 2;
$now = now();

$programs = [
    ['1','Umum & Organisasi','Bidang Umum & Organisasi','Sosialisasi Profiling Data Jemaat','Pemetaan data anggota PGIW Jabar','2026','Online (link & barcode)','-','Pengganti program database','Sosialisasi & Edukasi'],
    ['1','Umum & Organisasi','Bidang Umum & Organisasi','FGD Pemetaan Masalah Lintas Komisi','Irisan program prioritas','2026','-','-','','Rapat & Sidang'],
    ['1','Umum & Organisasi','Litbang','Pengumpulan Data Anggota PGIW','Database jemaat','2026','Form excel / gform','-','Data bersifat umum','Pelayanan & Pendampingan'],
    ['2','Koinonia','Bidang Koinonia','Pertukaran Pelayanan HUT PGI','Kerjasama ekumene','2026','-','-','Kemitraan lembaga donor','Rapat & Sidang'],
    ['2','Koinonia','Bidang Koinonia','Bina Oikoumene','Pendidikan Ekumene','2026','-','-','Narasumber penulis buku','Pelatihan & Pengembangan'],
    ['2','Koinonia','Komisi Anak & Remaja','Kampanye 16 Hari Anti Kekerasan','Perempuan dan Anak','2026','Kolaborasi LAI, PGIS','-','Narasumber PPA','Sosialisasi & Edukasi'],
    ['2','Koinonia','Komisi Pemuda','Youth Leadership Camp Batch 2','Target 75 youth leader','2026','-','-','Sinergi GAMKI, GMKI','Pelatihan & Pengembangan'],
    ['2','Koinonia','Komisi Pemuda','Festival Seni & Olahraga','Target 200 pemuda','2026','-','-','Pemuda gereja se-Jabar','Pelatihan & Pengembangan'],
    ['2','Koinonia','Komisi Perempuan','Pelatihan Konselor Tahap 2 & 3','Pemimpin perempuan gereja','2026','WCC Pasundan','Kontribusi peserta','Wajib diutus gereja','Pelatihan & Pengembangan'],
    ['2','Koinonia','Desk GRA','Sosialisasi Gereja Ramah Anak','Pemahaman GRA','2026','Sidang PGIS & POUK','-','Buku pedoman GRA','Sosialisasi & Edukasi'],
    ['3','Marturia','Bidang Marturia','Seminar Moderasi Beragama','Kerukunan umat','2026','-','-','','Sosialisasi & Edukasi'],
    ['3','Marturia','Desk KBB','Pelatihan Penanganan Intoleransi','Peningkatan toleransi','2026','PGIS masing-masing','Biaya lembaga pengutus','','Pelatihan & Pengembangan'],
    ['4','Diakonia','Bidang Diakonia','Program Diakonia Berkelanjutan','Pelayanan diakonia','2026','-','-','Koordinasi bidang 3','Pelayanan & Pendampingan'],
    ['4','Diakonia','Lingkungan Hidup & Bencana','Bulan PRB Nasional 2026','Mitigasi bencana','Oktober 2026','Banten','Rp 2.000.000','2 orang, 2 hari','Sosialisasi & Edukasi'],
    ['4','Diakonia','Lingkungan Hidup & Bencana','Edukasi Lingkungan','Kesadaran lingkungan','2026','Karawang','-','Sampah, plastik, air','Sosialisasi & Edukasi'],
    ['4','Diakonia','Pendidikan','Data Guru & Siswa Kristen','Database pendidikan','2026','Kemenag Jabar','-','Dukungan sekolah Kristen','Pelayanan & Pendampingan'],
    ['4','Diakonia','Desk PEJ','Pemberdayaan Ekonomi Jemaat','Potensi ekonomi gereja','2026','Survei via gform','-','','Pelayanan & Pendampingan'],
    ['5','Sarpras & Keuangan','Bidang Sarpras & Keuangan','Pengelolaan Keuangan & Sarpras','Efisiensi anggaran','2026','-','Saldo Rp 551.966.223','','Rapat & Sidang'],
    ['5','Sarpras & Keuangan','Komisi Hukum & HAM','Pendampingan Hukum Gereja','Perlindungan hukum','2026','Phone / onsite','-','Persekusi, izin ibadah','Pelayanan & Pendampingan'],
    ['5','Sarpras & Keuangan','Komisi Hukum & HAM','Penyuluhan Hukum','Edukasi hukum','2026','Radio Maestro','-','Seminar online','Media & Informasi'],
    ['6','Kesekretariatan','Bidang Kesekretariatan','Pengelolaan Administrasi & SK','Ketertiban administrasi','2026','Kantor Sekretariat','-','','Rapat & Sidang'],
    ['6','Kesekretariatan','Media & Informasi','Penguatan Media Sosial','Penyebaran informasi','2026','Medsos / Grup WA','-','Inventarisir akun','Media & Informasi'],
];

$count = 0;
foreach ($programs as $p) {
    \App\Models\RencanaKerja::create([
        'station_id' => $station_id,
        'bidang_no' => $p[0],
        'bidang' => $p[1],
        'entitas' => $p[2],
        'program' => $p[3],
        'tujuan' => $p[4],
        'waktu' => $p[5],
        'tempat' => $p[6],
        'anggaran' => $p[7],
        'keterangan' => $p[8],
        'kategori' => $p[9],
        'is_active' => true,
    ]);
    $count++;
}

echo "Inserted: $count records\n";
