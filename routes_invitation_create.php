<?php

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
