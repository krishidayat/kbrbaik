<?php
$f = '/var/www/radio/routes/api.php';
$c = file_get_contents($f);

$rssRoute = <<<'PHP'

Route::post('/studio/import-rss', function (Illuminate\Http\Request $request) {
    $studioId = $request->input('studio_id');
    $rssUrl = $request->input('rss_url');

    $studio = \App\Models\Studio::find($studioId);
    if (!$studio) {
        return response()->json(['success' => false, 'message' => 'Studio tidak ditemukan.'], 404);
    }
    if (!$rssUrl || !filter_var($rssUrl, FILTER_VALIDATE_URL)) {
        return response()->json(['success' => false, 'message' => 'URL RSS tidak valid.'], 400);
    }

    try {
        $xml = simplexml_load_file($rssUrl);
        if (!$xml) {
            return response()->json(['success' => false, 'message' => 'Gagal membaca RSS.'], 400);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Gagal mengunduh RSS: ' . $e->getMessage()], 400);
    }

    $imported = 0;
    $namespace = $xml->getNamespaces(true);
    $itunes = $namespace['itunes'] ?? 'http://www.itunes.com/dtds/podcast-1.0.dtd';

    foreach ($xml->channel->item as $item) {
        $title = (string) $item->title;
        if (!$title) continue;

        $description = (string) $item->description;
        $audioUrl = '';
        $duration = 0;
        $pubDate = null;

        // Get audio enclosure
        if ($item->enclosure) {
            $audioUrl = (string) $item->enclosure['url'];
        }

        // Get duration from iTunes
        $dur = $item->children($itunes)->duration ?? '';
        $dur = (string) $dur;
        if ($dur) {
            $parts = explode(':', $dur);
            if (count($parts) === 3) {
                $duration = (int) $parts[0] * 3600 + (int) $parts[1] * 60 + (int) $parts[2];
            } elseif (count($parts) === 2) {
                $duration = (int) $parts[0] * 60 + (int) $parts[1];
            } else {
                $duration = (int) $dur;
            }
        }

        if ($item->pubDate) {
            try {
                $pubDate = \Carbon\Carbon::parse((string) $item->pubDate);
            } catch (\Exception $e) {
                $pubDate = null;
            }
        }

        $existing = \App\Models\Episode::where('studio_id', $studio->id)
            ->where('title', $title)->first();
        if ($existing) continue;

        $episode = new \App\Models\Episode();
        $episode->station_id = $studio->station_id;
        $episode->studio_id = $studio->id;
        $episode->title = $title;
        $episode->description = $description;
        $episode->audio_file = $audioUrl;
        $episode->duration = $duration;
        $episode->is_published = true;
        $episode->published_at = $pubDate ?? now();
        $episode->save();
        $imported++;
    }

    return response()->json([
        'success' => true,
        'message' => "Berhasil mengimpor {$imported} episode.",
        'imported' => $imported,
    ]);
})->name('api.studio.import-rss');
PHP;

$c = rtrim($c) . "\n" . $rssRoute . "\n";
file_put_contents($f, $c);
echo "OK\n";
