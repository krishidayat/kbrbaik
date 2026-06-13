// Pojok — dashboard komunitas/kelola radio
Route::domain('pojok.kbrbaik.live')->group(function () {
    Route::get('/', function () {
        $station = null;
        $userStudio = null;
        $userCommunity = null;

        if (auth()->check()) {
            $user = auth()->user();
            $userStudio = $user->studio;
            if ($userStudio) {
                $userCommunity = $userStudio->community;
                if ($userCommunity) {
                    $station = \App\Models\Station::where('slug', $userCommunity->slug)->first();
                }
            }
        }

        return view('pojok-dashboard', compact('station', 'userStudio', 'userCommunity'));
    })->name('pojok.dashboard');
});
