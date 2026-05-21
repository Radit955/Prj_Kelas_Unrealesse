@extends('layouts.admin')
@section('title', 'Edit Guru')
@section('content')
<div class="max-w-lg">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.teachers.index') }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Edit Guru</h1>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm p-6">
        <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1.5">Akun Pengguna</label>
                <select name="user_id" required class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                    @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ $teacher->user_id === $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1.5">NIP</label>
                    <input type="text" name="nip" value="{{ old('nip', $teacher->nip) }}"
                           class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1.5">Mata Pelajaran</label>
                    <input type="text" name="subject" value="{{ old('subject', $teacher->subject) }}" required
                           class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                </div>
            </div>
            <div class="flex gap-3 pt-2 border-t border-slate-100 dark:border-slate-700">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg text-sm font-medium transition-colors">Simpan Perubahan</button>
                <a href="{{ route('admin.teachers.index') }}" class="px-4 py-2.5 text-sm text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
