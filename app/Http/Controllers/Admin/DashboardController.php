<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Banner;
use App\Models\Investment;
use App\Models\KasTransaction;
use App\Models\PiketAssignment;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalStudents = Student::count();
        $totalAnnouncements = Announcement::count();
        $totalSchedules = Schedule::count();
        $totalKas = KasTransaction::sum('amount');
        $totalInvestments = Investment::sum('current_value');
        $todayPiket = PiketAssignment::whereDate('date', today())->count();
        $activeBanners = Banner::where('is_active', true)->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStudents',
            'totalAnnouncements',
            'totalSchedules',
            'totalKas',
            'totalInvestments',
            'todayPiket',
            'activeBanners'
        ));
    }
}
