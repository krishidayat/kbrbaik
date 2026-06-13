<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string('token', 64)->unique();
            $table->string('email');
            $table->foreignId('community_id')->constrained()->cascadeOnDelete();
            $table->foreignId('studio_id')->nullable()->constrained()->nullOnDelete();
            $table->string('role', 20)->default('anggota');
            $table->foreignId('invited_by')->constrained('users')->cascadeOnDelete();
            $table->text('message')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
