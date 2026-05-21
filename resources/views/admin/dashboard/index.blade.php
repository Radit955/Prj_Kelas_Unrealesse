@extends('layouts.admin')
@section('title', 'Overview')
@section('content')

<div class="space-y-6">
    {{-- STATS GRID --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-100 p-4 flex items-start gap-3 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.646 4 4 0 010-8.646M3 20.394c0-.997.978-1.957 2.468-2.468A6.987 6.987 0 0112 15c2.56 0 4.946.98 6.532 2.594 1.49.511 2.468 1.471 2.468 2.468"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500">Total Pengguna</p>
                <p class="text-xl font-semibold text-slate-800 mt-0.5">{{ $totalUsers }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-100 p-4 flex items-start gap-3 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500">Total Siswa</p>
                <p class="text-xl font-semibold text-slate-800 mt-0.5">{{ $totalStudents }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-100 p-4 flex items-start gap-3 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500">Total Investasi</p>
                <p class="text-lg font-semibold text-slate-800 mt-0.5 truncate">Rp {{ number_format($totalInvestments, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-100 p-4 flex items-start gap-3 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500">Total Kas</p>
                <p class="text-lg font-semibold text-slate-800 mt-0.5 truncate">Rp {{ number_format($totalKas, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- CONTENT GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- ANNOUNCEMENTS & CONTENT --}}
        <div class="lg:col-span-2 space-y-5">
            {{-- ANNOUNCEMENTS --}}
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-slate-800">Pengumuman Terbaru</h3>
                    <a href="{{ route('admin.announcements.index') }}" class="text-xs text-blue-600 hover:underline">Lihat Semua</a>
                </div>
                <div class="divide-y divide-slate-50">
                    @forelse(\App\Models\Announcement::latest()->limit(5)->get() as $announcement)
                    <div class="px-5 py-3 hover:bg-slate-50/50 transition">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="text-sm font-medium text-slate-800">{{ $announcement->title }}</p>
                                <p class="text-xs text-slate-400 mt-1">{{ $announcement->creator->name ?? '—' }} · {{ $announcement->created_at->timezone('Asia/Jakarta')->diffForHumans() }}</p>
                            </div>
                            @if($announcement->type === 'warning')
                            <span class="text-xs bg-amber-50 text-amber-600 px-2 py-1 rounded flex-shrink-0">Warning</span>
                            @elseif($announcement->type === 'danger')
                            <span class="text-xs bg-red-50 text-red-600 px-2 py-1 rounded flex-shrink-0">Penting</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="px-5 py-8 text-center">
                        <p class="text-xs text-slate-400">Belum ada pengumuman</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- BANNERS --}}
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-slate-800">Banner Aktif</h3>
                    <a href="{{ route('admin.banners.index') }}" class="text-xs text-blue-600 hover:underline">Kelola</a>
                </div>
                <div class="divide-y divide-slate-50">
                    @forelse(\App\Models\Banner::where('is_active', true)->limit(3)->get() as $banner)
                    <div class="px-5 py-3 flex items-center gap-3 hover:bg-slate-50/50 transition">
                        @if($banner->image_path)
                        <img src="{{ Storage::url($banner->image_path) }}" class="w-12 h-8 object-cover rounded" alt="{{ $banner->title }}">
                        @else
                        <div class="w-12 h-8 bg-gradient-to-r from-blue-400 to-blue-600 rounded"></div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800 truncate">{{ $banner->title }}</p>
                            <p class="text-xs text-slate-400">Order: {{ $banner->order }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="px-5 py-8 text-center">
                        <p class="text-xs text-slate-400">Belum ada banner aktif</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- SIDEBAR CARDS --}}
        <div class="space-y-5">
            {{-- QUICK STATS --}}
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h3 class="text-sm font-semibold text-slate-800">Statistik Cepat</h3>
                </div>
                <div class="divide-y divide-slate-50">
                    <div class="px-5 py-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600">Jadwal</span>
                            <span class="text-lg font-semibold text-slate-800">{{ $totalSchedules }}</span>
                        </div>
                    </div>
                    <div class="px-5 py-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600">Piket Hari Ini</span>
                            <span class="text-lg font-semibold text-slate-800">{{ $todayPiket }}</span>
                        </div>
                    </div>
                    <div class="px-5 py-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600">Pengumuman</span>
                            <span class="text-lg font-semibold text-slate-800">{{ $totalAnnouncements }}</span>
                        </div>
                    </div>
                    <div class="px-5 py-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600">Banner Aktif</span>
                            <span class="text-lg font-semibold text-slate-800">{{ $activeBanners }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- QUICK ACTIONS --}}
            <div class="bg-blue-50 rounded-xl border border-blue-200 p-4">
                <h3 class="text-sm font-semibold text-blue-900 mb-3">Aksi Cepat</h3>
                <div class="space-y-2 flex flex-col">
                    <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-2 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Pengumuman
                    </a>
                    <a href="{{ route('admin.banners.create') }}" class="inline-flex items-center justify-center gap-2 bg-white text-blue-600 text-xs font-medium px-3 py-2 rounded-lg border border-blue-200 hover:bg-blue-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Upload Banner
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
