
// POJOK DASHBOARD
use App\Http\Controllers\PojokController;

Route::domain('pojok.kbrbaik.live')->group(function () {
    Route::get('/', [PojokController::class, 'dashboard'])->middleware(['auth'])->name('pojok.dashboard');
    Route::get('/playlist/{period}', [PojokController::class, 'playlist'])->name('pojok.playlist');
    Route::get('/webcast', [PojokController::class, 'webcastRelays'])->name('pojok.webcast');

    Route::get('/liquidsoap', function () {
        $station = request('station');
        return view('pojok.config', compact('station'));
    })->name('pojok.liquidsoap');
    Route::get('/liquidsoap/config', [PojokController::class, 'generateLiquidsoap'])->name('pojok.liquidsoap.json');
    Route::get('/liquidsoap/download', function () {
        $station = request('station');
        $c = app(PojokController::class);
        return $c->generateLiquidsoap($station->id);
    })->name('pojok.liquidsoap.download');

    Route::get('/now-playing', [PojokController::class, 'apiNowPlaying'])->name('pojok.nowplaying');

    Route::post('/playlist/{period}/create', [PojokController::class, 'createItem'])->name('pojok.item.create');
    Route::post('/playlist/{period}/reorder', [PojokController::class, 'reorder'])->name('pojok.reorder');
    Route::put('/item/{id}', [PojokController::class, 'updateItem'])->name('pojok.item.update');
    Route::delete('/item/{id}', [PojokController::class, 'deleteItem'])->name('pojok.item.delete');
    Route::post('/item/{id}/toggle', [PojokController::class, 'toggleActive'])->name('pojok.item.toggle');
    Route::post('/rss-import', [PojokController::class, 'importRss'])->name('pojok.rss.import');
});

Route::domain('pojok.kbrbaik.live')->get('/public/{period}', function ($period) {
    $station = request('station');
    $playlist = App\Models\Playlist::where('station_id', $station->id)
        ->where('period', $period)->firstOrFail();
    $items = $playlist->activeItems()->get();
    $periodIcons = ['subuh'=>'🌅','pagi'=>'☀️','siang'=>'🌤️','sore'=>'🌆','malam'=>'🌙'];
    return view('pojok.public', compact('station', 'playlist', 'items', 'periodIcons'));
})->name('pojok.public');
