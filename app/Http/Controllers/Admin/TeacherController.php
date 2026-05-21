<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->paginate(15);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('teacher')->get();
        return view('admin.teachers.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:teachers,user_id',
            'nip'     => 'nullable|string|max:50|unique:teachers,nip',
            'subject' => 'required|string|max:255',
        ]);

        Teacher::create($request->only('user_id','nip','subject'));

        return redirect()->route('admin.teachers.index')->with('success','Data guru berhasil ditambahkan.');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load('user');
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('user');
        $users = User::whereDoesntHave('teacher')->orWhere('id', $teacher->user_id)->get();
        return view('admin.teachers.edit', compact('teacher','users'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:teachers,user_id,'.$teacher->id,
            'nip'     => 'nullable|string|max:50|unique:teachers,nip,'.$teacher->id,
            'subject' => 'required|string|max:255',
        ]);

        $teacher->update($request->only('user_id','nip','subject'));

        return redirect()->route('admin.teachers.index')->with('success','Data guru diperbarui.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('admin.teachers.index')->with('success','Data guru dihapus.');
    }
}
