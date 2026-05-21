<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $days      = ['SENIN','SELASA','RABU','KAMIS','JUMAT'];
        $schedules = Schedule::orderByRaw("FIELD(day,'SENIN','SELASA','RABU','KAMIS','JUMAT')")
            ->orderBy('start_time')
            ->get()
            ->groupBy('day');
        return view('admin.schedules.index', compact('schedules','days'));
    }

    public function create()
    {
        $days    = ['SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU'];
        $classes = ['XI TKRO','XI TKJ','XI TEKKES','XI RPL','XI ASKEP','XII TKRO','XII RPL','XII TKJ','XII ASKEP','XII FKK'];
        return view('admin.schedules.create', compact('days','classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'day'          => 'required|in:SENIN,SELASA,RABU,KAMIS,JUMAT,SABTU',
            'class_name'   => 'required|string|max:50',
            'lesson_name'  => 'required|string|max:255',
            'lesson_code'  => 'required|string|max:50',
            'teacher_code' => 'nullable|string|max:50',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
        ]);
        Schedule::create($request->only(['day','class_name','lesson_name','lesson_code','teacher_code','start_time','end_time']));
        return redirect()->route('admin.schedules.index')->with('success','Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $days     = ['SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU'];
        $classes  = ['XI TKRO','XI TKJ','XI TEKKES','XI RPL','XI ASKEP','XII TKRO','XII RPL','XII TKJ','XII ASKEP','XII FKK'];
        return view('admin.schedules.edit', compact('schedule','days','classes'));
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $request->validate([
            'day'          => 'required|in:SENIN,SELASA,RABU,KAMIS,JUMAT,SABTU',
            'class_name'   => 'required|string|max:50',
            'lesson_name'  => 'required|string|max:255',
            'lesson_code'  => 'required|string|max:50',
            'teacher_code' => 'nullable|string|max:50',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
        ]);
        $schedule->update($request->only(['day','class_name','lesson_name','lesson_code','teacher_code','start_time','end_time']));
        return redirect()->route('admin.schedules.index')->with('success','Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();
        return redirect()->route('admin.schedules.index')->with('success','Jadwal berhasil dihapus.');
    }
}
