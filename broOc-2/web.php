<?php

use App\Helpers\CalendarHelper;
use App\Models\Category;
use App\Models\Event;
use App\Models\Post;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $station = request('station');

    if ($station && $station->slug === 'suara-pgiw-jabar') {
        $schedules = $station->schedules()->where('is_active', true)->get();
        $episodes = $station->episodes()->where('is_published', true)->latest()->take(5)->get();
        $featuredPosts = $station->posts()->where('is_published', true)->whereDoesntHave('category', fn($q) => $q->where('group', 'media'))->latest()->take(5)->get();
        $upcomingEvents = $station->events()->where('is_published', true)->where('event_date', '>=', now())->orderBy('event_date')->take(3)->get();
        return view('suara.home', compact('station', 'schedules', 'episodes', 'featuredPosts', 'upcomingEvents'));
    }

    if ($station && $station->slug === 'kbrbaik') {
        $heroPosts = $station->posts()->where('is_published', true)->latest()->take(5)->get();
        return view('beranda', compact('station', 'heroPosts'));
    }
    $schedules = $station?->schedules()->where('is_active', true)->get();
    $episodes = $station?->episodes()->where('is_published', true)->latest()->take(5)->get();

    return view('home', compact('station', 'schedules', 'episodes'));
})->name('home');

Route::get('/posts', function () {
    $station = request('station');

    $posts = $station?->posts()->where('is_published', true)->whereHas('category', fn($q) => $q->where('group', 'suara'))->latest()->paginate(12);
    $categories = $station?->categories()->where("group", "suara")->orderBy("order_column")->get();
    return view('suara.posts', compact('station', 'posts', 'categories'));
})->name('posts');

Route::get('/blog', function () {
    $station = request('station');
    $posts = $station?->posts()->where('is_published', true)->whereHas('category', fn($q) => $q->where('group', 'kbrbaik'))->latest()->paginate(12);
    $categories = $station?->categories()->where("group", "kbrbaik")->get();
    return view('kbrbaik-blog', compact('station', 'posts', 'categories'));
})->name('kbrbaik.blog');

Route::get('/posts/{slug}', function ($slug) {
    $station = request('station');
    $post = Post::where('slug', $slug)
        ->where('station_id', $station?->id)
        ->where('is_published', true)
        ->firstOrFail();
    $view = $station && $station->slug === 'kbrbaik' ? 'kbrbaik-post' : 'suara.post';
    return view($view, compact('station', 'post'));
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
    return view('suara.category', compact('station', 'category', 'posts'));
})->name('category');

Route::get('/media', function () {
    $station = request('station');
    $categories = $station?->categories()->where('group', 'media')->get();
    $catIds = $categories->pluck('id');
    $posts = $station?->posts()->whereIn('category_id', $catIds)->where('is_published', true)->latest()->paginate(12);
    return view('suara.media', compact('station', 'categories', 'posts'));
})->name('media');

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
    return view('musik', compact('station', 'items', 'categories'));
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

