@extends('layouts.app')

@section('title', 'Data Siswa')
@section('content')

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Data Siswa</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $students->total() }} siswa terdaftar dalam sistem.</p>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        @forelse($students as $student)
        @php $letter = strtoupper(substr($student->user->name ?? '??', 0, 2)); $color = ['#2563eb','#7c3aed','#059669','#d97706','#dc2626','#0891b2'][$loop->index % 6]; @endphp
        <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm overflow-hidden hover:-translate-y-0.5 hover:shadow-md transition-all">
            <div class="relative h-28 flex items-center justify-center" style="background: linear-gradient(135deg, {{ $color }}20, {{ $color }}0);">
                <div class="w-16 h-16 rounded-full bg-white shadow-md flex items-center justify-center text-xl font-bold text-slate-900" style="color: {{ $color }};">
                    {{ $letter }}
                </div>
            </div>
            <div class="p-4">
                <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100 truncate">{{ $student->user->name ?? '—' }}</h2>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">NIS: {{ $student->nis ?? '-' }}</p>
                <p class="text-xs text-slate-400 dark:text-slate-500">Kelas: {{ $student->class ?? '-' }}</p>
                <a href="{{ route('students.show', $student) }}" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 px-3 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                    Detail Siswa
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full rounded-3xl border border-slate-200 bg-white dark:bg-slate-800 dark:border-slate-700 p-10 text-center text-slate-400">
            Belum ada siswa terdaftar.
        </div>
        @endforelse
    </div>

    <div class="pt-4">{{ $students->links() }}</div>
</div>

@endsection