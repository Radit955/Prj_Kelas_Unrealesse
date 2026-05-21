@extends('layouts.admin')
@section('title', 'Pengumuman')
@section('content')

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Pengumuman</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola pengumuman untuk siswa dan guru</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengumuman
        </a>
    </div>

    {{-- Announcements Table --}}
    <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Judul</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Tipe</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Mode Tampil</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Pinned</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Pembuat</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Tanggal</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($announcements as $announcement)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-900 dark:text-slate-100 max-w-xs truncate">{{ $announcement->title }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-1">{{ $announcement->content }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($announcement->type === 'warning')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 dark:bg-amber-900/30 text-xs font-semibold text-amber-700 dark:text-amber-300">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.487 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"/></svg>
                                Warning
                            </span>
                            @elseif($announcement->type === 'danger')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 dark:bg-red-900/30 text-xs font-semibold text-red-700 dark:text-red-300">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/></svg>
                                Danger
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-900/30 text-xs font-semibold text-blue-700 dark:text-blue-300">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zm3 0a1 1 0 11-2 0 1 1 0 012 0zm3 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                                Info
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                {{ ($announcement->mode ?? 'dashboard') === 'fullscreen' ? 'bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : ($announcement->mode ?? 'dashboard') === 'notification' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : 'bg-slate-50 dark:bg-slate-900/50 text-slate-700 dark:text-slate-300' }}">
                                {{ ucfirst($announcement->mode ?? 'Dashboard') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form method="POST" action="{{ route('admin.announcements.pin', $announcement) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-lg hover:scale-110 transition" title="Toggle pin">
                                    @if($announcement->pinned)
                                    <span class="text-yellow-500">📌</span>
                                    @else
                                    <span class="text-slate-300 dark:text-slate-600">📍</span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-700 dark:text-slate-300">{{ $announcement->creator->name ?? '—' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                @if($announcement->published_at)
                                    {{ \Carbon\Carbon::parse($announcement->published_at)->setTimezone('Asia/Jakarta')->format('d M Y') }}
                                @else
                                    <span class="text-slate-400 dark:text-slate-500">—</span>
                                @endif
                            </p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.announcements.edit', $announcement) }}" class="inline-flex items-center justify-center rounded-lg bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 px-3 py-2 text-sm font-medium text-blue-700 dark:text-blue-300 transition">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-red-50 hover:bg-red-100 dark:bg-red-900/30 dark:hover:bg-red-900/50 px-3 py-2 text-sm font-medium text-red-700 dark:text-red-300 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400 text-sm">
                            Belum ada pengumuman
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
            {{ $announcements->links() }}
        </div>
    </div>
</div>

@endsection