Route::get('/galeri', function () {
    $station = request('station');
    $items = \App\Models\GalleryItem::where('station_id', $station?->id)->where('is_active', true)->latest()->get();
    return view('galeri', compact('station', 'items'));
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

Route::get('/radio', function () {
    $station = request('station');
    $items = $station->playlistItems()->where('is_active', true)->orderBy('sort_order')->get();
    return view('radio', compact('station', 'items'));
})->name('radio');

Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

Route::middleware('auth')->prefix('studio')->group(function () {
    Route::get('/', function () {
        $station = request('station');
        return view('studio.webdj', compact('station'));
    })->name('studio');

    Route::get('/webdj', function () {
        $station = request('station');
        return view('studio.webdj-full', compact('station'));
    })->name('studio.webdj');

    Route::get('/encoder', function () {
        $station = request('station');
        return view('studio.encoder', compact('station'));
    })->name('studio.encoder');

    Route::get('/player', function () {
        $station = request('station');
        return view('studio.player', compact('station'));
    })->name('studio.player');
});

Route::get('/stream', function () {
    $station = request('station');
    return redirect("http://{$station->stream_mount}");
})->name('stream');


Route::get("/news", function () {
    $station = request("station");
    $posts = $station?->posts()->where("is_published", true)->whereHas("category", fn($q) => $q->where("group", "artikel"))->latest()->paginate(12);
    $categories = $station?->categories()->where("group", "artikel")->get();
    return view("suara.posts", compact("station", "posts", "categories"));
})->name("news");


Route::get('/bidang', function () {
    $station = request('station');
    $parentCategories = $station?->categories()->where('group', 'bidang')->whereNull('parent_id')->get();
    $firstParent = $parentCategories->first();
    $childCategories = $firstParent ? $station?->categories()->where('parent_id', $firstParent->id)->get() : collect();
    $childIds = $childCategories->pluck('id');
    $posts = $childIds->isNotEmpty() ? $station?->posts()->whereIn('category_id', $childIds)->where('is_published', true)->latest()->paginate(12) : collect();
    return view('suara.bidang', compact('station', 'parentCategories', 'childCategories', 'posts'));
})->name('bidang');

Route::get('/agenda', function () {
    $station = request('station');
    $events = $station?->events()
        ->where('is_published', true)
        ->orderBy('event_date', 'desc')
        ->paginate(12);
    $types = $station?->events()
        ->where('is_published', true)
        ->select('type')
        ->distinct()
        ->pluck('type');
    $view = $station && $station->slug === 'kbrbaik' ? 'kbrbaik-agenda' : 'suara.agenda';
    return view($view, compact('station', 'events', 'types'));
})->name('agenda');

Route::get('/agenda/{slug}', function ($slug) {
    $station = request('station');
    $event = Event::where('slug', $slug)->where('station_id', $station?->id)->firstOrFail();
    $view = $station && $station->slug === 'kbrbaik' ? 'kbrbaik-agenda-show' : 'suara.agenda-show';
    return view($view, compact('station', 'event'));
})->name('agenda.show');

Route::get('/struktur', function () {
    $station = request('station');
    return view('suara.struktur', compact('station'));
})->name('struktur');

Route::get('/struktur-pgis', function () {
    $station = request('station');
    return view('suara.struktur-pgis', compact('station'));
})->name('struktur.pgis');

Route::get('/struktur-pouk', function () {
    $station = request('station');
    return view('suara.struktur-pouk', compact('station'));
})->name('struktur.pouk');

Route::get('/struktur-gereja', function () {
    $station = request('station');
    return view('suara.struktur-gereja', compact('station'));
})->name('struktur.gereja');

Route::get('/pgis', function () {
    $station = request('station');
    $categories = $station?->categories()->where('group', 'pgis')->get();
    $selectedSlug = request('category');
    $selectedCategory = $selectedSlug ? $categories->firstWhere('slug', $selectedSlug) : null;
    $posts = $station?->posts()->where('is_published', true);
    if ($selectedCategory) {
        $posts = $posts->where('category_id', $selectedCategory->id);
    } else {
        $catIds = $categories->pluck('id');
        $posts = $posts->whereIn('category_id', $catIds);
    }
    $posts = $posts->latest()->paginate(12);
    return view('suara.pgis', compact('station', 'categories', 'posts', 'selectedCategory'));
})->name('pgis');

Route::get('/pouk', function () {
    $station = request('station');
    $categories = $station?->categories()->where('group', 'pouk')->get();
    $selectedSlug = request('category');
    $selectedCategory = $selectedSlug ? $categories->firstWhere('slug', $selectedSlug) : null;
    $posts = $station?->posts()->where('is_published', true);
    if ($selectedCategory) {
        $posts = $posts->where('category_id', $selectedCategory->id);
    } else {
        $catIds = $categories->pluck('id');
        $posts = $posts->whereIn('category_id', $catIds);
    }
    $posts = $posts->latest()->paginate(12);
    return view('suara.pouk', compact('station', 'categories', 'posts', 'selectedCategory'));
})->name('pouk');

Route::get('/gereja', function () {
    $station = request('station');
    $categories = $station?->categories()->where('group', 'gereja')->get();
    $selectedSlug = request('category');
    $selectedCategory = $selectedSlug ? $categories->firstWhere('slug', $selectedSlug) : null;
    $posts = $station?->posts()->where('is_published', true);
    if ($selectedCategory) {
        $posts = $posts->where('category_id', $selectedCategory->id);
    } else {
        $catIds = $categories->pluck('id');
        $posts = $posts->whereIn('category_id', $catIds);
    }
    $posts = $posts->latest()->paginate(12);
    return view('suara.gereja', compact('station', 'categories', 'posts', 'selectedCategory'));
})->name('gereja');

Route::get('/pgis/{slug}', function ($slug) {
    $station = request('station');
    $item = \App\Models\Category::where('slug', $slug)->where('station_id', $station?->id)->where('group', 'pgis')->firstOrFail();
    $posts = $item->posts()->where('is_published', true)->latest()->paginate(10);
    return view('suara.group-profile', compact('station', 'item', 'posts'));
})->name('pgis.profile');

Route::get('/pouk/{slug}', function ($slug) {
    $station = request('station');
    $item = \App\Models\Category::where('slug', $slug)->where('station_id', $station?->id)->where('group', 'pouk')->firstOrFail();
    $posts = $item->posts()->where('is_published', true)->latest()->paginate(10);
    return view('suara.group-profile', compact('station', 'item', 'posts'));
})->name('pouk.profile');

Route::get('/gereja/{slug}', function ($slug) {
    $station = request('station');
    $item = \App\Models\Category::where('slug', $slug)->where('station_id', $station?->id)->where('group', 'gereja')->firstOrFail();
    $posts = $item->posts()->where('is_published', true)->latest()->paginate(10);
    return view('suara.group-profile', compact('station', 'item', 'posts'));
})->name('gereja.profile');

// Auth routes
Route::get('/daftar', function () {
    $station = request('station');
    return view('daftar', compact('station'));
})->name('daftar');

Route::post('/daftar', function (Illuminate\Http\Request $req) {
    $station = request('station');
    $data = $req->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'nullable|string|max:20',
        'password' => 'required|string|min:6|confirmed',
    ]);
    $user = \App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'] ?? null,
        'password' => bcrypt($data['password']),
    ]);
    auth()->login($user);
    return redirect()->route('home');
})->name('daftar.post');

