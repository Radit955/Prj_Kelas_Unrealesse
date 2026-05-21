@extends('layouts.app')

@section('title', 'Jadwal Piket')
@section('content')

<div class="space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Jadwal Piket</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Ringkasan tugas piket kelas untuk satu minggu.</p>
        </div>
        <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/20 dark:text-blue-300">Senin – Jumat</span>
    </div>

    @php
    $days = ['SENIN','SELASA','RABU','KAMIS','JUMAT'];
    $todayRaw = strtoupper(\Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd'));
    $dayMap = ['SENIN'=>'SENIN','SELASA'=>'SELASA','RABU'=>'RABU','KAMIS'=>'KAMIS','JUMAT'=>'JUMAT'];
    $today = $dayMap[$todayRaw] ?? '';
    $dayColors = ['SENIN'=>'#2563eb','SELASA'=>'#7c3aed','RABU'=>'#059669','KAMIS'=>'#d97706','JUMAT'=>'#dc2626'];
    $weekStart = now()->startOfWeek();
    $weekEnd = now()->endOfWeek();
    $weeklyPikets = \App\Models\PiketAssignment::with('student.user')
        ->whereBetween('date', [$weekStart, $weekEnd])
        ->orderBy('date')
        ->get()
        ->groupBy(fn($item) => strtoupper(\Carbon\Carbon::parse($item->date)->locale('id')->isoFormat('dddd')));
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        @foreach($days as $day)
        @php $color = $dayColors[$day]; $pikets = $weeklyPikets->get($day, collect()); @endphp
        <div class="rounded-3xl border shadow-sm overflow-hidden" style="border-color: #e2e8f0;">
            <div class="px-4 py-3 flex items-center justify-between" style="background: {{ $color }};">
                <span class="text-xs font-semibold uppercase tracking-[0.2em] text-white">{{ $day }}</span>
                @if($day === $today)
                <span class="text-[10px] bg-white/20 text-white px-2 py-1 rounded-full">Hari Ini</span>
                @endif
            </div>
            <div class="p-4 bg-white dark:bg-slate-800 min-h-[140px]">
                @forelse($pikets as $item)
                <div class="flex items-center gap-3 py-2 border-b last:border-b-0 border-slate-100 dark:border-slate-700">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold text-white" style="background: {{ $color }};">
                        {{ strtoupper(substr($item->student->user->name ?? '?', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 dark:text-slate-100 truncate">{{ $item->student->user->name ?? '—' }}</p>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">{{ ucfirst($item->status) }}</p>
                    </div>
                </div>
                @empty
                <p class="text-xs text-slate-400 text-center">Belum ada data piket</p>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>

    @php $notPiket = \App\Models\PiketAssignment::with('student.user')->where('date', today())->where('status', 'alpha')->get(); @endphp
    @if($notPiket->count() > 0)
    <div class="rounded-3xl border border-red-200 bg-red-50 dark:border-red-800 dark:bg-red-900/10 p-5">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <div>
                <p class="text-sm font-semibold text-red-700 dark:text-red-300">Siswa tidak melaksanakan piket hari ini</p>
                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach($notPiket as $item)
                    <span class="text-[10px] bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300 px-2 py-1 rounded-full">{{ $item->student->user->name ?? '—' }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection