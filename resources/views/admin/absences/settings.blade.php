@extends('layouts.admin')
@section('title', 'Pengaturan Absensi')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.absences.index') }}" class="w-10 h-10 inline-flex items-center justify-center rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-500 hover:text-slate-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Pengaturan Absensi</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Atur limit izin dan kebijakan sakit.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="rounded-3xl border border-emerald-200 bg-emerald-50 dark:bg-emerald-900/20 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 p-4 mb-4 text-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-6">
        <form action="{{ route('admin.absences.settings.save') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Maksimal Hari Izin</label>
                <input type="number" name="max_izin_days" value="{{ old('max_izin_days', $setting->max_izin_days) }}" min="1" max="365" class="w-32 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30" />
            </div>
            <div class="flex items-center gap-3 rounded-3xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 p-4">
                <input type="checkbox" name="sakit_unlimited" value="1" class="h-4 w-4 rounded text-blue-600 focus:ring-blue-500" {{ $setting->sakit_unlimited ? 'checked' : '' }} />
                <div>
                    <p class="text-sm font-medium text-slate-900 dark:text-white">Sakit tanpa batas hari</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Jika dicentang, keterangan sakit tidak dibatasi oleh sistem.</p>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                <a href="{{ route('admin.absences.index') }}" class="rounded-2xl border border-slate-200 dark:border-slate-700 px-4 py-3 text-sm text-slate-500 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-900 transition">Batal</a>
                <button type="submit" class="rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
