<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\SeksiKegiatan;
use Illuminate\Http\Request;

class SeksiController extends Controller
{
    public function index()
    {
        $seksi = SeksiKegiatan::with('ketua.user', 'members.user')->paginate(15);
        return view('admin.seksi.index', compact('seksi'));
    }

    public function create()
    {
        $students = Student::with('user')->get();
        return view('admin.seksi.create', compact('students'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'ketua_id'    => 'nullable|exists:students,id',
            'member_ids'  => 'nullable|array',
            'member_ids.*'=> 'exists:students,id',
        ]);

        $seksi = SeksiKegiatan::create($request->only(['name', 'category', 'description', 'ketua_id']));
        $seksi->members()->sync($request->input('member_ids', []));

        return redirect()->route('admin.seksi.index')->with('success', 'Seksi kegiatan berhasil dibuat.');
    }

    public function show(SeksiKegiatan $seksi)
    {
        $seksi->load('ketua.user', 'members.user');
        return view('admin.seksi.show', compact('seksi'));
    }

    public function edit(SeksiKegiatan $seksi)
    {
        $students = Student::with('user')->get();
        $seksi->load('members');
        return view('admin.seksi.edit', compact('seksi', 'students'));
    }

    public function update(Request $request, SeksiKegiatan $seksi)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'ketua_id'    => 'nullable|exists:students,id',
            'member_ids'  => 'nullable|array',
            'member_ids.*'=> 'exists:students,id',
        ]);

        $seksi->update($request->only(['name', 'category', 'description', 'ketua_id']));
        $seksi->members()->sync($request->input('member_ids', []));

        return redirect()->route('admin.seksi.index')->with('success', 'Seksi kegiatan diperbarui.');
    }

    public function destroy(SeksiKegiatan $seksi)
    {
        $seksi->members()->detach();
        $seksi->delete();

        return redirect()->route('admin.seksi.index')->with('success', 'Seksi kegiatan dihapus.');
    }
}
