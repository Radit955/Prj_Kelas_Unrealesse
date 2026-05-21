<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = \App\Models\Teacher::with('user')->paginate(15);
        return view('teachers.index', compact('teachers'));
    }

    public function show($id)
    {
        $teacher = \App\Models\Teacher::with('user')->findOrFail($id);
        return view('teachers.show', compact('teacher'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        return back()->with('success', 'Fitur pembuatan guru belum diaktifkan.');
    }

    public function edit($id)
    {
        $teacher = \App\Models\Teacher::with('user')->findOrFail($id);
        return view('teachers.edit', compact('teacher'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        return back()->with('success', 'Fitur pembaruan guru belum diaktifkan.');
    }

    public function destroy($id)
    {
        return back()->with('success', 'Fitur penghapusan guru belum diaktifkan.');
    }
}
