<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasController extends Controller
{
    public function index()
    {
        $transactions = \App\Models\KasTransaction::with('student.user')->paginate(15);
        $unpaidCount = \App\Models\KasTransaction::where('status', 'unpaid')->count();
        $totalCollected = \App\Models\KasTransaction::where('status', 'paid')->sum('amount');
        $mostWanted = \App\Models\KasTransaction::with('student.user')
            ->where('status', 'unpaid')
            ->selectRaw('student_id, count(*) as unpaid_weeks')
            ->groupBy('student_id')
            ->orderByDesc('unpaid_weeks')
            ->limit(3)
            ->get();

        return view('kas.index', compact('transactions', 'unpaidCount', 'totalCollected', 'mostWanted'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $studentId = $request->student_id;
        
        // Auto-fill student_id if user is murid
        if (auth()->user()->hasRole('murid')) {
            $student = \App\Models\Student::where('user_id', auth()->id())->first();
            if ($student) {
                $studentId = $student->id;
            }
        }

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount'     => 'required|numeric|min:5000',
            'method'     => 'required|in:qris,gopay,ovo,dana,shopeepay,bca,mandiri,bni,transfer,cash',
            'week'       => 'nullable|string',
        ]);

        \App\Models\KasTransaction::create([
            'student_id' => $studentId,
            'amount'     => $request->amount,
            'method'     => $request->method,
            'week'       => $request->week,
            'status'     => 'unpaid', // Start as unpaid, admin/bendahara confirms later
        ]);

        return back()->with('success', 'Pembayaran kas berhasil dicatat. Menunggu konfirmasi.');
    }

    public function pay(\Illuminate\Http\Request $request)
    {
        return $this->store($request);
    }
}
