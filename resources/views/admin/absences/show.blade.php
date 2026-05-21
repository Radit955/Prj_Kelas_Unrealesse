@extends('layouts.admin')
@section('title', 'Detail Absensi')
@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.absences.index') }}" class="w-10 h-10 inline-flex items-center justify-center rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-500 hover:text-slate-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Detail Absensi</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Informasi lengkap permohonan izin.</p>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-6">
        <div class="grid gap-4 sm:grid-cols-2 text-sm text-slate-600 dark:text-slate-300">
            <div>
                <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Nama</p>
                <p class="mt-2 font-medium text-slate-900 dark:text-slate-100">{{ $absence->student->user->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Tanggal</p>
                <p class="mt-2 font-medium text-slate-900 dark:text-slate-100">{{ \Carbon\Carbon::parse($absence->date)->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Jenis</p>
                <p class="mt-2 font-medium text-slate-900 dark:text-slate-100">{{ ucfirst($absence->type) }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Status</p>
                <p class="mt-2 font-medium {{ $absence->status === 'approved' ? 'text-emerald-700' : ($absence->status === 'rejected' ? 'text-red-700' : 'text-amber-700') }}">{{ ucfirst($absence->status) }}</p>
            </div>
        </div>

        <div class="mt-6 rounded-3xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 p-5">
            <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Keterangan</p>
            <p class="mt-2 text-sm text-slate-700 dark:text-slate-200">{{ $absence->reason }}</p>
        </div>

        @if($absence->duration_days > 0)
        <div class="mt-4 rounded-3xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 p-5">
            <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Durasi Izin</p>
            <p class="mt-2 text-sm text-slate-700 dark:text-slate-200">{{ $absence->duration_days }} hari</p>
        </div>
        @endif

        <div class="mt-6 flex flex-wrap gap-3">
            @if($absence->parent_signature_path)
            <a href="{{ Storage::url($absence->parent_signature_path) }}" target="_blank" class="rounded-2xl bg-slate-100 dark:bg-slate-900 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-800 transition">Lihat Tanda Tangan</a>
            @endif
            <a href="{{ route('admin.absences.index') }}" class="rounded-2xl border border-slate-200 dark:border-slate-700 px-4 py-3 text-sm font-medium text-slate-500 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-900 transition">Kembali</a>
        </div>
    </div>
</div>
@endsection
