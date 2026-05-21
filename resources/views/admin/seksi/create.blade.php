@extends('layouts.admin')
@section('title', 'Buat Seksi Kegiatan')
@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.seksi.index') }}" class="w-10 h-10 inline-flex items-center justify-center rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-500 hover:text-slate-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Buat Seksi Kegiatan</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Tambahkan seksi baru dan atur anggota.</p>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-6">
        <form action="{{ route('admin.seksi.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Seksi</label>
                <input type="text" name="name" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30" />
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Kategori</label>
                <input type="text" name="category" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30" />
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30"></textarea>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Ketua Seksi</label>
                <select name="ketua_id" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                    <option value="">Pilih ketua (opsional)</option>
                    @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->user->name ?? '—' }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Anggota</label>
                <select name="member_ids[]" multiple class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                    @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ in_array($student->id, old('member_ids', [])) ? 'selected' : '' }}>{{ $student->user->name ?? '—' }}</option>
                    @endforeach
                </select>
                <p class="mt-2 text-xs text-slate-400">Tekan Ctrl/Cmd untuk memilih lebih dari satu siswa.</p>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                <a href="{{ route('admin.seksi.index') }}" class="rounded-2xl border border-slate-200 dark:border-slate-700 px-4 py-3 text-sm text-slate-500 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-900 transition">Batal</a>
                <button type="submit" class="rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
