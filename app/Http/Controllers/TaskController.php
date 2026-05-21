<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = \App\Models\TaskNote::with('creator')
            ->orderByDesc('due_date')
            ->paginate(15);

        return view('tasks.index', compact('tasks'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'title'               => 'required|string|max:255',
            'subject'             => 'required|string|max:100',
            'description'         => 'required|string',
            'due_date'            => 'required|date',
            'from_absent_teacher' => 'boolean',
        ]);

        \App\Models\TaskNote::create([
            'title'               => $request->title,
            'subject'             => $request->subject,
            'description'         => $request->description,
            'due_date'            => $request->due_date,
            'from_absent_teacher' => $request->boolean('from_absent_teacher'),
            'created_by'          => auth()->id(),
        ]);

        return back()->with('success', 'Catatan tugas berhasil ditambahkan.');
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function show($id)
    {
        $task = \App\Models\TaskNote::with('creator')->findOrFail($id);
        return view('tasks.show', compact('task'));
    }

    public function edit($id)
    {
        $task = \App\Models\TaskNote::with('creator')->findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        return back()->with('success', 'Fitur pembaruan tugas belum diaktifkan.');
    }

    public function destroy($id)
    {
        $task = \App\Models\TaskNote::findOrFail($id);
        // Only creator, ketua, wakil, admin, wali can delete
        if (!auth()->user()->hasAnyRole(['admin','wali_kelas','ketua_kelas','wakil_kelas'])
            && $task->created_by !== auth()->id()) {
            abort(403, 'Tidak diizinkan menghapus tugas ini.');
        }
        $task->delete();
        return back()->with('success', 'Catatan tugas berhasil dihapus.');
    }
}
