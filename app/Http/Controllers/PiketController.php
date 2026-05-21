<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PiketController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $pikets = \App\Models\PiketAssignment::with('student.user')
            ->where('date', $today)
            ->get();

        return view('piket.index', compact('pikets'));
    }
}
