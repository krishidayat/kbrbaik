<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('playlist_items', function (Blueprint $table) {
            $table->foreignId('playlist_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            $table->enum('item_type', ['audio', 'webstream', 'podcast'])->default('audio')->after('artist');
            $table->string('webstream_url', 500)->nullable()->after('audio_file');
            $table->string('podcast_url', 500)->nullable()->after('webstream_url');
            $table->string('podcast_rss', 500)->nullable()->after('podcast_url');
            $table->string('duration_display', 20)->nullable()->after('duration');
            $table->string('cover_url', 500)->nullable()->after('duration_display');
        });
    }

    public function down(): void
    {
        Schema::table('playlist_items', function (Blueprint $table) {
            $table->dropForeign(['playlist_id']);
            $table->dropColumn([
                'playlist_id', 'item_type', 'webstream_url',
                'podcast_url', 'podcast_rss', 'duration_display', 'cover_url'
            ]);
        });
    }
};
