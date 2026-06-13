<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Playlist extends Model
{
    protected $fillable = [
        'station_id',
        'name',
        'period',
        'description',
        'is_active',
        'sort_order',
    ];

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PlaylistItem::class)->orderBy('sort_order');
    }

    public function activeItems(): HasMany
    {
        return $this->hasMany(PlaylistItem::class)->where('is_active', true)->orderBy('sort_order');
    }

    public static function getPeriods(): array
    {
        return [
            'subuh' => 'Subuh (03:00-06:00)',
            'pagi' => 'Pagi (06:00-11:00)',
            'siang' => 'Siang (11:00-15:00)',
            'sore' => 'Sore (15:00-18:00)',
            'malam' => 'Malam (18:00-03:00)',
        ];
    }

    public static function getPeriodNames(): array
    {
        return [
            'subuh' => 'Subuh',
            'pagi' => 'Pagi',
            'siang' => 'Siang',
            'sore' => 'Sore',
            'malam' => 'Malam',
        ];
    }

    public static function getPeriodColors(): array
    {
        return [
            'subuh' => 'indigo',
            'pagi' => 'amber',
            'siang' => 'orange',
            'sore' => 'purple',
            'malam' => 'blue',
        ];
    }

    public static function getPeriodIcons(): array
    {
        return [
            'subuh' => '🌅',
            'pagi' => '☀️',
            'siang' => '🌤️',
            'sore' => '🌆',
            'malam' => '🌙',
        ];
    }

    public static function seedForStation($stationId): void
    {
        $periods = [
            ['name' => 'Subuh', 'period' => 'subuh', 'description' => 'Playlist untuk waktu subuh (03:00 - 06:00)', 'sort_order' => 1],
            ['name' => 'Pagi', 'period' => 'pagi', 'description' => 'Playlist untuk waktu pagi (06:00 - 11:00)', 'sort_order' => 2],
            ['name' => 'Siang', 'period' => 'siang', 'description' => 'Playlist untuk waktu siang (11:00 - 15:00)', 'sort_order' => 3],
            ['name' => 'Sore', 'period' => 'sore', 'description' => 'Playlist untuk waktu sore (15:00 - 18:00)', 'sort_order' => 4],
            ['name' => 'Malam', 'period' => 'malam', 'description' => 'Playlist untuk waktu malam (18:00 - 03:00)', 'sort_order' => 5],
        ];

        foreach ($periods as $p) {
            self::firstOrCreate(
                ['station_id' => $stationId, 'period' => $p['period']],
                $p
            );
        }
    }
}
