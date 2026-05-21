<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\PiketController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\KasController as AdminKasController;
use App\Http\Controllers\Admin\InvestmentController as AdminInvestmentController;
use App\Http\Controllers\Admin\AbsenceController as AdminAbsenceController;
use App\Http\Controllers\Admin\PiketController as AdminPiketController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Admin\SeksiController as AdminSeksiController;

Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::get('piket', [PiketController::class, 'index'])->name('piket.index');
    Route::get('kas', [KasController::class, 'index'])->name('kas.index');
    Route::post('kas/pay', [KasController::class, 'pay'])->name('kas.pay');
    Route::resource('izin', AbsenceController::class);
    Route::get('jadwal', [ScheduleController::class, 'index'])->name('jadwal.index');
    Route::resource('tugas', TaskController::class);

    // Tasks alias routes for Blade references and modal support
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    Route::post('/payment/create', [App\Http\Controllers\PaymentController::class, 'createTransaction'])->name('payment.create');
});

Route::post('/payment/callback', [App\Http\Controllers\PaymentController::class, 'callback'])->name('payment.callback');

Route::middleware(['auth', 'role:admin,wali_kelas,ketua_kelas'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::resource('teachers', AdminTeacherController::class);
    Route::resource('students', AdminStudentController::class);
    Route::resource('announcements', AdminAnnouncementController::class);
    Route::resource('schedules', AdminScheduleController::class)->except(['show']);
    Route::resource('kas', AdminKasController::class)->except(['show']);
    Route::resource('investments', AdminInvestmentController::class);
    Route::get('/absences/settings', [AdminAbsenceController::class, 'settings'])->name('absences.settings');
    Route::post('/absences/settings', [AdminAbsenceController::class, 'saveSettings'])->name('absences.settings.save');
    Route::post('/absences/{id}/approve', [AdminAbsenceController::class, 'approve'])->name('absences.approve');
    Route::post('/absences/{id}/reject', [AdminAbsenceController::class, 'reject'])->name('absences.reject');
    Route::resource('absences', AdminAbsenceController::class);
    Route::resource('piket', AdminPiketController::class);
    Route::resource('seksi', AdminSeksiController::class);
    Route::resource('banners', AdminBannerController::class);

    // User administrative actions
    Route::post('/users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{user}/unsuspend', [AdminUserController::class, 'unsuspend'])->name('users.unsuspend');
    Route::post('/users/{user}/timeout', [AdminUserController::class, 'timeout'])->name('users.timeout');

    // Banner toggles
    Route::post('/banners/{id}/toggle', [AdminBannerController::class, 'toggle'])->name('banners.toggle');

    // Announcement pin action
    Route::post('/announcements/{id}/pin', [AdminAnnouncementController::class, 'togglePin'])->name('announcements.pin');
});

// require __DIR__.'/auth.php';
