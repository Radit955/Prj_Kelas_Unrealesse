@extends('layouts.app')

@section('title', 'Tugas & Catatan')
@section('content')

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Tugas & Catatan</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola tugas kelas, tenggat pengumpulan, dan catatan penting.</p>
        </div>
        {{-- Only ketua, wakil, guru, wali, admin can add --}}
        @if(auth()->user()->hasAnyRole(['ketua_kelas','wakil_kelas','guru','guru_piket','wali_kelas','admin']))
        <button onclick="document.getElementById('taskModal').classList.remove('hidden')"
                class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Tugas Baru
        </button>
        @endif
    </div>

    <div class="grid gap-4 xl:grid-cols-2">
        @foreach($tasks as $task)
        <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-6 hover:-translate-y-0.5 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $task->title }}</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">{{ $task->subject ?? 'Umum' }}</p>
                </div>
                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $task->due_date >= today() ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300' : 'bg-red-100 text-red-700 dark:bg-red-900/20 dark:text-red-300' }}">
                    {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                </span>
            </div>
            <p class="mt-4 text-sm leading-6 text-slate-600 dark:text-slate-300">{{ $task->description ?? 'Tidak ada deskripsi tugas.' }}</p>
            <div class="mt-5 flex items-center justify-between gap-3 text-sm text-slate-500 dark:text-slate-400">
                <span>Status: {{ ucfirst($task->status ?? 'menunggu') }}</span>
                <a href="{{ route('tasks.show', $task) }}" class="font-semibold text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">Lihat detail</a>
            </div>
            {{-- Delete button with role check --}}
            @if(auth()->user()->hasAnyRole(['ketua_kelas','wakil_kelas','admin','wali_kelas']) || auth()->id() === ($task->created_by))
            <div class="flex justify-end mt-2 pt-2 border-t border-slate-100 dark:border-slate-700">
                <form method="POST" action="{{ route('tasks.destroy', $task->id) }}"
                      onsubmit="return confirm('Hapus tugas ini?')">
                    @csrf @method('DELETE')
                    <button class="text-xs text-red-500 hover:text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 px-2 py-1 rounded-lg transition-colors">
                        Hapus
                    </button>
                </form>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <div class="pt-4">{{ $tasks->links() }}</div>
</div>

<div id="taskModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 px-4 py-10">
    <div class="mx-auto max-w-3xl rounded-3xl bg-white dark:bg-slate-800 shadow-2xl overflow-hidden">
        <div class="flex items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-700 px-6 py-4">
            <div>
                <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Buat Tugas Baru</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Isi tugas baru dan beri tenggat waktu.</p>
            </div>
            <button onclick="document.getElementById('taskModal').classList.add('hidden')" class="rounded-full bg-slate-100 dark:bg-slate-700 p-2 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-600 transition">×</button>
        </div>
        <form method="POST" action="{{ route('tasks.store') }}" class="space-y-4 px-6 py-6">
            @csrf
            <div class="grid gap-4 lg:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Judul</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30" />
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Mata Pelajaran</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30" />
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Deskripsi</label>
                <textarea name="description" rows="4" required class="w-full rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30">{{ old('description') }}</textarea>
            </div>
            <div class="grid gap-4 lg:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Batas Waktu</label>
                    <input type="date" name="due_date" value="{{ old('due_date') }}" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30" />
                </div>
                <div class="flex items-center gap-2 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 px-4 py-3">
                    <input type="hidden" name="from_absent_teacher" value="0" />
                    <label class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                        <input type="checkbox" name="from_absent_teacher" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500" {{ old('from_absent_teacher') ? 'checked' : '' }}>
                        Dari guru pengganti
                    </label>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                <button type="button" onclick="document.getElementById('taskModal').classList.add('hidden')" class="rounded-2xl border border-slate-200 dark:border-slate-700 px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Batal</button>
                <button type="submit" class="rounded-2xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">Simpan Tugas</button>
            </div>
        </form>
    </div>
</div>

@endsection