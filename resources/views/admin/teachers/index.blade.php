@extends('layouts.admin')
@section('title', 'Data Guru')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Data Guru</h1>
        <p class="text-xs text-slate-400 mt-0.5">{{ $teachers->total() }} guru terdaftar</p>
    </div>
    <a href="{{ route('admin.teachers.create') }}"
       class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Guru
    </a>
</div>
<div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-100 dark:border-slate-700">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Guru</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NIP</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mata Pelajaran</th>
                    <th class="text-right px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-700">
                @forelse($teachers as $teacher)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full overflow-hidden bg-purple-600 flex items-center justify-center flex-shrink-0">
                                @if($teacher->user?->avatar)
                                <img src="{{ Storage::url($teacher->user->avatar) }}" class="w-full h-full object-cover">
                                @else
                                <span class="text-white text-xs font-bold">{{ strtoupper(substr($teacher->user?->name ?? '?', 0, 2)) }}</span>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-slate-800 dark:text-slate-200">{{ $teacher->user?->name ?? '—' }}</p>
                                <p class="text-[10px] text-slate-400">{{ $teacher->user?->email ?? '' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 font-mono text-xs">{{ $teacher->nip ?? '—' }}</td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-400 px-2 py-0.5 rounded">{{ $teacher->subject ?? '—' }}</span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="{{ route('admin.teachers.show', $teacher->id) }}"
                               class="text-xs bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 px-2.5 py-1.5 rounded-lg transition-colors">Info</a>
                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}"
                               class="text-xs bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 text-blue-600 dark:text-blue-400 px-2.5 py-1.5 rounded-lg transition-colors">Edit</a>
                            <form method="POST" action="{{ route('admin.teachers.destroy', $teacher->id) }}" onsubmit="return confirm('Hapus guru ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs bg-red-50 dark:bg-red-900/20 hover:bg-red-100 text-red-600 dark:text-red-400 px-2.5 py-1.5 rounded-lg transition-colors">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-5 py-12 text-center text-slate-400">Belum ada data guru</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-700">{{ $teachers->links() }}</div>
</div>
@endsection
