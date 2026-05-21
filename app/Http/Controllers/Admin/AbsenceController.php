<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\AbsenceSetting;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index()
    {
        $absences = Absence::with('student.user')->latest()->paginate(15);
        return view('admin.absences.index', compact('absences'));
    }

    public function create()
    {
        return view('admin.placeholder', [
            'title' => 'Absences',
            'action' => 'Create',
        ]);
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.absences.index')->with('warning', 'Fitur pembuatan absensi belum tersedia.');
    }

    public function show(Absence $absence)
    {
        $absence->load('student.user');
        return view('admin.absences.show', compact('absence'));
    }

    public function settings()
    {
        $setting = AbsenceSetting::current();
        return view('admin.absences.settings', compact('setting'));
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'max_izin_days'   => 'required|integer|min:1|max:365',
            'sakit_unlimited' => 'nullable|boolean',
        ]);

        $setting = AbsenceSetting::current();
        $setting->update([
            'max_izin_days'   => $request->max_izin_days,
            'sakit_unlimited' => $request->boolean('sakit_unlimited'),
        ]);

        return redirect()->route('admin.absences.settings')->with('success', 'Pengaturan disimpan.');
    }

    public function edit($id)
    {
        $absence = Absence::findOrFail($id);
        return view('admin.placeholder', [
            'title' => 'Absences',
            'action' => 'Edit',
            'item' => $absence,
        ]);
    }

    public function update(Request $request, Absence $absence)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $absence->update(['status' => $request->status]);
        return redirect()->route('admin.absences.index')->with('success', 'Status absensi diperbarui.');
    }

    public function approve($id)
    {
        $absence = Absence::findOrFail($id);
        $absence->update(['status' => 'approved']);
        return redirect()->route('admin.absences.index')->with('success', 'Absensi disetujui.');
    }

    public function reject($id)
    {
        $absence = Absence::findOrFail($id);
        $absence->update(['status' => 'rejected']);
        return redirect()->route('admin.absences.index')->with('success', 'Absensi ditolak.');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.absences.index')->with('warning', 'Fitur penghapusan absensi belum tersedia.');
    }
}
