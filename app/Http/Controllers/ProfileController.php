<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Show user profile.
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Show edit profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update user profile (name, email, phone, department, bio).
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'department' => $request->department,
            'bio' => $request->bio,
        ]);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Upload/change profile photo.
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Hapus foto lama jika ada
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Simpan foto baru
        $file = $request->file('profile_photo');
        $filename = 'profiles/' . $user->id . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('profiles', basename($filename), 'public');

        // Update user profile_photo
        $user->update(['profile_photo' => 'profiles/' . basename($filename)]);

        return redirect()->route('profile.show')->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Get profile photo URL.
     */
    public function getPhotoUrl()
    {
        $user = Auth::user();
        if ($user->profile_photo) {
            return asset('storage/' . $user->profile_photo);
        }
        return asset('img/default-avatar.png'); // Default avatar jika tidak ada foto
    }
}
