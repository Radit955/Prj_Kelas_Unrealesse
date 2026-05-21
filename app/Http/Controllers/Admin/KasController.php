<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KasTransaction;
use App\Models\Student;
use Illuminate\Http\Request;

class KasController extends Controller
{
    public function index()
    {
        $kasTransactions = KasTransaction::with('student.user')->latest()->paginate(20);
        $totalPaid = KasTransaction::where('status','paid')->sum('amount');
        $totalUnpaid = KasTransaction::where('status','unpaid')->sum('amount');

        return view('admin.kas.index', compact('kasTransactions','totalPaid','totalUnpaid'));
    }

    public function create()
    {
        $students = Student::with('user')->get();
        return view('admin.kas.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount'     => 'required|numeric|min:1',
            'method'     => 'required|in:qris,cash',
            'week'       => 'required|integer|min:1',
            'status'     => 'required|in:paid,unpaid',
        ]);

        $data = $request->only('student_id','amount','method','week','status');
        $data['paid_at'] = $request->status === 'paid' ? now() : null;
        KasTransaction::create($data);

        return redirect()->route('admin.kas.index')->with('success','Transaksi kas berhasil dicatat.');
    }

    public function edit(KasTransaction $kas)
    {
        $students = Student::with('user')->get();
        return view('admin.kas.edit', compact('kas','students'));
    }

    public function update(Request $request, KasTransaction $kas)
    {
        if ($request->has('status') && !$request->hasAny(['student_id', 'amount', 'method', 'week'])) {
            $request->validate([
                'status' => 'required|in:paid,unpaid',
            ]);

            $kas->status = $request->status;
            $kas->paid_at = $request->status === 'paid' ? ($kas->paid_at ?? now()) : null;
            $kas->save();

            return redirect()->route('admin.kas.index')->with('success','Status transaksi berhasil diperbarui.');
        }

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount'     => 'required|numeric|min:1',
            'method'     => 'required|in:qris,cash',
            'week'       => 'required|integer|min:1',
            'status'     => 'required|in:paid,unpaid',
        ]);

        $data = $request->only('student_id','amount','method','week','status');
        $data['paid_at'] = $request->status === 'paid' ? ($kas->paid_at ?? now()) : null;
        $kas->update($data);

        return redirect()->route('admin.kas.index')->with('success','Transaksi diperbarui.');
    }

    public function destroy(KasTransaction $kas)
    {
        $kas->delete();
        return redirect()->route('admin.kas.index')->with('success','Transaksi dihapus.');
    }
}
