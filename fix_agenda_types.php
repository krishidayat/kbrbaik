<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);
$old = "\$baseTypes = \$station?->events()
        ->where('is_published', true)
        ->select('type')
        ->distinct()
        ->pluck('type');
    \$extraTypes = collect(['Siaran']);
    \$types = \$baseTypes->merge(\$extraTypes)->unique();";
$new = "\$kategori = collect(['Sosialisasi & Edukasi', 'Pelatihan & Pengembangan', 'Rapat & Sidang', 'Pelayanan & Pendampingan', 'Media & Informasi']);
    \$types = \$kategori;";
if (strpos($c, $old) !== false) {
    $c = str_replace($old, $new, $c);
    file_put_contents($f, $c);
    echo "OK\n";
} else {
    echo "FAIL\n";
}
