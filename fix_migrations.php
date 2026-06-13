<?php
// Fix both migration files
$f1 = '/var/www/radio/database/migrations/2026_06_04_135839_add_studio_id_to_posts_table.php';
$f2 = '/var/www/radio/database/migrations/2026_06_04_135839_add_studio_id_to_gallery_items_table.php';

// Posts migration
$c1 = '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(\'posts\', function (Blueprint $table) {
            $table->foreignId(\'studio_id\')->nullable()->constrained()->nullOnDelete()->after(\'station_id\');
        });
    }

    public function down(): void
    {
        Schema::table(\'posts\', function (Blueprint $table) {
            $table->dropForeign([\'studio_id\']);
            $table->dropColumn(\'studio_id\');
        });
    }
};
';

// Gallery items migration
$c2 = '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(\'gallery_items\', function (Blueprint $table) {
            $table->foreignId(\'studio_id\')->nullable()->constrained()->nullOnDelete()->after(\'station_id\');
        });
    }

    public function down(): void
    {
        Schema::table(\'gallery_items\', function (Blueprint $table) {
            $table->dropForeign([\'studio_id\']);
            $table->dropColumn(\'studio_id\');
        });
    }
};
';

file_put_contents($f1, $c1);
file_put_contents($f2, $c2);
echo "OK\n";
