@extends('layouts.app')

@section('title', 'Detail Guru')
@section('content')

<div class="max-w-3xl space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Detail Guru</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Profil dan jadwal pengajaran guru.</p>
        </div>
        <a href="{{ route('teachers.index') }}" class="text-sm text-blue-600 hover:underline">Kembali ke daftar</a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="h-28 bg-gradient-to-r from-slate-900 to-blue-700"></div>
        <div class="p-6 -mt-10">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 rounded-3xl bg-slate-900 text-white flex items-center justify-center text-2xl font-bold">
                    {{ strtoupper(substr($teacher->user->name ?? '??', 0, 2)) }}
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">{{ $teacher->user->name ?? '—' }}</h2>
                    <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">{{ $teacher->subject ?? 'Mata Pelajaran belum diatur' }}</p>
                </div>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl bg-slate-50 dark:bg-slate-700/50 p-4">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">NIP</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $teacher->nip ?? '-' }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 dark:bg-slate-700/50 p-4">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Guru untuk</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $teacher->subject ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Catatan Pengajaran</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">Data jadwal, absensi, dan tugas dapat ditambahkan melalui panel admin.</p>
            </div>
        </div>
    </div>
</div>

@endsection