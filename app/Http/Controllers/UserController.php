<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'gender' => 'required|in:male,female,prefer not to say',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
        ]);

        // Handle upload gambar profil
        if ($request->hasFile('profile_picture')) {
            // Hapus gambar lama jika bukan default
            if ($user->profile_picture && $user->profile_picture != 'images/profile/default.png') {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_picture);
            }
            // Simpan gambar baru
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        // Perbarui data pengguna
        $user->name = $validated['name'];
        $user->phone_number = $validated['phone_number'];
        $user->gender = $validated['gender'];
        $user->save();

        return redirect()->route('account')->with('success', 'Profile updated successfully!');
    }
}
