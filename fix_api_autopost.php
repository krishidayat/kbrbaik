<?php
$f = '/var/www/radio/routes/api.php';
$c = file_get_contents($f);

$newRoute = <<<'ROUTE'

// Autopost: submit konten dari publik / WhatsApp
Route::post('/api/autopost', function (Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'author' => 'nullable|string|max:100',
        'category_id' => 'nullable|exists:categories,id',
        'station_id' => 'nullable|exists:stations,id',
        'image' => 'nullable|image|max:5120',
        'source' => 'nullable|string|max:50',
    ]);

    $stationId = $validated['station_id'] ?? station()?->id ?? 1;

    $post = new \App\Models\Post();
    $post->station_id = $stationId;
    $post->title = $validated['title'];
    $post->slug = \Illuminate\Support\Str::slug($validated['title']) . '-' . substr(md5(microtime()), 0, 6);
    $post->body = $validated['body'];
    $post->author = $validated['author'] ?? 'Kontributor';
    $post->category_id = $validated['category_id'] ?? null;
    $post->type = 'article';
    $post->body_format = 'markdown';
    $post->is_published = true;
    $post->published_at = now();
    $post->source_url = $validated['source'] ?? null;

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('public');
        $post->featured_image = basename($path);
    }

    $post->save();

    return response()->json([
        'success' => true,
        'message' => 'Konten berhasil dipublikasikan',
        'data' => [
            'id' => $post->id,
            'title' => $post->title,
            'url' => url('/posts/' . $post->slug),
            'slug' => $post->slug,
        ],
    ]);
})->name('api.autopost');
ROUTE;

$c = rtrim($c) . "\n" . $newRoute . "\n";
file_put_contents($f, $c);
echo "OK: /api/autopost route added.\n";
