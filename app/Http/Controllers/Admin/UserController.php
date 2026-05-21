<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'student.user', 'teacher.user'])->paginate(15);
        return view('admin.placeholder', [
            'title' => 'Users',
            'action' => 'Index',
            'items' => $users,
        ]);
    }

    public function create()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        return view('admin.placeholder', [
            'title' => 'Users',
            'action' => 'Create',
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|exists:roles,name',
            'avatar'   => 'nullable|image|max:2048',
            'phone'    => 'nullable|string|max:20',
            'bio'      => 'nullable|string|max:500',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'bio']);
        $data['password'] = Hash::make($request->password);
        $data['status'] = 'active';

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create($data);
        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $user->load('roles', 'student.user', 'teacher.user');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = \Spatie\Permission\Models\Role::all();
        return view('admin.placeholder', [
            'title' => 'Users',
            'action' => 'Edit',
            'item' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'role'   => 'required|exists:roles,name',
            'avatar' => 'nullable|image|max:2048',
            'phone'  => 'nullable|string|max:20',
            'bio'    => 'nullable|string|max:500',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'bio']);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function suspend(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa suspend akun sendiri.');
        }

        $user->update(['status' => 'suspended']);
        return back()->with('success', 'Akun ' . $user->name . ' telah disuspend.');
    }

    public function unsuspend(User $user)
    {
        $user->update(['status' => 'active', 'timeout_until' => null]);
        return back()->with('success', 'Akun ' . $user->name . ' telah diaktifkan.');
    }

    public function timeout(Request $request, User $user)
    {
        $request->validate(['hours' => 'required|integer|min:1|max:720']);

        $user->update([
            'status'        => 'timeout',
            'timeout_until' => now()->addHours($request->hours),
        ]);

        return back()->with('success', 'Timeout ' . $request->hours . ' jam diterapkan pada ' . $user->name . '.');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.users.index')->with('warning', 'Fitur penghapusan user admin belum tersedia.');
    }
}
