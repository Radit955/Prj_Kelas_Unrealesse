<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index()
    {
        $absences = \App\Models\Absence::with('student.user')
            ->orderByDesc('date')
            ->paginate(15);

        return view('absence.index', compact('absences'));
    }

    public function create()
    {
        $students = \App\Models\Student::with('user')->get();
        return view('absence.create', compact('students'));
    }

    public function store(Request $request)
    {
        $settings = \App\Models\AbsenceSetting::current();

        // Auto get student_id from logged-in user if murid
        $studentId = $request->student_id;
        if (!$studentId && auth()->user()->hasRole('murid')) {
            $student = \App\Models\Student::where('user_id', auth()->id())->first();
            $studentId = $student?->id;
        }

        $rules = [
            'date'             => 'required|date',
            'type'             => 'required|in:izin,sakit',
            'reason'           => 'required|string|max:500',
            'parent_signature' => 'nullable|image|max:2048',
        ];
        if ($request->type === 'izin') {
            $rules['duration_days'] = 'required|integer|min:1|max:' . $settings->max_izin_days;
        }

        $request->validate($rules);

        if (!$studentId) {
            return back()->withErrors(['student_id' => 'Data siswa tidak ditemukan untuk akun ini.']);
        }

        $path = null;
        if ($request->hasFile('parent_signature')) {
            $path = $request->file('parent_signature')->store('signatures', 'public');
        }

        \App\Models\Absence::create([
            'student_id'            => $studentId,
            'date'                  => $request->date,
            'type'                  => $request->type,
            'reason'                => $request->reason . ($request->duration_days ? ' (Durasi: ' . $request->duration_days . ' hari)' : ''),
            'parent_signature_path' => $path,
            'status'                => 'pending',
            'approved_by'           => null,
        ]);

        return back()->with('success', 'Permohonan izin berhasil dikirim. Menunggu konfirmasi wali kelas.');
    }

    public function approve($id)
    {
        $absence = \App\Models\Absence::findOrFail($id);
        $absence->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Izin telah disetujui.');
    }

    public function reject($id)
    {
        $absence = \App\Models\Absence::findOrFail($id);
        $absence->update(['status' => 'rejected']);

        return back()->with('success', 'Izin telah ditolak.');
    }

    public function show($id)
    {
        $absence = \App\Models\Absence::with('student.user')->findOrFail($id);
        return view('absence.show', compact('absence'));
    }

    public function edit($id)
    {
        $absence = \App\Models\Absence::with('student.user')->findOrFail($id);
        return view('absence.edit', compact('absence'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        return back()->with('success', 'Fitur pembaruan izin belum diaktifkan.');
    }

    public function destroy($id)
    {
        return back()->with('success', 'Fitur penghapusan izin belum diaktifkan.');
    }
}
