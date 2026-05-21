@extends('layouts.admin')
@section('title','Catat Transaksi Kas')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.kas.index') }}" class="w-10 h-10 inline-flex items-center justify-center rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-500 hover:text-slate-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Catat Transaksi Kas</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Tambahkan transaksi kas kelas baru.</p>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-6">
        <form action="{{ route('admin.kas.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Siswa</label>
                <select name="student_id" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->user?->name }} ({{ $student->nis }})</option>
                    @endforeach
                </select>
                @error('student_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Jumlah</label>
                    <input type="number" name="amount" value="{{ old('amount') }}" min="1" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30" />
                    @error('amount')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Minggu</label>
                    <input type="number" name="week" value="{{ old('week') }}" min="1" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30" />
                    @error('week')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Metode</label>
                <select name="method" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                    <option value="qris" {{ old('method') === 'qris' ? 'selected' : '' }}>QRIS</option>
                    <option value="cash" {{ old('method') === 'cash' ? 'selected' : '' }}>Cash</option>
                </select>
                @error('method')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Status</label>
                <select name="status" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                    <option value="paid" {{ old('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ old('status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
                @error('status')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                <a href="{{ route('admin.kas.index') }}" class="rounded-2xl border border-slate-200 dark:border-slate-700 px-4 py-3 text-sm text-slate-500 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-900 transition">Batal</a>
                <button type="submit" class="rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