Route::get('/masuk', function () {
    $station = request('station');
    return view('masuk', compact('station'));
})->name('masuk');

Route::post('/masuk', function (Illuminate\Http\Request $req) {
    $data = $req->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);
    if (auth()->attempt($data, $req->boolean('remember'))) {
        $req->session()->regenerate();
        return redirect()->intended(route('home'));
    }
    return back()->withErrors(['email' => 'Email atau password salah.']);
})->name('masuk.post');

Route::post('/logout', function (Illuminate\Http\Request $req) {
    auth()->logout();
    $req->session()->regenerate();
    return redirect()->route('home');
})->name('logout');

// Profil
Route::middleware('auth')->get('/profil', function () {
    $station = request('station');
    return view('profil', compact('station'));
})->name('profil');

// Komunitas routes
Route::get('/komunitas', function () {
    $station = request('station');
    $communities = \App\Models\Community::where('station_id', $station?->id)
        ->where('is_active', true)
        ->withCount(['approvedMembers', 'projects', 'studios'])
        ->get();
    if ($station && $station->slug === 'kbrbaik') {
        return view('kbrbaik-komunitas', compact('station', 'communities'));
    }
    return view('komunitas', compact('station', 'communities'));
})->name('komunitas');

Route::middleware('auth')->group(function () {
    Route::get('/komunitas/buat', function () {
        $station = request('station');
        return view('komunitas-buat', compact('station'));
    })->name('komunitas.buat');

    Route::post('/komunitas/buat', function (Illuminate\Http\Request $req) {
        $station = request('station');
        $data = $req->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);
        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        $data['created_by'] = auth()->id();
        $data['station_id'] = $station?->id;

        if ($req->hasFile('cover_image')) {
            $data['cover_image'] = $req->file('cover_image')->store('communities', 'public');
        }

        $community = \App\Models\Community::create($data);
        \App\Models\CommunityMember::create([
            'community_id' => $community->id,
            'user_id' => auth()->id(),
            'role' => 'owner',
            'status' => 'approved',
            'joined_at' => now(),
        ]);

        return redirect()->route('komunitas.show', $community->slug);
    })->name('komunitas.store');

    Route::post('/komunitas/{slug}/gabung', function ($slug) {
        $station = request('station');
        $community = \App\Models\Community::where('slug', $slug)->where('station_id', $station?->id)->firstOrFail();
        $existing = \App\Models\CommunityMember::where('community_id', $community->id)->where('user_id', auth()->id())->first();
        if (!$existing) {
            \App\Models\CommunityMember::create([
                'community_id' => $community->id,
                'user_id' => auth()->id(),
                'role' => 'member',
                'status' => 'pending',
            ]);
        }
        return redirect()->route('komunitas.show', $community->slug);
    })->name('komunitas.join');
});

Route::get('/komunitas/{slug}', function ($slug) {
    $station = request('station');
    $community = \App\Models\Community::where('slug', $slug)->where('station_id', $station?->id)
        ->with(['members.user', 'approvedMembers.user', 'projects', 'creator'])
        ->firstOrFail();

    if ($station && $station->slug === 'kbrbaik') {
        $studios = $community->studios()->where('is_active', true)->with('episodes')->get();
        return view('kbrbaik-komunitas-show', compact('station', 'community', 'studios'));
    }

    $isMember = auth()->check() && $community->approvedMembers->where('user_id', auth()->id())->isNotEmpty();
    $isPending = auth()->check() && $community->members->where('user_id', auth()->id())->where('status', 'pending')->isNotEmpty();

    return view('komunitas-show', compact('station', 'community', 'isMember', 'isPending'));
})->name('komunitas.show');

Route::get('/komunitas/{communitySlug}/studio/{studioSlug}', function ($communitySlug, $studioSlug) {
    $station = request('station');
    $community = \App\Models\Community::where('slug', $communitySlug)->where('station_id', $station?->id)->firstOrFail();
    $studio = \App\Models\Studio::where('slug', $studioSlug)->where('community_id', $community->id)->firstOrFail();
    $episodes = $studio->episodes()->where('is_published', true)->latest()->get();
    return view('kbrbaik-studio-show', compact('station', 'community', 'studio', 'episodes'));
})->name('kbrbaik.studio.show');

Route::middleware('auth')->group(function () {
    Route::get('/komunitas/{communitySlug}/proyek/buat', function ($communitySlug) {
        $station = request('station');
        $community = \App\Models\Community::where('slug', $communitySlug)->where('station_id', $station?->id)->firstOrFail();
        return view('komunitas-proyek-buat', compact('station', 'community'));
    })->name('komunitas.proyek.buat');

    Route::post('/komunitas/{communitySlug}/proyek/buat', function (Illuminate\Http\Request $req, $communitySlug) {
        $station = request('station');
        $community = \App\Models\Community::where('slug', $communitySlug)->where('station_id', $station?->id)->firstOrFail();
        $data = $req->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
        ]);
        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        $data['community_id'] = $community->id;
        $data['station_id'] = $station?->id;
        $data['created_by'] = auth()->id();
        $data['status'] = 'active';

        $project = \App\Models\CommunityProject::create($data);
        \App\Models\CommunityProjectMember::create([
            'community_project_id' => $project->id,
            'user_id' => auth()->id(),
            'role' => 'owner',
        ]);
        return redirect()->route('komunitas.proyek.show', [$community->slug, $project->slug]);
    })->name('komunitas.proyek.store');
});

Route::get('/komunitas/{communitySlug}/proyek/{projectSlug}', function ($communitySlug, $projectSlug) {
    $station = request('station');
    $community = \App\Models\Community::where('slug', $communitySlug)->where('station_id', $station?->id)->firstOrFail();
    $project = \App\Models\CommunityProject::where('slug', $projectSlug)->where('community_id', $community->id)->firstOrFail();
    $posts = $project->posts()->where('is_published', true)->latest()->get();
    $episodes = $project->episodes()->where('is_published', true)->latest()->get();
    return view('komunitas-proyek', compact('station', 'community', 'project', 'posts', 'episodes'));
})->name('komunitas.proyek.show');

// DJ Dashboard (auth + role: admin/dj)
Route::middleware(['auth', 'dj'])->prefix('dj')->name('dj.')->group(function () {
    Route::get('/', function () {
         $station = request('station');
        return view('dj.dashboard', compact('station'));
    })->name('dashboard');

    Route::get('/broadcast', function () {
$station = request('station');
        return view('dj.webdj', compact('station'));
    })->name('broadcast');

    Route::get('/cleanfeed', function () {
$station = request('station');
        return view('dj.cleanfeed', compact('station'));
    })->name('cleanfeed');
});

Route::get('/layanan', function () {
    $station = request('station');
    return view('services', compact('station'));
})->name('services');

Route::get('/beranda', function () {
    $station = request('station');
    $heroPosts = $station->posts()->where('is_published', true)->latest()->take(5)->get();
        return view('beranda', compact('station', 'heroPosts'));
})->name('beranda');

// ═══════════════════════════════════════════════════
// POJOK DASHBOARD — Community Radio Station Manager
// Domain: pojok.kbrbaik.live
// ═══════════════════════════════════════════════════
Route::prefix('pojok')->name('pojok.')->middleware(['auth'])->group(function () {
    $con = \App\Http\Controllers\PojokController::class;

    Route::get('/', [$con, 'dashboard'])->name('dashboard');
    Route::get('/playlist/{period}', [$con, 'playlist'])->name('playlist');
    Route::post('/playlist/{period}/create', [$con, 'createItem'])->name('item.create');
    Route::post('/playlist/{period}/reorder', [$con, 'reorder'])->name('reorder');

    Route::put('/item/{id}', [$con, 'updateItem'])->name('item.update');
    Route::delete('/item/{id}', [$con, 'deleteItem'])->name('item.delete');
    Route::post('/item/{id}/toggle', [$con, 'toggleActive'])->name('item.toggle');

    Route::post('/rss-import', [$con, 'importRss'])->name('rss.import');

    Route::get('/webcast', [$con, 'webcastRelays'])->name('webcast');

    Route::get('/liquidsoap', function () {
        $station = request('station');
        return view('pojok.config', compact('station'));
    })->name('liquidsoap');

    Route::get('/liquidsoap/config', [$con, 'generateLiquidsoap'])->name('liquidsoap.json');
    Route::get('/liquidsoap/download', function () use ($con) {
        $station = request('station');
        $controller = app($con);
        return $controller->generateLiquidsoap($station->id);
    })->name('liquidsoap.download');

    Route::get('/now-playing', [$con, 'apiNowPlaying'])->name('nowplaying');
});

// Public playlist page (no auth)
Route::get('/pojok/public/{period}', function ($period) {
    $station = request('station');
    $playlist = \App\Models\Playlist::where('station_id', $station->id)
        ->where('period', $period)->firstOrFail();
    $items = $playlist->activeItems()->get();
    $periodIcons = ['subuh'=>'🌅','pagi'=>'☀️','siang'=>'🌤️','sore'=>'🌆','malam'=>'🌙'];
    return view('pojok.public', compact('station', 'playlist', 'items', 'periodIcons'));
})->name('pojok.public');
