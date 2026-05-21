@extends('layouts.admin')
@section('title', 'Kelola Jadwal')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Jadwal Pelajaran</h1>
        <p class="text-xs text-slate-400 mt-0.5">Kelola jadwal per hari dan kelas</p>
    </div>
    <a href="{{ route('admin.schedules.create') }}"
       class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Jadwal
    </a>
</div>

@php
$days = ['SENIN','SELASA','RABU','KAMIS','JUMAT'];
$dayColors = ['SENIN'=>'#2563eb','SELASA'=>'#7c3aed','RABU'=>'#059669','KAMIS'=>'#d97706','JUMAT'=>'#dc2626'];
@endphp

@foreach($days as $day)
@php $daySchedules = $schedules->get($day, collect()); $color = $dayColors[$day]; @endphp
<div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden mb-4">
    <div class="px-5 py-3 flex items-center justify-between border-b border-slate-100 dark:border-slate-700"
         style="border-left:4px solid {{ $color }};">
        <div class="flex items-center gap-3">
            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $day }}</h3>
            <span class="text-xs text-slate-400">{{ $daySchedules->count() }} sesi</span>
        </div>
        <a href="{{ route('admin.schedules.create') }}?day={{ $day }}"
           class="text-xs text-white px-2.5 py-1 rounded-lg transition-colors"
           style="background:{{ $color }};">
            + Tambah
        </a>
    </div>
    @if($daySchedules->isEmpty())
    <div class="px-5 py-6 text-center text-slate-400 text-sm">Belum ada jadwal untuk hari {{ $day }}</div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 dark:bg-slate-700/30">
                <tr>
                    <th class="text-left px-4 py-2.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Waktu</th>
                    <th class="text-left px-4 py-2.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mata Pelajaran</th>
                    <th class="text-left px-4 py-2.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode</th>
                    <th class="text-left px-4 py-2.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas</th>
                    <th class="text-left px-4 py-2.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Guru</th>
                    <th class="text-right px-4 py-2.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-700">
                @foreach($daySchedules as $sch)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="px-4 py-3">
                        <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">
                            {{ \Carbon\Carbon::parse($sch->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($sch->end_time)->format('H:i') }}
                        </span>
                    </td>
                    <td class="px-4 py-3 font-medium text-slate-700 dark:text-slate-300">{{ $sch->lesson_name }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs font-mono px-2 py-0.5 rounded text-white" style="background:{{ $color }};">{{ $sch->lesson_code }}</span>
                    </td>
                    <td class="px-4 py-3 text-xs text-slate-500 dark:text-slate-400">{{ $sch->class_name }}</td>
                    <td class="px-4 py-3 text-xs text-slate-500 dark:text-slate-400">{{ $sch->teacher_code ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="{{ route('admin.schedules.edit', $sch->id) }}"
                               class="text-xs bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 text-blue-600 dark:text-blue-400 px-2.5 py-1.5 rounded-lg transition-colors">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.schedules.destroy', $sch->id) }}"
                                  onsubmit="return confirm('Hapus jadwal {{ addslashes($sch->lesson_name) }}?')">
                                @csrf @method('DELETE')
                                <button class="text-xs bg-red-50 dark:bg-red-900/20 hover:bg-red-100 text-red-600 dark:text-red-400 px-2.5 py-1.5 rounded-lg transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endforeach
@endsection
