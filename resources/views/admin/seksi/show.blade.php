@extends('layouts.admin')
@section('title', 'Detail Seksi')
@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.seksi.index') }}" class="w-10 h-10 inline-flex items-center justify-center rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-500 hover:text-slate-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">{{ $seksi->name }}</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Detail lengkap seksi kegiatan.</p>
        </div>
    </div>

    <div class="space-y-4">
        <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-6">
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs text-slate-400 dark:text-slate-500 uppercase tracking-[0.18em] mb-1">Kategori</p>
                        <p class="text-base font-semibold text-slate-800 dark:text-slate-100">{{ $seksi->category ?? 'Umum' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 dark:text-slate-500 uppercase tracking-[0.18em] mb-1">Anggota</p>
                        <p class="text-base font-semibold text-slate-800 dark:text-slate-100">{{ $seksi->members->count() }} orang</p>
                    </div>
                </div>
                @if($seksi->description)
                <div>
                    <p class="text-xs text-slate-400 dark:text-slate-500 uppercase tracking-[0.18em] mb-2">Deskripsi</p>
                    <p class="text-sm text-slate-700 dark:text-slate-200">{{ $seksi->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-6">
            <p class="text-xs text-slate-400 dark:text-slate-500 uppercase tracking-[0.18em] mb-3">Ketua Seksi</p>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-semibold">
                    {{ strtoupper(substr($seksi->ketua?->user?->name ?? '—', 0, 2)) }}
                </div>
                <div>
                    <p class="text-base font-semibold text-slate-800 dark:text-slate-100">{{ $seksi->ketua?->user?->name ?? 'Belum ditentukan' }}</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500">NIS: {{ $seksi->ketua?->nis ?? '—' }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">Anggota Seksi</p>
                <span class="text-xs bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 px-2 py-1 rounded-full">{{ $seksi->members->count() }} orang</span>
            </div>
            <div class="space-y-2 p-6">
                @forelse($seksi->members as $member)
                <div class="flex items-center gap-3 rounded-2xl border border-slate-100 dark:border-slate-700 p-3">
                    <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-700 dark:text-slate-200 text-sm font-semibold">
                        {{ strtoupper(substr($member->user?->name ?? '—', 0, 2)) }}
                    </div>
                    <div>
                        <p class="font-medium text-slate-800 dark:text-slate-100">{{ $member->user?->name ?? '—' }}</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500">NIS: {{ $member->nis ?? '—' }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada anggota dalam seksi ini.</p>
                @endforelse
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.seksi.edit', $seksi) }}" class="rounded-2xl bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 text-sm font-semibold transition">Edit Seksi</a>
            <a href="{{ route('admin.seksi.index') }}" class="rounded-2xl border border-slate-200 dark:border-slate-700 px-4 py-3 text-sm font-medium text-slate-500 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-900 transition">Kembali</a>
        </div>
    </div>
</div>
@endsection
