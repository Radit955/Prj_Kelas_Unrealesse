@extends('layouts.app')

@section('title', 'Jadwal Pelajaran')
@section('content')

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Jadwal Pelajaran</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Lihat jadwal pelajaran harian dan mingguan dalam tampilan kelas.</p>
        </div>
        <div class="rounded-2xl bg-slate-50 dark:bg-slate-900/60 px-4 py-2 text-sm text-slate-600 dark:text-slate-300">Hari ini: {{ $today }}</div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach($days as $day)
        <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm overflow-hidden">
            <div class="px-5 py-4 bg-gradient-to-r from-blue-600 to-sky-500 text-white">
                <h2 class="text-sm font-semibold uppercase tracking-[0.2em]">{{ $day }}</h2>
                <p class="text-xs text-white/80 mt-1">{{ $today === $day ? 'Jadwal hari ini' : 'Jadwal ' . strtolower($day) }}</p>
            </div>
            <div class="p-4 space-y-3">
                @forelse($schedules[$day] ?? [] as $schedule)
                <div class="rounded-3xl bg-slate-50 dark:bg-slate-900/50 p-4">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $schedule->lesson_name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $schedule->teacher_name ?? ($schedule->teacher_code ?? '-') }}</p>
                        </div>
                        <span class="text-[11px] font-semibold text-slate-600 dark:text-slate-300">{{ $schedule->start_time }} - {{ $schedule->end_time }}</span>
                    </div>
                </div>
                @empty
                <div class="rounded-3xl bg-slate-50 dark:bg-slate-900/50 p-4 text-sm text-slate-500 dark:text-slate-400 text-center">
                    Belum ada jadwal untuk hari ini.
                </div>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection