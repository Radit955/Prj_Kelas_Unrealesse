@extends('layouts.admin')

@section('title', 'Overview')
@section('content')

<div class="space-y-6">
    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Admin Dashboard</p>
                <h1 class="mt-2 text-3xl font-semibold text-slate-900">Ringkasan Operasional</h1>
                <p class="mt-2 text-sm text-slate-500 max-w-2xl">Pantau aktivitas pengguna, kas, jadwal, pengumuman, dan berita terbaru langsung dari panel admin.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    <span>Kelola Pengguna</span>
                </a>
                <a href="{{ route('admin.announcements.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                    <span>Pengumuman</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid gap-4 xl:grid-cols-3">
        <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total Pengguna</p>
            <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $totalUsers }}</p>
            <p class="mt-3 text-sm text-slate-500">Akun terdaftar di semua peran.</p>
        </div>
        <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total Siswa</p>
            <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $totalStudents }}</p>
            <p class="mt-3 text-sm text-slate-500">Siswa terdaftar dalam sistem.</p>
        </div>
        <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total Pengumuman</p>
            <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $totalAnnouncements }}</p>
            <p class="mt-3 text-sm text-slate-500">Pengumuman aktif dan historis.</p>
        </div>
    </div>

    <div class="grid gap-5 xl:grid-cols-3">
        <div class="xl:col-span-2 space-y-5">
            <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Ringkasan Keuangan</h2>
                        <p class="mt-1 text-sm text-slate-500">Total kas dan nilai investasi saat ini.</p>
                    </div>
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">Stabil</span>
                </div>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl border border-slate-100 bg-slate-50 p-5">
                        <p class="text-sm text-slate-500">Total Kas</p>
                        <p class="mt-3 text-2xl font-semibold text-slate-900">Rp {{ number_format($totalKas, 0, ',', '.') }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-100 bg-slate-50 p-5">
                        <p class="text-sm text-slate-500">Nilai Investasi</p>
                        <p class="mt-3 text-2xl font-semibold text-slate-900">Rp {{ number_format($totalInvestments, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Aksi Cepat</h2>
                        <p class="mt-1 text-sm text-slate-500">Menu cepat untuk pengelolaan konten utama.</p>
                    </div>
                </div>
                <div class="mt-5 grid gap-3 sm:grid-cols-3">
                    <a href="{{ route('admin.users.index') }}" class="rounded-3xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm font-semibold text-slate-900 hover:bg-slate-100 transition">Pengguna</a>
                    <a href="{{ route('admin.announcements.index') }}" class="rounded-3xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm font-semibold text-slate-900 hover:bg-slate-100 transition">Pengumuman</a>
                    <a href="{{ route('admin.banners.index') }}" class="rounded-3xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm font-semibold text-slate-900 hover:bg-slate-100 transition">Banner</a>
                </div>
            </div>
        </div>

        <div class="space-y-5">
            <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Status Hari Ini</h2>
                <div class="mt-5 space-y-4">
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm text-slate-500">Jadwal</p>
                                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $totalSchedules }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm text-slate-500">Piket Hari Ini</p>
                                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $todayPiket }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm text-slate-500">Banner Aktif</p>
                                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $activeBanners }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Informasi Admin</h2>
                <p class="mt-3 text-sm text-slate-500">Panel ini hanya dapat diakses oleh peran administrator dan wali kelas. Pastikan hanya pengguna terverifikasi yang memiliki akses ke menu Admin.</p>
            </div>
        </div>
    </div>
</div>

@endsection
