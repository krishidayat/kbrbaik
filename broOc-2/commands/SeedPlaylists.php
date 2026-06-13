<?php

namespace App\Console\Commands;

use App\Models\Playlist;
use App\Models\Station;
use Illuminate\Console\Command;

class SeedPlaylists extends Command
{
    protected $signature = 'pojok:seed-playlists {--station= : Station ID or slug}';
    protected $description = 'Seed 5 playlists (subuh/pagi/siang/sore/malam) for all or specific station';

    public function handle()
    {
        $stationOption = $this->option('station');

        if ($stationOption) {
            $station = Station::where('id', $stationOption)
                ->orWhere('slug', $stationOption)
                ->first();

            if (!$station) {
                $this->error('Station not found');
                return 1;
            }

            Playlist::seedForStation($station->id);
            $this->info("Playlists seeded for {$station->name}");
            return 0;
        }

        $stations = Station::all();
        foreach ($stations as $station) {
            Playlist::seedForStation($station->id);
            $this->line("Seeded: {$station->name}");
        }

        $this->info("Playlists seeded for {$stations->count()} stations");
        return 0;
    }
}
