@extends('layouts.app')

@section('title', 'Form Izin')
@section('content')

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Form Izin</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Ajukan izin atau lihat status permohonan izin Anda.</p>
        </div>
        <a href="{{ route('izin.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
            Ajukan Izin Baru
        </a>
    </div>

    <div class="grid gap-4 xl:grid-cols-[0.95fr_0.95fr]">
        <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Pengajuan Izin Terbaru</h2>
            <div class="mt-4 space-y-3">
                @forelse($absences as $absence)
                <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 p-4">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $absence->student->user->name ?? '—' }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ ucfirst($absence->type) }} | {{ \Carbon\Carbon::parse($absence->date)->isoFormat('D MMM Y') }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $absence->status === 'approved' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : ($absence->status === 'rejected' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300') }}">
                            {{ ucfirst($absence->status) }}
                        </span>
                    </div>
                    @if($absence->reason)
                    <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Alasan: {{ $absence->reason }}</p>
                    @endif
                </div>
                @empty
                <div class="rounded-3xl bg-slate-50 dark:bg-slate-900/50 p-6 text-center text-slate-500 dark:text-slate-400">
                    Belum ada pengajuan izin.
                </div>
                @endforelse
            </div>
            <div class="mt-6">{{ $absences->links() }}</div>
        </div>

        <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Panduan Izin</h2>
            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Gunakan form izin untuk melaporkan ketidakhadiran. Dokumen pendukung bisa diunggah melalui saat pengisian izin.</p>
            <ul class="mt-4 space-y-3 text-sm text-slate-500 dark:text-slate-400">
                <li class="flex items-start gap-3"><span class="mt-0.5 inline-block h-2 w-2 rounded-full bg-blue-500"></span> Pilih jenis izin dan tanggal yang jelas.</li>
                <li class="flex items-start gap-3"><span class="mt-0.5 inline-block h-2 w-2 rounded-full bg-blue-500"></span> Jelaskan alasan secara singkat dan jelas.</li>
                <li class="flex items-start gap-3"><span class="mt-0.5 inline-block h-2 w-2 rounded-full bg-blue-500"></span> Tunggu persetujuan dari admin atau guru BK.</li>
            </ul>
        </div>
    </div>
</div>

@endsection