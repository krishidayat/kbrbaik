<?php
$f = '/var/www/radio/routes/api.php';
$c = file_get_contents($f);

$newRoute = <<<'PHP'

Route::post('/studio/submit', function (Illuminate\Http\Request $request) {
    $type = $request->input('type');
    $studioId = $request->input('studio_id');
    $author = $request->input('author', 'Kontributor Studio');

    $studio = \App\Models\Studio::find($studioId);
    if (!$studio) {
        return response()->json(['success' => false, 'message' => 'Studio tidak ditemukan.'], 404);
    }

    switch ($type) {
        case 'narasi':
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required|string',
            ]);
            $post = new \App\Models\Post();
            $post->station_id = $studio->station_id;
            $post->studio_id = $studio->id;
            $post->title = $validated['title'];
            $post->slug = \Illuminate\Support\Str::slug($validated['title']) . '-' . substr(md5(microtime()), 0, 6);
            $post->body = $validated['body'];
            $post->author = $author;
            $post->type = 'article';
            $post->body_format = 'markdown';
            $post->is_published = false;
            $post->save();
            return response()->json(['success' => true, 'message' => 'Narasi berhasil dikirim.', 'id' => $post->id]);

        case 'foto':
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'required|image|max:10240',
            ]);
            $path = $request->file('image')->store('public/gallery');
            $item = new \App\Models\GalleryItem();
            $item->station_id = $studio->station_id;
            $item->studio_id = $studio->id;
            $item->title = $validated['title'];
            $item->image_path = str_replace('public/', '', $path);
            $item->thumbnail_path = str_replace('public/', '', $path);
            $item->is_active = true;
            $item->save();
            return response()->json(['success' => true, 'message' => 'Foto berhasil diupload.', 'id' => $item->id]);

        case 'podcast':
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'audio' => 'nullable|file|max:51200',
                'url' => 'nullable|url|max:500',
            ]);
            if ($request->hasFile('audio')) {
                $path = $request->file('audio')->store('public/episodes');
                $audioPath = str_replace('public/', '', $path);
            } else {
                $audioPath = $validated['url'] ?? null;
            }
            $episode = new \App\Models\Episode();
            $episode->studio_id = $studio->id;
            $episode->station_id = $studio->station_id;
            $episode->title = $validated['title'];
            $episode->audio_file = $audioPath;
            $episode->is_active = true;
            $episode->save();
            return response()->json(['success' => true, 'message' => 'Podcast berhasil ditambahkan.', 'id' => $episode->id]);

        case 'youtube':
            $validated = $request->validate([
                'url' => 'required|url|max:500',
            ]);
            $studio->youtube_url = $validated['url'];
            $studio->save();
            return response()->json(['success' => true, 'message' => 'URL YouTube diperbarui.']);

        case 'live':
            $validated = $request->validate([
                'url' => 'required|url|max:500',
            ]);
            $studio->stream_url = $validated['url'];
            $studio->save();
            return response()->json(['success' => true, 'message' => 'URL Live Streaming diperbarui.']);

        default:
            return response()->json(['success' => false, 'message' => 'Tipe tidak dikenal.'], 400);
    }
})->name('api.studio.submit');
PHP;

$c = rtrim($c) . "\n" . $newRoute . "\n";
file_put_contents($f, $c);
echo "OK\n";
