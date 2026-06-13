<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);
$old = "collect(['Sosialisasi & Edukasi', 'Pelatihan & Pengembangan', 'Pelayanan & Pendampingan', 'Media & Informasi', 'Rapat & Sidang'])";
$new = "collect(['Sosialisasi & Edukasi', 'Pelatihan & Pengembangan', 'Pelayanan & Pendampingan', 'Media & Informasi', 'Rapat & Sidang', 'Siaran'])";
$c = str_replace($old, $new, $c);
file_put_contents($f, $c);
echo "OK\n";
