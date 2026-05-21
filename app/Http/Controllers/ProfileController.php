<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email,' . $user->id,
            'avatar'                => 'nullable|image|max:2048|mimes:jpg,jpeg,png,gif,webp',
            'password'              => 'nullable|min:8|confirmed',
            'phone'                 => 'nullable|string|max:20',
            'bio'                   => 'nullable|string|max:500',
        ], [
            'name.required'  => 'Nama wajib diisi.',
            'email.unique'   => 'Email sudah digunakan akun lain.',
            'avatar.image'   => 'File harus berupa gambar.',
            'avatar.max'     => 'Ukuran foto maksimal 2MB.',
            'password.min'   => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio'   => $request->bio,
        ];

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
