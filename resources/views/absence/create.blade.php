@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-semibold text-gray-900">Formulir Izin</h1>
    <div class="mt-4 bg-white rounded-lg shadow p-4">
        <form method="POST" action="{{ route('izin.store') }}" enctype="multipart/form-data" x-data="{ type: '{{ old('type', 'izin') }}' }">
            @csrf
            @php $myStudent = \App\Models\Student::where('user_id', auth()->id())->first(); @endphp
            <input type="hidden" name="student_id" value="{{ $myStudent?->id ?? '' }}">
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Siswa</label>
                    <div class="w-full border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 rounded-lg px-3 py-2.5 text-sm text-slate-600 dark:text-slate-400">
                        {{ auth()->user()->name }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Tanggal</label>
                    <input type="date" name="date" value="{{ old('date', today()->toDateString()) }}" required class="mt-1 block w-full border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Jenis</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-200">
                            <input type="radio" name="type" value="izin" x-model="type" class="sr-only" {{ old('type', 'izin') === 'izin' ? 'checked' : '' }}>
                            Izin
                        </label>
                        <label class="cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-200">
                            <input type="radio" name="type" value="sakit" x-model="type" class="sr-only" {{ old('type') === 'sakit' ? 'checked' : '' }}>
                            Sakit
                        </label>
                    </div>
                </div>
                <div x-show="type === 'izin'" x-cloak>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Durasi Izin</label>
                    <select name="duration_days" class="mt-1 block w-full border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                        @php $maxDays = \App\Models\AbsenceSetting::current()->max_izin_days; @endphp
                        @for($d = 1; $d <= $maxDays; $d++)
                        <option value="{{ $d }}" {{ old('duration_days') == $d ? 'selected' : '' }}>{{ $d }} hari</option>
                        @endfor
                    </select>
                </div>
                <div x-show="type === 'sakit'" x-cloak>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Durasi Sakit</label>
                    <input type="text" name="duration_days" value="0" readonly
                           class="mt-1 block w-full border border-slate-200 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-700/50 text-slate-500 px-3 py-2 text-sm" />
                    <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">Durasi sakit ditentukan oleh admin/wali kelas</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Keterangan</label>
                    <textarea name="reason" rows="3" required class="mt-1 block w-full border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500/30">{{ old('reason') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Tanda Tangan Orang Tua</label>
                    <input type="file" name="parent_signature" class="mt-1 block w-full text-sm text-slate-700 dark:text-slate-200" />
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Kirim</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection