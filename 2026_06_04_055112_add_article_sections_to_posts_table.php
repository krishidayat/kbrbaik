<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->text('lead')->nullable()->after('excerpt');
            $table->text('quote')->nullable()->after('body');
            $table->text('resume')->nullable()->after('quote');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['lead', 'quote', 'resume']);
        });
    }
};
