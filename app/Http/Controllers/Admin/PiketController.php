<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PiketAssignment;
use App\Models\Student;
use Illuminate\Http\Request;

class PiketController extends Controller
{
    public function index()
    {
        $days = ['SENIN','SELASA','RABU','KAMIS','JUMAT'];
        $pikets = PiketAssignment::with('student.user')
            ->orderBy('date')
            ->get()
            ->groupBy(fn($p) => strtoupper(\Carbon\Carbon::parse($p->date)->locale('id')->isoFormat('dddd')));

        $students = Student::with('user')->get();

        return view('admin.piket.index', compact('pikets', 'days', 'students'));
    }

    public function create()
    {
        $students = Student::with('user')->get();
        return view('admin.placeholder', [
            'title' => 'Piket Assignments',
            'action' => 'Create',
            'students' => $students,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date'       => 'required|date',
            'status'     => 'required|in:hadir,terlambat,alpha',
        ]);

        PiketAssignment::updateOrCreate([
            'student_id' => $request->student_id,
            'date'       => $request->date,
        ], [
            'status' => $request->status,
        ]);

        return back()->with('success', 'Jadwal piket berhasil disimpan.');
    }

    public function show($id)
    {
        $assignment = PiketAssignment::with('student.user')->findOrFail($id);
        return view('admin.placeholder', [
            'title' => 'Piket Assignments',
            'action' => 'Show',
            'item' => $assignment,
        ]);
    }

    public function edit($id)
    {
        $assignment = PiketAssignment::findOrFail($id);
        return view('admin.placeholder', [
            'title' => 'Piket Assignments',
            'action' => 'Edit',
            'item' => $assignment,
        ]);
    }

    public function update(Request $request, $id)
    {
        $piket = PiketAssignment::findOrFail($id);
        $request->validate(['status' => 'required|in:hadir,terlambat,alpha']);
        $piket->update(['status' => $request->status]);
        return back()->with('success', 'Status piket diperbarui.');
    }

    public function destroy($id)
    {
        PiketAssignment::findOrFail($id)->delete();
        return back()->with('success', 'Jadwal piket dihapus.');
    }
}
