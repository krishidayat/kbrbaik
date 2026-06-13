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
