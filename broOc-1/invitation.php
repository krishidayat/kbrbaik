<?php

// Invitation — undangan join studio/komunitas klasis
Route::get('/kredensi/undangan/{token}', function (string $token) {
    $invitation = App\Models\Invitation::where('token', $token)
        ->where('status', 'pending')
        ->where(function ($q) { $q->whereNull('expires_at')->orWhere('expires_at', '>', now()); })
        ->first();

    if (!$invitation) {
        return redirect()->route('kredensi')->with('error', 'Undangan tidak valid atau sudah kadaluwarsa.');
    }

    return view('kredensi-undangan', [
        'invitation' => $invitation,
        'inviter' => $invitation->inviter,
        'community' => $invitation->community,
        'studio' => $invitation->studio,
    ]);
})->name('kredensi.undangan');

Route::post('/kredensi/undangan/{token}/terima', function (Illuminate\Http\Request $request, string $token) {
    $invitation = App\Models\Invitation::where('token', $token)
        ->where('status', 'pending')
        ->where(function ($q) { $q->whereNull('expires_at')->orWhere('expires_at', '>', now()); })
        ->firstOrFail();

    if (auth()->check()) {
        $user = auth()->user();
    } else {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);
        $user = App\Models\User::create([
            'name' => $validated['name'],
            'email' => $invitation->email,
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'] ?? null,
        ]);
        auth()->login($user);
    }

    $user->role = $invitation->role;
    $user->studio_id = $invitation->studio_id;
    $user->save();

    App\Models\CommunityMember::updateOrCreate(
        ['user_id' => $user->id, 'community_id' => $invitation->community_id],
        ['role' => $invitation->role, 'status' => 'approved', 'joined_at' => now()]
    );

    $invitation->status = 'accepted';
    $invitation->save();

    return redirect()->route('kredensi.tulis')->with('success', 'Selamat datang di ' . $invitation->community->name . '!');
})->name('kredensi.undangan.terima');


// Buat undangan baru
Route::post('/kredensi/undangan/buat', function (Illuminate\Http\Request $request) {
    if (!auth()->check()) {
        return redirect()->route('kredensi');
    }

    $user = auth()->user();
    $station = request('station');

    // Hanya pengelola/manajer/administrator yang bisa mengundang
    if (!in_array($user->role, ['administrator', 'pengelola', 'manajer'])) {
        return back()->with('error', 'Anda tidak berhak membuat undangan.');
    }

    $validated = $request->validate([
        'email' => 'required|email',
        'community_id' => 'required|exists:communities,id',
        'studio_id' => 'nullable|exists:studios,id',
        'role' => 'required|in:anggota,pengelola',
        'message' => 'nullable|string|max:500',
    ]);

    // Cek apakah email sudah pernah diundang
    $existing = App\Models\Invitation::where('email', $validated['email'])
        ->where('community_id', $validated['community_id'])
        ->where('status', 'pending')
        ->first();

    if ($existing) {
        return back()->with('error', 'Email ini sudah memiliki undangan pending untuk komunitas ini.');
    }

    $invitation = App\Models\Invitation::create([
        'token' => Illuminate\Support\Str::random(40),
        'email' => $validated['email'],
        'community_id' => $validated['community_id'],
        'studio_id' => $validated['studio_id'] ?? null,
        'role' => $validated['role'],
        'invited_by' => $user->id,
        'message' => $validated['message'] ?? null,
        'status' => 'pending',
        'expires_at' => now()->addDays(7),
    ]);

    $link = url('/kredensi/undangan/' . $invitation->token);

    return back()->with('success', 'Undangan berhasil dibuat! Bagikan link ini:')
        ->with('invitation_link', $link);
})->name('kredensi.undangan.buat');
