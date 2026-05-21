@extends('layouts.admin')
@section('title','Detail Guru')
@section('content')
<div class="max-w-lg">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.teachers.index') }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Detail Guru</h1>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm p-6 space-y-5">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full overflow-hidden bg-purple-600 flex items-center justify-center flex-shrink-0">
                @if($teacher->user?->avatar)
                <img src="{{ Storage::url($teacher->user->avatar) }}" class="w-full h-full object-cover">
                @else
                <span class="text-white text-xl font-bold">{{ strtoupper(substr($teacher->user?->name ?? '?',0,2)) }}</span>
                @endif
            </div>
            <div>
                <h2 class="text-base font-semibold text-slate-800 dark:text-slate-100">{{ $teacher->user?->name ?? '—' }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $teacher->user?->email ?? '' }}</p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 border-t border-slate-100 dark:border-slate-700 pt-4">
            <div>
                <p class="text-xs text-slate-400 mb-1">NIP</p>
                <p class="text-sm font-mono font-medium text-slate-700 dark:text-slate-300">{{ $teacher->nip ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-1">Mata Pelajaran</p>
                <span class="text-xs bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-400 px-2 py-1 rounded font-medium">{{ $teacher->subject ?? '—' }}</span>
            </div>
        </div>
        <div class="flex gap-3 border-t border-slate-100 dark:border-slate-700 pt-4">
            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg text-sm font-medium transition-colors">Edit</a>
            <form method="POST" action="{{ route('admin.teachers.destroy', $teacher->id) }}" onsubmit="return confirm('Hapus guru ini?')" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit" class="w-full px-4 py-2.5 text-sm bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection
