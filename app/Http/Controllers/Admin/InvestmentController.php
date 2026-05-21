<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::paginate(15);
        return view('admin.placeholder', [
            'title' => 'Investments',
            'action' => 'Index',
            'items' => $investments,
        ]);
    }

    public function create()
    {
        return view('admin.placeholder', [
            'title' => 'Investments',
            'action' => 'Create',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'principal'     => 'required|numeric|min:1',
            'rate_percent'  => 'required|numeric|min:0|max:100',
            'start_date'    => 'required|date',
            'maturity_date' => 'required|date|after:start_date',
        ]);

        Investment::create([
            'name'          => $request->name,
            'type'          => 'obligasi',
            'principal'     => $request->principal,
            'rate_percent'  => $request->rate_percent,
            'start_date'    => $request->start_date,
            'maturity_date' => $request->maturity_date,
            'current_value' => $request->principal,
        ]);

        return redirect()->route('admin.investments.index')->with('success', 'Investasi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $investment = Investment::findOrFail($id);
        return view('admin.placeholder', [
            'title' => 'Investments',
            'action' => 'Show',
            'item' => $investment,
        ]);
    }

    public function edit($id)
    {
        $investment = Investment::findOrFail($id);
        return view('admin.placeholder', [
            'title' => 'Investments',
            'action' => 'Edit',
            'item' => $investment,
        ]);
    }

    public function update(Request $request, $id)
    {
        $inv = Investment::findOrFail($id);
        $inv->update($request->only(['name','principal','rate_percent','start_date','maturity_date','current_value']));
        return redirect()->route('admin.investments.index')->with('success', 'Investasi diperbarui.');
    }

    public function destroy($id)
    {
        Investment::findOrFail($id)->delete();
        return redirect()->route('admin.investments.index')->with('success', 'Investasi dihapus.');
    }
}
