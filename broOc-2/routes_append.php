
// ═══════════════════════════════════════════════════
// POJOK DASHBOARD — Community Radio Station Manager
// Domain: pojok.kbrbaik.live
// ═══════════════════════════════════════════════════
use App\Http\Controllers\PojokController;

Route::domain('pojok.kbrbaik.live')->middleware(['auth'])->group(function () {
    $con = PojokController::class;

    Route::get('/', [$con, 'dashboard'])->name('pojok.dashboard');
    Route::get('/playlist/{period}', [$con, 'playlist'])->name('pojok.playlist');
    Route::post('/playlist/{period}/create', [$con, 'createItem'])->name('pojok.item.create');
    Route::post('/playlist/{period}/reorder', [$con, 'reorder'])->name('pojok.reorder');

    Route::put('/item/{id}', [$con, 'updateItem'])->name('pojok.item.update');
    Route::delete('/item/{id}', [$con, 'deleteItem'])->name('pojok.item.delete');
    Route::post('/item/{id}/toggle', [$con, 'toggleActive'])->name('pojok.item.toggle');

    Route::post('/rss-import', [$con, 'importRss'])->name('pojok.rss.import');

    Route::get('/webcast', [$con, 'webcastRelays'])->name('pojok.webcast');

    Route::get('/liquidsoap', function () {
        $station = request('station');
        return view('pojok.config', compact('station'));
    })->name('pojok.liquidsoap');

    Route::get('/liquidsoap/config', [$con, 'generateLiquidsoap'])->name('pojok.liquidsoap.json');
    Route::get('/liquidsoap/download', function () use ($con) {
        $station = request('station');
        $controller = app($con);
        return $controller->generateLiquidsoap($station->id);
    })->name('pojok.liquidsoap.download');

    Route::get('/now-playing', [$con, 'apiNowPlaying'])->name('pojok.nowplaying');
});

// Public playlist page (no auth)
Route::domain('pojok.kbrbaik.live')->get('/public/{period}', function ($period) {
    $station = request('station');
    $playlist = App\Models\Playlist::where('station_id', $station->id)
        ->where('period', $period)->firstOrFail();
    $items = $playlist->activeItems()->get();
    $periodIcons = ['subuh'=>'🌅','pagi'=>'☀️','siang'=>'🌤️','sore'=>'🌆','malam'=>'🌙'];
    return view('pojok.public', compact('station', 'playlist', 'items', 'periodIcons'));
})->name('pojok.public');
