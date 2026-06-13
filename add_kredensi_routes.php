<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

$routes = <<<'PHP'

// Kredensi — login anggota studio
Route::get('/kredensi', function () {
    if (auth()->check()) {
        return redirect()->route('kredensi.tulis');
    }
    return view('kredensi-login', ['station' => request('station')]);
})->name('kredensi');

Route::post('/kredensi/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    if (auth()->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('kredensi.tulis');
    }
    return back()->with('error', 'Email atau password salah.');
})->name('kredensi.login');

Route::post('/kredensi/logout', function (Illuminate\Http\Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('kredensi');
})->name('kredensi.logout');

Route::get('/kredensi/tulis', function () {
    if (!auth()->check()) {
        return redirect()->route('kredensi');
    }
    $station = request('station');
    $categories = \App\Models\Category::where('station_id', $station?->id ?? 1)->where('group', 'kbrbaik')->get();
    $studios = \App\Models\Studio::where('station_id', $station?->id ?? 1)->where('is_active', true)->get();
    $posts = \App\Models\Post::where('author', auth()->user()->name)->orWhere('created_by', auth()->id())->latest()->take(10)->get();
    return view('kredensi-dashboard', compact('station', 'categories', 'studios', 'posts'));
})->name('kredensi.tulis');

Route::post('/kredensi/post/store', function (Illuminate\Http\Request $request) {
    if (!auth()->check()) {
        return redirect()->route('kredensi');
    }
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'lead' => 'nullable|string|max:500',
        'category_id' => 'nullable|exists:categories,id',
        'studio_id' => 'nullable|exists:studios,id',
    ]);
    $station = request('station');
    $post = new \App\Models\Post();
    $post->station_id = $station?->id ?? 1;
    $post->title = $validated['title'];
    $post->slug = \Illuminate\Support\Str::slug($validated['title']) . '-' . substr(md5(microtime()), 0, 6);
    $post->body = $validated['body'];
    $post->lead = $validated['lead'] ?? null;
    $post->category_id = $validated['category_id'] ?? null;
    $post->studio_id = $validated['studio_id'] ?? null;
    $post->author = auth()->user()->name;
    $post->type = 'article';
    $post->body_format = 'markdown';
    $post->is_published = true;
    $post->published_at = now();
    $post->save();
    return redirect()->route('kredensi.tulis')->with('success', 'Narasi berhasil dipublikasikan!');
})->name('kredensi.post.store');
PHP;

$c .= $routes;
file_put_contents($f, $c);
echo "OK\n";
