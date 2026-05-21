@extends('layouts.admin')
@section('title', 'Kelola Piket')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Jadwal Piket</h1>
        <p class="text-xs text-slate-400 mt-0.5">Atur jadwal piket harian siswa Senin–Jumat</p>
    </div>
</div>

@php
$days = ['SENIN','SELASA','RABU','KAMIS','JUMAT'];
$dayColors = ['SENIN'=>'#2563eb','SELASA'=>'#7c3aed','RABU'=>'#059669','KAMIS'=>'#d97706','JUMAT'=>'#dc2626'];
$dayNumbers = ['SENIN'=>1,'SELASA'=>2,'RABU'=>3,'KAMIS'=>4,'JUMAT'=>5];
// Group by day-of-week label
$piketGrouped = \App\Models\PiketAssignment::with('student.user')
    ->orderByDesc('date')
    ->get()
    ->groupBy(function($p) {
        $dayId = \Carbon\Carbon::parse($p->date)->dayOfWeekIso; // 1=Mon...5=Fri
        $map = [1=>'SENIN',2=>'SELASA',3=>'RABU',4=>'KAMIS',5=>'JUMAT',6=>'SABTU',7=>'MINGGU'];
        return $map[$dayId] ?? 'LAINNYA';
    });
@endphp

<div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
    @foreach($days as $day)
    @php $color = $dayColors[$day]; $dayPikets = $piketGrouped->get($day, collect())->unique('student_id'); @endphp
    <div class="bg-white dark:bg-slate-800 rounded-xl border-2 overflow-hidden shadow-sm" style="border-color:{{ $color }}30;"
         x-data="{ addOpen: false }">
        {{-- Day header --}}
        <div class="px-3 py-2.5 flex items-center justify-between" style="background:{{ $color }};">
            <span class="text-xs font-bold text-white tracking-wider">{{ $day }}</span>
            <button @click="addOpen = !addOpen"
                    class="w-5 h-5 rounded bg-white/25 hover:bg-white/40 flex items-center justify-center text-white transition-colors">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!addOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    <path x-show="addOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Add form --}}
        <div x-show="addOpen" x-transition class="p-3 border-b border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/50" style="display:none;">
            <form method="POST" action="{{ route('admin.piket.store') }}" class="space-y-2">
                @csrf
                <input type="hidden" name="day_name" value="{{ $day }}">
                {{-- Pick next occurrence of this day --}}
                @php
                $targetDay = $dayNumbers[$day];
                $d = \Carbon\Carbon::now();
                while ($d->dayOfWeekIso !== $targetDay) { $d->addDay(); }
                @endphp
                <div>
                    <label class="text-[10px] text-slate-500 dark:text-slate-400 font-medium block mb-1">Tanggal</label>
                    <input type="date" name="date" value="{{ $d->toDateString() }}" required
                           class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg px-2 py-1.5 text-xs text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                </div>
                <div>
                    <label class="text-[10px] text-slate-500 dark:text-slate-400 font-medium block mb-1">Siswa</label>
                    <select name="student_id" required class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg px-2 py-1.5 text-xs text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                        <option value="">Pilih siswa</option>
                        @foreach($students as $s)
                        <option value="{{ $s->id }}">{{ $s->user->name ?? '—' }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-[10px] text-slate-500 dark:text-slate-400 font-medium block mb-1">Status</label>
                    <select name="status" class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg px-2 py-1.5 text-xs text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                        <option value="hadir">Hadir</option>
                        <option value="terlambat">Terlambat</option>
                        <option value="alpha">Alpha</option>
                    </select>
                </div>
                <button type="submit" class="w-full py-1.5 rounded-lg text-xs font-semibold text-white transition-colors" style="background:{{ $color }};">
                    Tambah
                </button>
            </form>
        </div>

        {{-- Piket list --}}
        <div class="p-3 min-h-[120px] space-y-1.5">
            @forelse($dayPikets as $p)
            <div class="flex items-center gap-2 p-1.5 rounded-lg bg-slate-50 dark:bg-slate-700/50 group">
                <div class="w-6 h-6 rounded-full flex items-center justify-center text-[9px] font-bold text-white flex-shrink-0" style="background:{{ $color }};">
                    {{ strtoupper(substr($p->student->user->name ?? '?', 0, 1)) }}
                </div>
                <p class="text-xs text-slate-700 dark:text-slate-300 flex-1 truncate leading-tight">
                    {{ $p->student->user->name ?? '—' }}
                    <span class="block text-[9px] text-slate-400">{{ \Carbon\Carbon::parse($p->date)->format('d M') }}</span>
                </p>
                <span class="text-[8px] px-1 py-0.5 rounded font-semibold flex-shrink-0
                    {{ $p->status==='hadir' ? 'bg-green-100 text-green-700' : ($p->status==='terlambat' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-600') }}">
                    {{ ucfirst($p->status) }}
                </span>
                <form method="POST" action="{{ route('admin.piket.destroy', $p->id) }}"
                      onsubmit="return confirm('Hapus piket ini?')"
                      class="opacity-0 group-hover:opacity-100 transition-opacity">
                    @csrf @method('DELETE')
                    <button class="text-red-400 hover:text-red-600 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
            @empty
            <div class="text-center py-6">
                <p class="text-[10px] text-slate-400">Belum ada piket</p>
                <button @click="addOpen = true" class="text-[10px] font-medium mt-1" style="color:{{ $color }};">+ Tambah</button>
            </div>
            @endforelse
        </div>
    </div>
    @endforeach
</div>
@endsection
