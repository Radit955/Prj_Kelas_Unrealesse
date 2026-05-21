@extends('layouts.admin')
@section('title','Detail Pengumuman')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.announcements.index') }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Detail Pengumuman</h1>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm p-6 space-y-4">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-100">{{ $announcement->title }}</h2>
                <div class="mt-2 flex flex-wrap gap-2 text-xs text-slate-500 dark:text-slate-400">
                    <span class="px-2 py-1 rounded-full bg-slate-100 dark:bg-slate-700">{{ ucfirst($announcement->type ?? 'info') }}</span>
                    @if($announcement->pinned)
                    <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">Pinned</span>
                    @endif
                    @if(isset($announcement->display_mode))
                    <span class="px-2 py-1 rounded-full bg-slate-100 dark:bg-slate-700">{{ ucfirst($announcement->display_mode) }}</span>
                    @endif
                </div>
            </div>
            <div class="text-right text-xs text-slate-400">
                <div>{{ $announcement->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? '—' }}</div>
                <div class="mt-1">{{ $announcement->creator?->name ?? '—' }}</div>
            </div>
        </div>
        <div class="prose prose-slate dark:prose-invert text-slate-700 dark:text-slate-200">{!! nl2br(e($announcement->body)) !!}</div>
        <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
            <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg text-sm font-medium transition-colors">Edit</a>
            <form method="POST" action="{{ route('admin.announcements.destroy', $announcement->id) }}" onsubmit="return confirm('Hapus pengumuman ini?')" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit" class="w-full px-4 py-2.5 text-sm bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection
