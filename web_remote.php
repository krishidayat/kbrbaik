<?php

use App\Helpers\CalendarHelper;
use App\Models\Category;
use App\Models\Event;
use App\Models\Post;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;


Route::get('/posts', function () {
    $station = request('station');

    $posts = $station?->posts()->where('is_published', true)->whereHas('category', fn($q) => $q->where('group', 'suara'))->latest()->paginate(12);
    $categories = $station?->categories()->where("group", "suara")->orderBy("order_column")->get();
    return view('suara.posts', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts','categories'));
})->name('posts');

Route::get('/blog', function () {
    $station = request('station');
    $posts = $station?->posts()->where('is_published', true)->whereHas('category', fn($q) => $q->where('group', 'kbrbaik'))->latest()->paginate(12);
    $categories = $station?->categories()->where("group", "kbrbaik")->get();
    return view('kbrbaik-blog', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'posts', 'categories'));
})->name('kbrbaik.blog');

Route::get('/posts/{slug}', function ($slug) {
    $station = request('station');
    $post = Post::where('slug', $slug)
        ->where('station_id', $station?->id)
        ->where('is_published', true)
        ->firstOrFail();
    $view = $station && $station->slug === 'kbrbaik' ? 'kbrbaik-post' : 'suara.post';
    return view($view, compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'post'));
})->name('post');

Route::get('/category/{slug}', function ($slug) {
    $station = request('station');
    $category = Category::where('slug', $slug)
        ->where('station_id', $station?->id)
        ->firstOrFail();
    $posts = $category->posts()
        ->where('station_id', $station?->id)
        ->where('is_published', true)
        ->latest()
        ->paginate(12);
    return view('suara.category', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'category', 'posts'));
})->name('category');


Route::get('/podcasts.rss', function () {
    $station = request('station');
    $episodes = $station?->episodes()->where('is_published', true)->latest()->get();

    return response()->view('rss', [
        'station' => $station,
        'episodes' => $episodes,
    ], 200, [
        'Content-Type' => 'application/rss+xml; charset=utf-8',
    ]);
})->name('rss');

Route::get('/musik', function () {
    $station = request('station');
    $items = $station->playlistItems()->where('is_active', true)->orderBy('sort_order')->get();
    $categories = $station->categories()->get();
    return view('musik', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'items', 'categories'));
})->name('musik');

Route::post('/musik/upload', function (\Illuminate\Http\Request $req) {
    $station = request('station');
    if (!auth()->check()) {
        return redirect('/login')->with('error', 'Silakan login dulu untuk upload');
    }

    $data = $req->validate([
        'title' => 'required|string|max:255',
        'artist' => 'nullable|string|max:255',
        'audio_file' => 'required|file|mimes:mp3,wav,ogg|max:102400',
    ], [
        'audio_file.required' => 'Pilih file audio terlebih dahulu',
        'audio_file.file' => 'File gagal diupload. Cek ukuran file (max 100MB)',
        'audio_file.mimes' => 'Format file harus MP3, WAV, atau OGG',
        'audio_file.max' => 'Ukuran file maksimal 100MB',
    ]);

    $path = $req->file('audio_file')->store('audio', 'public');

    \App\Models\PlaylistItem::create([
        'station_id' => $station?->id,
        'title' => $data['title'],
        'artist' => $data['artist'] ?? '',
        'audio_file' => $path,
        'is_active' => true,
        'sort_order' => 0,
    ]);

    return redirect('/musik')->with('success', 'Lagu berhasil diupload!');
})->name('musik.upload');


Route::get('/agenda', function () {
    $station = request('station');
    $events = $station?->events()->where("is_published", true)->orderBy("event_date", "desc")->paginate(12);
    $types = collect();
    if ($station && $station->slug === 'kbrbaik') {
        return view('kbrbaik-agenda', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'events', 'types'));
    }
    return view('kbrbaik-agenda', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'events', 'types'));
})->name('agenda');

Route::get('/komunitas', function () {
    $station = request('station');
    $communities = \App\Models\Community::where('station_id', $station?->id)->where('is_active', true)->get();
    if ($station && $station->slug === 'kbrbaik') {
        return view('kbrbaik-komunitas', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'communities'));
    }
    return view('kbrbaik-komunitas', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'communities'));
})->name('komunitas');

Route::get('/komunitas/{slug}', function ($slug) {
    $station = request('station');
    $community = \App\Models\Community::where('slug', $slug)->where('station_id', $station?->id)->firstOrFail();
    $studios = $community->studios()->where('is_active', true)->get();
    $communities = AppModelsCommunity::where("station_id", $station?->id ?? 1)->where("is_active", true)->get();
    $invitations = AppModelsInvitation::where("invited_by", auth()->id())->latest()->take(20)->get();
    if ($station && $station->slug === 'kbrbaik') {
        return view('kbrbaik-komunitas-show', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'community', 'studios'));
    }
    return view('kbrbaik-komunitas-show', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'community', 'studios'));
})->name('komunitas.show');



Route::get('/studio', function () {
    $station = request('station');
    if ($station && $station->slug === 'kbrbaik') {
        return view('kbrbaik-studio', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion'));
    }
    return view('kbrbaik-studio', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion'));
})->name('studio');
Route::get('/layanan', function () {
    $station = request('station');
    if ($station && $station->slug === 'kbrbaik') {
        return view('kbrbaik-services', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion'));
    }
    return view('services', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion'));
})->name('services');

Route::get('/pelatihan', function () {
    $station = request('station');
    if ($station && $station->slug === 'kbrbaik') {
        return view('kbrbaik-pelatihan', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion'));
    }
    return view('pelatihan', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion'));
})->name('pelatihan');

Route::get('/media', function () {
    $station = request('station');
    $items = $station?->playlistItems()->where('is_active', true)->orderBy('sort_order')->get();
    if ($station && $station->slug === 'kbrbaik') {
        return view('kbrbaik-radio', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'items'));
    }
    return view('radio', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'items'));
})->name('media');


Route::get('/studio/{slug}', function ($slug) {
    $station = request('station');
    $studio = \App\Models\Studio::where('slug', $slug)->where('station_id', $station?->id ?? 1)->where('is_active', true)->with('community')->firstOrFail();
    $studioPosts = \App\Models\Post::where('studio_id', $studio->id)->where('is_published', true)->latest()->get();
    $episodes = $studio->episodes()->where('is_published', true)->latest()->take(10)->get();
    $galleries = AppModelsGalleryItem::where('studio_id', $studio->id)->where('is_active', true)->latest()->get();
    return view('kbrbaik-studio-show', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'studio', 'studioPosts', 'episodes', 'galleries'));
})->name('studio.show');
Route::get('/galeri', function () {
    $station = request('station');
    $items = \App\Models\GalleryItem::where('station_id', $station?->id)->where('is_active', true)->latest()->get();
    $episodes = \App\Models\Episode::where('station_id', $station?->id)->where('is_published', true)->latest()->take(20)->get();
    $studios = \App\Models\Studio::where('station_id', $station?->id)->get();
    $communities = AppModelsCommunity::where("station_id", $station?->id ?? 1)->where("is_active", true)->get();
    $invitations = AppModelsInvitation::where("invited_by", auth()->id())->latest()->take(20)->get();
    if ($station && $station->slug === 'kbrbaik') {
        return view('kbrbaik-galeri', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'items', 'episodes', 'studios'));
    }
    return view('galeri', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'items', 'episodes', 'studios'));
})->name('galeri');

Route::post('/galeri/upload', [App\Http\Controllers\GalleryItemController::class, 'upload'])->middleware('auth')->name('galeri.upload');
Route::post('/galeri/unsplash', [App\Http\Controllers\GalleryItemController::class, 'importUnsplash'])->middleware('auth')->name('galeri.unsplash');
Route::put('/galeri/{item}', [App\Http\Controllers\GalleryItemController::class, 'update'])->middleware('auth')->name('galeri.update');
Route::delete('/galeri/{item}', [App\Http\Controllers\GalleryItemController::class, 'destroy'])->middleware('auth')->name('galeri.destroy');

Route::get('/musik/{item}/play', function (\App\Models\PlaylistItem $item) {
    $station = request('station');
    if ($item->station_id !== $station?->id) abort(404);
    return response()->json($item);
})->name('musik.play');
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

Route::get('/', function () {
    $station = request('station');
    if ($station && $station->slug === 'pojok') {
        return view('pojok', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion'));
    }
    $schedules = $station?->schedules()->where('is_active', true)->get();
    $episodes = $station?->episodes()->where('is_published', true)->latest()->take(5)->get();
    $latestPosts = $station?->posts()->where('is_published', true)->latest()->take(4)->get();
    return view('home', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'schedules', 'episodes', 'latestPosts'));
})->name('home');


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
    $communities = AppModelsCommunity::where("station_id", $station?->id ?? 1)->where("is_active", true)->get();
    $invitations = AppModelsInvitation::where("invited_by", auth()->id())->latest()->take(20)->get();
    $posts = \App\Models\Post::where('author', auth()->user()->name)->orWhere('created_by', auth()->id())->latest()->take(10)->get();
    return view('kredensi-dashboard', compact('station', 'categories', 'studios', 'communities', 'invitations', 'posts'','categories','studios','communities','invitations','posts'ion', 'categories', 'studios', 'posts'));
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
        'image' => 'nullable|image|max:5120',
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
    if ($request->hasFile('image')) {
        $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
        $filename = md5(microtime()) . '.jpg';
        $img = $manager->decodePath($request->file('image')->getRealPath());
        $img->resizeDown(1920, 1920);
        \Illuminate\Support\Facades\Storage::disk('public')->put(
            'featured/' . $filename,
            $img->encode(new \Intervention\Image\Encoders\JpegEncoder(85))->toString()
        );
        $post->featured_image = 'featured/' . $filename;
    }
    $post->is_published = true;
    $post->published_at = now();
    $post->save();
    return redirect()->route('kredensi.tulis')->with('success', 'Narasi berhasil dipublikasikan!');
})->name('kredensi.post.store');

require __DIR__.'/invitation.php';
