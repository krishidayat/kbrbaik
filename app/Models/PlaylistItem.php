<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlaylistItem extends Model
{
    protected $fillable = [
        'playlist_id',
        'station_id',
        'title',
        'artist',
        'item_type',
        'audio_file',
        'webstream_url',
        'podcast_url',
        'podcast_rss',
        'duration',
        'duration_display',
        'cover_url',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration' => 'integer',
    ];

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function playlist(): BelongsTo
    {
        return $this->belongsTo(Playlist::class);
    }
}
