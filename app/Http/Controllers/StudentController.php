<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = \App\Models\Student::with('user')->paginate(15);
        return view('students.index', compact('students'));
    }

    public function show($id)
    {
        $student = \App\Models\Student::with('user')->findOrFail($id);
        return view('students.show', compact('student'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        return back()->with('success', 'Fitur pembuatan siswa belum diaktifkan.');
    }

    public function edit($id)
    {
        $student = \App\Models\Student::with('user')->findOrFail($id);
        return view('students.edit', compact('student'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        return back()->with('success', 'Fitur pembaruan siswa belum diaktifkan.');
    }

    public function destroy($id)
    {
        return back()->with('success', 'Fitur penghapusan siswa belum diaktifkan.');
    }
}
