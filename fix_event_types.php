<?php
$f = '/var/www/radio/app/Filament/Resources/Events/Schemas/EventForm.php';
$c = file_get_contents($f);

$old = "Select::make('type')
                    ->options([
                        'ibadah' => 'Ibadah',
                        'rapat' => 'Rapat',
                        'pelatihan' => 'Pelatihan',
                        'sosial' => 'Sosial',
                        'wisuda' => 'Wisuda',
                        'lainnya' => 'Lainnya',
                    ])
                    ->default('lainnya'),";

$new = "Select::make('type')
                    ->options([
                        'Sosialisasi & Edukasi' => 'Sosialisasi & Edukasi',
                        'Pelatihan & Pengembangan' => 'Pelatihan & Pengembangan',
                        'Pelayanan & Pendampingan' => 'Pelayanan & Pendampingan',
                        'Media & Informasi' => 'Media & Informasi',
                        'Rapat & Sidang' => 'Rapat & Sidang',
                        'Siaran' => 'Siaran',
                    ])
                    ->default('Sosialisasi & Edukasi'),";

if (strpos($c, $old) !== false) {
    $c = str_replace($old, $new, $c);
    file_put_contents($f, $c);
    echo "OK\n";
} else {
    echo "FAIL\n";
}
