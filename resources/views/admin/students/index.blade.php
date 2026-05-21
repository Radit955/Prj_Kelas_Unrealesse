@extends('layouts.admin')
@section('title', 'Data Siswa')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Data Siswa</h1>
        <p class="text-xs text-slate-400 mt-0.5">{{ $students->total() }} siswa terdaftar</p>
    </div>
    <a href="{{ route('admin.students.create') }}"
       class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Siswa
    </a>
</div>
<div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-100 dark:border-slate-700">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Siswa</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NIS</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas</th>
                    <th class="text-right px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-700">
                @forelse($students as $student)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full overflow-hidden bg-blue-600 flex items-center justify-center flex-shrink-0">
                                @if($student->user?->avatar)
                                <img src="{{ Storage::url($student->user->avatar) }}" class="w-full h-full object-cover">
                                @else
                                <span class="text-white text-xs font-bold">{{ strtoupper(substr($student->user?->name ?? '?', 0, 2)) }}</span>
                                @endif
                            </div>
                            <p class="font-medium text-slate-800 dark:text-slate-200">{{ $student->user?->name ?? '—' }}</p>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 font-mono text-xs">{{ $student->nis ?? '—' }}</td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 px-2 py-0.5 rounded">{{ $student->class ?? '—' }}</span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="{{ route('admin.students.show', $student->id) }}"
                               class="text-xs bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 px-2.5 py-1.5 rounded-lg transition-colors">
                                Info
                            </a>
                            <a href="{{ route('admin.students.edit', $student->id) }}"
                               class="text-xs bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 text-blue-600 dark:text-blue-400 px-2.5 py-1.5 rounded-lg transition-colors">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.students.destroy', $student->id) }}"
                                  onsubmit="return confirm('Hapus siswa ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs bg-red-50 dark:bg-red-900/20 hover:bg-red-100 text-red-600 dark:text-red-400 px-2.5 py-1.5 rounded-lg transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-5 py-12 text-center text-slate-400">Belum ada data siswa</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-700">{{ $students->links() }}</div>
</div>
@endsection
