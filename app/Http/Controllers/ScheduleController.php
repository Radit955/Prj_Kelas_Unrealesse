<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $days = ['SENIN','SELASA','RABU','KAMIS','JUMAT'];
        $schedules = \App\Models\Schedule::orderByRaw("FIELD(day,'SENIN','SELASA','RABU','KAMIS','JUMAT')")
            ->orderBy('start_time')
            ->get()
            ->groupBy('day');
        $today = strtoupper(\Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd'));

        return view('schedule.index', compact('schedules', 'days', 'today'));
    }
}
