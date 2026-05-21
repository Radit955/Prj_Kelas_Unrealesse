<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $student = $user->student;

        $kasBalance = 0;
        $kasHistory = collect();
        if (class_exists(\App\Models\KasTransaction::class) && Schema::hasTable('kas_transactions')) {
            try {
                $kasBalance = \App\Models\KasTransaction::where('type', 'credit')->sum('amount')
                    - \App\Models\KasTransaction::where('type', 'debit')->sum('amount');
                $kasHistory = \App\Models\KasTransaction::latest()->limit(5)->get();
            } catch (\Exception $e) {
                $kasBalance = 0;
                $kasHistory = collect();
            }
        }

        $absensiCount = 0;
        $absensiLast = null;
        if ($student) {
            try {
                $absensiCount = \App\Models\Absence::where('student_id', $student->id)
                    ->whereMonth('date', now()->month)->count();
                $absensiLast = \App\Models\Absence::where('student_id', $student->id)
                    ->latest()->first();
            } catch (\Exception $e) {
                $absensiCount = 0;
                $absensiLast = null;
            }
        }

        $mySeksi = collect();
        if ($student) {
            try {
                $mySeksi = \App\Models\SeksiKegiatan::whereHas('members', fn($q) => $q->where('student_id', $student->id))
                    ->with('ketua.user')->get();
            } catch (\Exception $e) {
                $mySeksi = collect();
            }
        }

        $announcements = collect();
        try {
            if (Schema::hasColumn('announcements', 'display_mode')) {
                $announcements = \App\Models\Announcement::where('display_mode', 'dashboard')
                    ->where(fn($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
                    ->orderByDesc('pinned')->orderByDesc('created_at')->limit(3)->get();
            } else {
                $announcements = \App\Models\Announcement::latest()->limit(3)->get();
            }
        } catch (\Exception $e) {
            $announcements = collect();
        }

        $piketJadwal = collect();
        if ($student) {
            try {
                $piketJadwal = \App\Models\PiketAssignment::where('student_id', $student->id)
                    ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
                    ->get();
            } catch (\Exception $e) {
                $piketJadwal = collect();
            }
        }

        $absSetting = null;
        try {
            $absSetting = \App\Models\AbsenceSetting::current();
        } catch (\Exception $e) {
            $absSetting = null;
        }

        $totalStudents = \App\Models\Student::count();
        $kasCollected = \App\Models\KasTransaction::where('status', 'paid')->sum('amount');
        $investmentValue = \App\Models\Investment::sum('current_value');
        $unpaidKas = \App\Models\KasTransaction::where('status', 'unpaid')->count();
        $seatLayout = \App\Models\SeatLayout::with('student.user')->get();
        $piket = \App\Models\PiketAssignment::with('student.user')->whereDate('date', today())->get();
        $schedule = \App\Models\Schedule::where('day', strtoupper(now()->locale('id')->dayName))->get();
        $activeLesson = $schedule->where('start_time', '<=', now()->format('H:i'))->where('end_time', '>', now()->format('H:i'))->first();
        $activeBanners = \App\Models\Banner::where('is_active', true)->orderBy('order')->get();

        $kasChartLabels = collect(range(7, 0))->map(fn($w) => 'Minggu ' . (8 - $w))->values();
        $kasChartData = collect(range(7, 0))->map(function ($w) {
            $start = now()->startOfWeek()->subWeeks($w);
            $end = now()->startOfWeek()->subWeeks($w)->endOfWeek();
            return \App\Models\KasTransaction::where('status', 'paid')
                ->whereBetween('paid_at', [$start, $end])
                ->sum('amount');
        })->values();

        $investments = \App\Models\Investment::all();
        $investLabels = collect(range(0, 11))->map(fn($m) => Carbon::now()->subMonths(11 - $m)->format('M Y'));
        $investData = $investments->map(fn($inv) =>
            collect(range(0, 11))->map(fn($m) => round($inv->principal * pow(1 + ($inv->rate_percent / 100 / 12), $m + 1), 0))
        );

        return view('dashboard', compact(
            'user',
            'student',
            'kasBalance',
            'kasHistory',
            'absensiCount',
            'absensiLast',
            'mySeksi',
            'announcements',
            'piket',
            'schedule',
            'activeLesson',
            'activeBanners',
            'kasChartLabels',
            'kasChartData',
            'investments',
            'investLabels',
            'investData',
            'totalStudents',
            'kasCollected',
            'investmentValue',
            'unpaidKas',
            'seatLayout',
            'piketJadwal',
            'absSetting'
        ));
    }
}
