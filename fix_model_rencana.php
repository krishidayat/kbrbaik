<?php
$f = '/var/www/radio/app/Models/RencanaKerja.php';
$c = file_get_contents($f);
$new = 'class RencanaKerja extends Model
{
    protected $table = \'rencana_kerja\';

    protected $fillable = [
        \'station_id\', \'bidang\', \'bidang_no\', \'entitas\', \'program\', \'tujuan\',
        \'waktu\', \'tempat\', \'anggaran\', \'keterangan\', \'kategori\', \'is_active\', \'sort_order\',
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}';
$c = str_replace('class RencanaKerja extends Model
{
    //
}', $new, $c);
file_put_contents($f, $c);
echo "OK\n";
