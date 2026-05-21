@extends('layouts.admin')
@section('title', 'Edit Jadwal')
@section('content')
<div class="max-w-lg">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.schedules.index') }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Edit Jadwal</h1>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm p-6">
        <form method="POST" action="{{ route('admin.schedules.update', $schedule->id) }}" class="space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1.5">Hari</label>
                    <select name="day" required class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                        @foreach($days as $d)
                        <option value="{{ $d }}" {{ $schedule->day===$d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kelas</label>
                    <select name="class_name" required class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                        @foreach($classes as $cls)
                        <option value="{{ $cls }}" {{ $schedule->class_name===$cls ? 'selected' : '' }}>{{ $cls }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Mata Pelajaran</label>
                <input type="text" name="lesson_name" value="{{ old('lesson_name', $schedule->lesson_name) }}" required
                       class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kode Pelajaran</label>
                    <input type="text" name="lesson_code" value="{{ old('lesson_code', $schedule->lesson_code) }}" required
                           class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kode Guru</label>
                    <input type="text" name="teacher_code" value="{{ old('teacher_code', $schedule->teacher_code) }}"
                           class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1.5">Jam Mulai</label>
                    <input type="time" name="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}" required
                           class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1.5">Jam Selesai</label>
                    <input type="time" name="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}" required
                           class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                </div>
            </div>
            <div class="flex gap-3 pt-2 border-t border-slate-100 dark:border-slate-700">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg text-sm font-medium transition-colors">Simpan Perubahan</button>
                <a href="{{ route('admin.schedules.index') }}" class="px-4 py-2.5 text-sm text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
