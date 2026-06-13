
// POJOK DASHBOARD
use App\Http\Controllers\PojokController;

Route::domain('pojok.kbrbaik.live')->group(function () {
    Route::get('/', [PojokController::class, 'dashboard'])->name('pojok.dashboard');
    Route::get('/playlist/{period}', [PojokController::class, 'playlist'])->name('pojok.playlist');
    Route::get('/webcast', [PojokController::class, 'webcastRelays'])->name('pojok.webcast');

    Route::get('/liquidsoap', function () {
        $_station = request('station');
        return view('pojok.config', ['station' => $_station]);
    })->name('pojok.liquidsoap');
    Route::get('/liquidsoap/config', [PojokController::class, 'generateLiquidsoap'])->name('pojok.liquidsoap.json');
    Route::get('/liquidsoap/download', function () {
        $_station = request('station');
        $_c = app(PojokController::class);
        return $_c->generateLiquidsoap($_station->id);
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
    $_station = request('station');
    $_playlist = App\Models\Playlist::where('station_id', $_station->id)
        ->where('period', $period)->firstOrFail();
    $_items = $_playlist->activeItems()->get();
    $_periodIcons = ['subuh'=>'🌅','pagi'=>'☀️','siang'=>'🌤️','sore'=>'🌆','malam'=>'🌙'];
    return view('pojok.public', compact('_station', '_playlist', '_items', '_periodIcons'));
})->name('pojok.public');
