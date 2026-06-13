<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\PlaylistItem;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PojokController extends Controller
{
    protected function getStation()
    {
        $domainStation = request('station');

        if (auth()->check()) {
            $user = auth()->user();
            if ($user->studio && $user->studio->community) {
                $userStation = Station::where('slug', $user->studio->community->slug)->first();
                if ($userStation) {
                    return $userStation;
                }
            }
        }

        return $domainStation;
    }

    protected function getUserContext()
    {
        $userStudio = null;
        $userCommunity = null;

        if (auth()->check()) {
            $user = auth()->user();
            $userStudio = $user->studio;
            if ($userStudio) {
                $userCommunity = $userStudio->community;
            }
        }

        return [$userStudio, $userCommunity];
    }

    protected function seedPlaylists($station)
    {
        Playlist::seedForStation($station->id);
    }

    public function dashboard()
    {
        $station = $this->getStation();
        [$userStudio, $userCommunity] = $this->getUserContext();

        if ($station) {
            $this->seedPlaylists($station);
            $playlists = Playlist::where('station_id', $station->id)
                ->withCount('activeItems')
                ->orderBy('sort_order')
                ->get();
            $totalItems = PlaylistItem::where('station_id', $station->id)->count();
            $activeItems = PlaylistItem::where('station_id', $station->id)->where('is_active', true)->count();
            $nowPlaying = $this->fetchNowPlaying($station);
        } else {
            $playlists = collect();
            $totalItems = 0;
            $activeItems = 0;
            $nowPlaying = null;
        }

        return view('pojok.dashboard', compact(
            'station', 'playlists', 'nowPlaying',
            'totalItems', 'activeItems',
            'userStudio', 'userCommunity'
        ));
    }

    public function playlist($period)
    {
        $station = $this->getStation();
        [$userStudio, $userCommunity] = $this->getUserContext();

        if (!$station) {
            abort(404);
        }

        $this->seedPlaylists($station);

        $playlist = Playlist::where('station_id', $station->id)
            ->where('period', $period)
            ->firstOrFail();

        $items = $playlist->activeItems()->get();

        $periods = Playlist::getPeriods();
        $periodNames = Playlist::getPeriodNames();
        $periodColors = Playlist::getPeriodColors();
        $periodIcons = Playlist::getPeriodIcons();

        return view('pojok.playlist', compact(
            'station', 'playlist', 'items',
            'periods', 'periodNames', 'periodColors', 'periodIcons',
            'userStudio', 'userCommunity'
        ));
    }

    public function createItem(Request $req, $period)
    {
        $station = $this->getStation();
        if (!$station) abort(404);

        $playlist = Playlist::where('station_id', $station->id)
            ->where('period', $period)
            ->firstOrFail();

        $data = $req->validate([
            'title' => 'required|string|max:255',
            'artist' => 'nullable|string|max:255',
            'item_type' => 'required|in:audio,webstream,podcast',
            'webstream_url' => 'nullable|url|max:500',
            'podcast_url' => 'nullable|url|max:500',
            'podcast_rss' => 'nullable|url|max:500',
            'duration_display' => 'nullable|string|max:20',
            'cover_url' => 'nullable|url|max:500',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,aac|max:204800',
        ]);

        $maxOrder = PlaylistItem::where('playlist_id', $playlist->id)->max('sort_order') ?? 0;

        $item = new PlaylistItem();
        $item->playlist_id = $playlist->id;
        $item->station_id = $station->id;
        $item->title = $data['title'];
        $item->artist = $data['artist'] ?? '';
        $item->item_type = $data['item_type'];
        $item->webstream_url = $data['webstream_url'] ?? null;
        $item->podcast_url = $data['podcast_url'] ?? null;
        $item->podcast_rss = $data['podcast_rss'] ?? null;
        $item->duration_display = $data['duration_display'] ?? null;
        $item->cover_url = $data['cover_url'] ?? null;
        $item->sort_order = $maxOrder + 1;
        $item->is_active = true;

        if ($req->hasFile('audio_file')) {
            $audio = $req->file('audio_file');
            $path = $audio->store('pojok/' . $station->slug . '/' . $period, 'public');
            $item->audio_file = $path;

            if (class_exists('\getID3')) {
                $getID3 = new \getID3();
                $fileInfo = $getID3->analyze($audio->getPathname());
                if (isset($fileInfo['playtime_seconds'])) {
                    $item->duration = (int) $fileInfo['playtime_seconds'];
                    $item->duration_display = gmdate('H:i:s', (int) $fileInfo['playtime_seconds']);
                }
            }
        }

        $item->save();

        return redirect()->route('pojok.playlist', $period)
            ->with('success', 'Item berhasil ditambahkan ke playlist ' . ucfirst($period));
    }

    public function updateItem(Request $req, $id)
    {
        $station = $this->getStation();
        if (!$station) abort(404);

        $item = PlaylistItem::where('station_id', $station->id)->findOrFail($id);

        $data = $req->validate([
            'title' => 'required|string|max:255',
            'artist' => 'nullable|string|max:255',
            'item_type' => 'required|in:audio,webstream,podcast',
            'webstream_url' => 'nullable|url|max:500',
            'podcast_url' => 'nullable|url|max:500',
            'podcast_rss' => 'nullable|url|max:500',
            'duration_display' => 'nullable|string|max:20',
            'cover_url' => 'nullable|url|max:500',
            'is_active' => 'boolean',
        ]);

        $item->update($data);
        return back()->with('success', 'Item berhasil diperbarui');
    }

    public function deleteItem($id)
    {
        $station = $this->getStation();
        if (!$station) abort(404);

        $item = PlaylistItem::where('station_id', $station->id)->findOrFail($id);

        if ($item->audio_file && Storage::disk('public')->exists($item->audio_file)) {
            Storage::disk('public')->delete($item->audio_file);
        }

        $playlistId = $item->playlist_id;
        $item->delete();

        PlaylistItem::where('playlist_id', $playlistId)->where('is_active', true)
            ->orderBy('sort_order')
            ->each(function ($i, $index) {
                $i->update(['sort_order' => $index + 1]);
            });

        return back()->with('success', 'Item berhasil dihapus');
    }

    public function reorder(Request $req, $period)
    {
        $station = $this->getStation();
        if (!$station) abort(404);

        $playlist = Playlist::where('station_id', $station->id)
            ->where('period', $period)
            ->firstOrFail();

        $data = $req->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:playlist_items,id',
            'items.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($data['items'] as $itemData) {
            PlaylistItem::where('id', $itemData['id'])
                ->where('playlist_id', $playlist->id)
                ->update(['sort_order' => $itemData['sort_order']]);
        }

        return response()->json(['success' => true]);
    }

    public function toggleActive($id)
    {
        $station = $this->getStation();
        if (!$station) abort(404);

        $item = PlaylistItem::where('station_id', $station->id)->findOrFail($id);
        $item->update(['is_active' => !$item->is_active]);

        return back()->with('success', 'Status item berhasil diubah');
    }

    public function importRss(Request $req)
    {
        $station = $this->getStation();
        if (!$station) abort(404);

        $data = $req->validate([
            'rss_url' => 'required|url|max:500',
            'playlist_period' => 'required|in:subuh,pagi,siang,sore,malam',
        ]);

        $playlist = Playlist::where('station_id', $station->id)
            ->where('period', $data['playlist_period'])
            ->first();

        if (!$playlist) {
            return back()->with('error', 'Playlist tidak ditemukan');
        }

        try {
            $response = Http::timeout(30)->get($data['rss_url']);
            if (!$response->successful()) {
                return back()->with('error', 'Gagal mengambil RSS feed');
            }

            $xml = simplexml_load_string($response->body());
            if (!$xml) {
                return back()->with('error', 'Format RSS tidak valid');
            }

            $count = 0;
            $maxOrder = PlaylistItem::where('playlist_id', $playlist->id)->max('sort_order') ?? 0;

            foreach ($xml->channel->item as $rssItem) {
                $title = (string) $rssItem->title;
                $enclosure = $rssItem->enclosure;
                $audioUrl = $enclosure ? (string) $enclosure['url'] : null;
                $duration = (string) $rssItem->children('itunes', true)->duration;
                $image = (string) $rssItem->children('itunes', true)->image;
                $imageUrl = $image ?: (string) $rssItem->image->url;

                if (!$title || !$audioUrl) continue;

                $exists = PlaylistItem::where('playlist_id', $playlist->id)
                    ->where('title', $title)
                    ->where('podcast_url', $audioUrl)
                    ->exists();

                if ($exists) continue;

                $maxOrder++;
                PlaylistItem::create([
                    'playlist_id' => $playlist->id,
                    'station_id' => $station->id,
                    'title' => $title,
                    'artist' => (string) $rssItem->children('itunes', true)->author ?: $station->name,
                    'item_type' => 'podcast',
                    'podcast_url' => $audioUrl,
                    'podcast_rss' => $data['rss_url'],
                    'duration_display' => $duration ?: null,
                    'cover_url' => $imageUrl ?: null,
                    'sort_order' => $maxOrder,
                    'is_active' => true,
                ]);
                $count++;
            }

            return back()->with('success', "Berhasil mengimpor {$count} episode dari RSS");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor RSS: ' . $e->getMessage());
        }
    }

    public function fetchNowPlaying($station = null)
    {
        $station = $station ?? $this->getStation();
        try {
            $response = Http::timeout(10)->get('https://radio.kbrbaik.live/status-json.xsl');
            if ($response->successful()) {
                $data = $response->json();
                $sources = $data['icestats']['source'] ?? [];

                $mount = $station->stream_mount ?? '/stream';
                foreach ($sources as $src) {
                    $listenUrl = $src['listenurl'] ?? '';
                    if (str_contains($listenUrl, $mount)) {
                        return [
                            'title' => $src['title'] ?? 'LibreTime',
                            'artist' => $src['artist_name'] ?? '',
                            'listeners' => $src['listeners'] ?? 0,
                            'listener_peak' => $src['listener_peak'] ?? 0,
                            'server_name' => $src['server_name'] ?? $station->name,
                            'server_description' => $src['server_description'] ?? '',
                            'genre' => $src['genre'] ?? '',
                            'stream_start' => $src['stream_start_iso8601'] ?? null,
                            'audio_info' => $src['audio_info'] ?? '',
                            'online' => true,
                        ];
                    }
                }
                return ['title' => 'Tidak ada data', 'artist' => '', 'listeners' => 0, 'online' => false];
            }
        } catch (\Exception $e) {
            //
        }
        return ['title' => 'Offline', 'artist' => '', 'listeners' => 0, 'online' => false];
    }

    public function apiNowPlaying()
    {
        return response()->json($this->fetchNowPlaying());
    }

    public function generateLiquidsoap($stationId = null)
    {
        $station = $stationId ? Station::findOrFail($stationId) : $this->getStation();
        if (!$station) abort(404);

        $this->seedPlaylists($station);

        $periods = ['subuh', 'pagi', 'siang', 'sore', 'malam'];
        $output = "# Liquidsoap config for {$station->name}\n";
        $output .= "# Generated by Pojok Dashboard\n# " . now() . "\n\n";

        $audioDir = storage_path('app/public/pojok/' . $station->slug);

        foreach ($periods as $period) {
            $playlist = Playlist::where('station_id', $station->id)
                ->where('period', $period)
                ->first();

            if (!$playlist) continue;

            $files = PlaylistItem::where('playlist_id', $playlist->id)
                ->where('item_type', 'audio')
                ->where('is_active', true)
                ->get();

            $dir = $audioDir . '/' . $period;
            if (!is_dir($dir)) {
                $output .= "# {$period}: no directory\n";
                continue;
            }

            $output .= "# ─── {$playlist->name} ───\n";
            $output .= "{$period} = playlist(\"{$dir}/\")\n";
            $output .= "# Items: {$files->count()}\n\n";
        }

        $output .= "# ─── Auto-DJ Rotation ───\n";
        $output .= "# radio = random([\n";
        foreach ($periods as $period) {
            $output .= "#   ({$period}),\n";
        }
        $output .= "# ])\n\n";

        if (request()->wantsJson()) {
            return response()->json(['config' => $output]);
        }

        return response($output, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="liquidsoap-' . $station->slug . '.liq"',
        ]);
    }

    public function webcastRelays()
    {
        $station = $this->getStation();
        [$userStudio, $userCommunity] = $this->getUserContext();

        $webstreams = PlaylistItem::where('station_id', $station->id)
            ->where('item_type', 'webstream')
            ->where('is_active', true)
            ->get();

        return view('pojok.webcast', compact('station', 'webstreams', 'userStudio', 'userCommunity'));
    }

    public function library($period)
    {
        $station = $this->getStation();
        if (!$station) abort(404);

        $playlist = Playlist::where('station_id', $station->id)
            ->where('period', $period)
            ->firstOrFail();

        $existingIds = $playlist->activeItems()->pluck('id')->toArray();

        $files = PlaylistItem::where('station_id', $station->id)
            ->where('item_type', 'audio')
            ->whereNotIn('id', $existingIds)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'title', 'artist', 'audio_file', 'duration', 'duration_display']);

        return response()->json($files);
    }

    public function addFromLibrary(Request $req, $period)
    {
        $station = $this->getStation();
        if (!$station) abort(404);

        $playlist = Playlist::where('station_id', $station->id)
            ->where('period', $period)
            ->firstOrFail();

        $data = $req->validate([
            'source_id' => 'required|integer|exists:playlist_items,id',
        ]);

        $source = PlaylistItem::findOrFail($data['source_id']);

        $maxOrder = PlaylistItem::where('playlist_id', $playlist->id)->max('sort_order') ?? 0;

        $item = PlaylistItem::create([
            'playlist_id' => $playlist->id,
            'station_id' => $station->id,
            'title' => $source->title,
            'artist' => $source->artist,
            'item_type' => 'audio',
            'audio_file' => $source->audio_file,
            'duration' => $source->duration,
            'duration_display' => $source->duration_display,
            'sort_order' => $maxOrder + 1,
            'is_active' => true,
        ]);

        return response()->json(['success' => true, 'item' => $item]);
    }

    public function autoDjStatus()
    {
        $station = $this->getStation();
        if (!$station) abort(404);

        $serviceName = 'liquidsoap-' . $station->slug;
        $output = null;
        $exitCode = null;
        exec("sudo systemctl is-active {$serviceName}.service 2>&1", $output, $exitCode);

        return response()->json([
            'service' => $serviceName,
            'active' => $exitCode === 0,
            'status' => trim(implode("\n", $output)),
        ]);
    }

    public function autoDjToggle()
    {
        $station = $this->getStation();
        if (!$station) abort(404);

        $serviceName = 'liquidsoap-' . $station->slug;
        $output = null;
        $exitCode = null;
        exec("sudo systemctl is-active {$serviceName}.service 2>&1", $output, $exitCode);
        $isActive = $exitCode === 0;

        if ($isActive) {
            exec("sudo systemctl stop {$serviceName}.service 2>&1", $output, $exitCode);
            $action = 'stopped';
        } else {
            exec("sudo systemctl start {$serviceName}.service 2>&1", $output, $exitCode);
            $action = 'started';
        }

        return response()->json([
            'service' => $serviceName,
            'action' => $action,
            'success' => $exitCode === 0,
            'output' => trim(implode("\n", $output)),
        ]);
    }

    public function rundown()
    {
        $station = $this->getStation();
        [$userStudio, $userCommunity] = $this->getUserContext();

        $this->seedPlaylists($station);

        $playlists = Playlist::where('station_id', $station->id)
            ->with('activeItems')
            ->orderBy('sort_order')
            ->get();

        $now = now()->setTimezone('Asia/Jakarta');
        $hour = (int) $now->format('H');

        if ($hour >= 3 && $hour < 6) $currentPeriod = 'subuh';
        elseif ($hour >= 6 && $hour < 11) $currentPeriod = 'pagi';
        elseif ($hour >= 11 && $hour < 15) $currentPeriod = 'siang';
        elseif ($hour >= 15 && $hour < 18) $currentPeriod = 'sore';
        else $currentPeriod = 'malam';

        $periods = Playlist::getPeriods();
        $icons = Playlist::getPeriodIcons();

        return view('pojok.rundown', compact(
            'station', 'playlists', 'currentPeriod',
            'periods', 'icons', 'now'
        ));
    }
}
