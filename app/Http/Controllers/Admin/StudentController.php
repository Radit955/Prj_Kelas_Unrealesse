<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->paginate(20);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('student')->get();
        return view('admin.students.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:students,user_id',
            'nis'     => 'required|string|max:20|unique:students,nis',
            'class'   => 'required|string|max:50',
        ]);

        Student::create($request->only('user_id','nis','class'));

        return redirect()->route('admin.students.index')->with('success','Data siswa berhasil ditambahkan.');
    }

    public function show(Student $student)
    {
        $student->load('user');
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $student->load('user');
        $users = User::whereDoesntHave('student')->orWhere('id', $student->user_id)->get();
        return view('admin.students.edit', compact('student','users'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:students,user_id,'.$student->id,
            'nis'     => 'required|string|max:20|unique:students,nis,'.$student->id,
            'class'   => 'required|string|max:50',
        ]);

        $student->update($request->only('user_id','nis','class'));

        return redirect()->route('admin.students.index')->with('success','Data siswa diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success','Data siswa dihapus.');
    }
}
