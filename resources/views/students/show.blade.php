@extends('layouts.app')

@section('title', 'Detail Siswa')
@section('content')

<div class="max-w-3xl space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Detail Siswa</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Informasi lengkap dan status kas siswa.</p>
        </div>
        <a href="{{ route('students.index') }}" class="text-sm text-blue-600 hover:underline">Kembali ke daftar</a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="h-28 bg-gradient-to-r from-blue-700 to-slate-900"></div>
        <div class="p-6 -mt-10">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 rounded-3xl bg-blue-600 flex items-center justify-center text-white text-2xl font-bold">
                    {{ strtoupper(substr($student->user->name ?? '??', 0, 2)) }}
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">{{ $student->user->name ?? '—' }}</h2>
                    <p class="text-sm text-slate-400 dark:text-slate-500">NIS: {{ $student->nis ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl bg-slate-50 dark:bg-slate-700/50 p-4">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Kelas</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $student->class ?? '-' }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 dark:bg-slate-700/50 p-4">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Email</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900 dark:text-slate-100 truncate">{{ $student->user->email ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl bg-slate-50 dark:bg-slate-700/50 p-4">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Posisi Kursi</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900 dark:text-slate-100">
                        @if($student->seat_position)
                            @php $pos = is_string($student->seat_position) ? json_decode($student->seat_position, true) : $student->seat_position; @endphp
                            Baris {{ $pos['row'] ?? '—' }}, Kolom {{ $pos['col'] ?? '—' }}
                        @else
                            Belum diatur
                        @endif
                    </p>
                </div>
                <div class="rounded-3xl bg-slate-50 dark:bg-slate-700/50 p-4">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Status Kas</p>
                    @php $unpaid = \App\Models\KasTransaction::where('student_id', $student->id)->where('status', 'unpaid')->count(); @endphp
                    <p class="mt-3 text-lg font-semibold {{ $unpaid > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-300' }}">
                        {{ $unpaid > 0 ? $unpaid . ' minggu belum bayar' : 'Lunas' }}
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Riwayat Absensi Terakhir</h3>
                <div class="mt-4 space-y-3">
                    @forelse(\App\Models\Absence::where('student_id', $student->id)->latest()->limit(5)->get() as $abs)
                    <div class="rounded-3xl bg-slate-50 dark:bg-slate-700/50 p-4 flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ ucfirst($abs->type) }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ \Carbon\Carbon::parse($abs->date)->isoFormat('D MMM Y') }}</p>
                        </div>
                        <span class="text-[10px] rounded-full px-2 py-1 font-semibold {{ $abs->status === 'approved' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($abs->status === 'rejected' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400') }}">
                            {{ ucfirst($abs->status) }}
                        </span>
                    </div>
                    @empty
                    <p class="text-sm text-slate-400 dark:text-slate-500">Belum ada catatan absensi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection