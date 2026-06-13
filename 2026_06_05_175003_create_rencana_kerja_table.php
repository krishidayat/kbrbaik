<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rencana_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->nullable()->constrained()->nullOnDelete();
            $table->string('bidang', 100)->comment('Nama bidang');
            $table->string('bidang_no', 2)->nullable()->comment('Nomor bidang 1-6');
            $table->string('entitas', 100)->comment('Bidang/Komisi/Desk');
            $table->string('program', 255)->comment('Nama program/kegiatan');
            $table->string('tujuan', 255)->nullable()->comment('Tujuan/sasaran');
            $table->string('waktu', 100)->nullable()->comment('Waktu pelaksanaan');
            $table->string('tempat', 255)->nullable()->comment('Lokasi/tempat');
            $table->string('anggaran', 100)->nullable()->comment('Anggaran');
            $table->string('keterangan', 255)->nullable();
            $table->string('kategori', 50)->nullable()->comment('Kategori agenda');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rencana_kerja');
    }
};
