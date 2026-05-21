@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

{{-- BANNER SLIDER --}}
@php
try {
    $activeBanners = \App\Models\Banner::where('is_active', true)->orderBy('order')->get();
} catch (\Exception $e) {
    $activeBanners = collect();
}
@endphp

@if($activeBanners->count() > 0)
<div class="relative rounded-2xl overflow-hidden mb-6"
     style="height:200px;"
     x-data="{
         current: 0,
         total: {{ $activeBanners->count() }},
         timer: null,
         init() {
             this.timer = setInterval(() => {
                 this.current = (this.current + 1) % this.total;
             }, 5000);
         },
         prev() { this.current = (this.current - 1 + this.total) % this.total; },
         next() { this.current = (this.current + 1) % this.total; }
     }"
     x-init="init()">

    {{-- Slides --}}
    @foreach($activeBanners as $i => $banner)
    <div x-show="current === {{ $i }}"
         x-transition:enter="transition-opacity duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute inset-0"
         style="display:none;">
        @if($banner->image_path)
        <img src="{{ Storage::url($banner->image_path) }}" class="w-full h-full object-cover">
        @else
        <div class="w-full h-full" style="background:linear-gradient(135deg,#1a2744,#2563eb);"></div>
        @endif
        <div class="absolute inset-0" style="background:linear-gradient(to right, rgba(26,39,68,0.75) 0%, rgba(26,39,68,0.2) 60%, transparent 100%);"></div>
        <div class="absolute bottom-0 left-0 p-6">
            <h2 class="text-white text-xl font-semibold">{{ $banner->title }}</h2>
            @if($banner->link)
            <a href="{{ $banner->link }}" target="_blank" class="text-blue-300 text-sm mt-1 inline-block hover:underline">Lihat selengkapnya →</a>
            @endif
        </div>
    </div>
    @endforeach

    {{-- Prev/Next arrows --}}
    @if($activeBanners->count() > 1)
    <button @click="prev()" class="absolute left-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/30 hover:bg-black/50 flex items-center justify-center text-white transition-colors z-10">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button @click="next()" class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/30 hover:bg-black/50 flex items-center justify-center text-white transition-colors z-10">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>

    {{-- Dots --}}
    <div class="absolute bottom-3 right-4 flex gap-1.5 z-10">
        @foreach($activeBanners as $i => $banner)
        <button @click="current = {{ $i }}"
                :class="current === {{ $i }} ? 'w-5 bg-white' : 'w-2 bg-white/50'"
                class="h-2 rounded-full transition-all duration-300">
        </button>
        @endforeach
    </div>
    @endif
</div>

@else
{{-- Fallback greeting when no banners --}}
<div class="rounded-2xl overflow-hidden mb-6 relative" style="height:180px;background:linear-gradient(135deg,#1a2744 0%,#2563eb 100%);">
    <div class="relative p-6 flex items-center justify-between h-full">
        <div>
            <p class="text-blue-200 text-xs font-medium uppercase tracking-wider mb-1">Selamat Datang</p>
            <h2 class="text-white text-2xl font-semibold">{{ auth()->user()->name }}</h2>
            <p class="text-blue-200 text-sm mt-1">{{ \Carbon\Carbon::now('Asia/Jakarta')->isoFormat('dddd, D MMMM Y') }}</p>
            @if(isset($activeLesson) && $activeLesson)
            <div class="mt-2">
                <span class="bg-white/20 text-white text-xs px-2.5 py-1 rounded-full">
                    Aktif: {{ $activeLesson->lesson_name }} · {{ \Carbon\Carbon::parse($activeLesson->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($activeLesson->end_time)->format('H:i') }}
                </span>
            </div>
            @endif
        </div>
        <div class="hidden md:block opacity-20">
            <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m0-6l-6.16 3.422a12.083 12.083 0 01.665 6.479"/>
            </svg>
        </div>
    </div>
</div>
@endif

@if($student)
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
    <div class="lg:col-span-3 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-6">
        <p class="text-sm text-slate-500 dark:text-slate-400">Selamat datang,</p>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-2">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $user->name }}</h1>
                <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-slate-500 dark:text-slate-400">
                    <span class="rounded-full bg-slate-100 dark:bg-slate-900 px-3 py-1">{{ $student->class ?? 'Kelas tidak tersedia' }}</span>
                    <span class="font-mono">NIS: {{ $student->nis ?? '—' }}</span>
                </div>
            </div>
            <div class="text-sm text-slate-500 dark:text-slate-400">
                {{ now()->timezone('Asia/Jakarta')->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mb-6">
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">Kas Kelas</p>
            <div class="w-9 h-9 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-semibold text-slate-800 dark:text-slate-100">Rp {{ number_format($kasBalance, 0, ',', '.') }}</p>
        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Saldo kas kelas saat ini</p>
        <button type="button" onclick="openPaymentModal()" class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white py-2.5 rounded-xl text-sm font-semibold transition-colors">Bayar Kas</button>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">Absensi Bulan Ini</p>
            <div class="w-9 h-9 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2H9zM9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
            </div>
        </div>
        <p class="text-3xl font-semibold text-slate-800 dark:text-slate-100">{{ $absensiCount }}</p>
        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">izin bulan ini</p>
        @if($absSetting)
        <div class="mt-3 text-[11px] text-slate-500 dark:text-slate-400">Batas: {{ $absSetting->max_izin_days }} hari</div>
        @endif
        @if($absensiLast)
        <div class="mt-3 rounded-2xl bg-slate-50 dark:bg-slate-900 p-3 text-xs text-slate-600 dark:text-slate-300">
            Terakhir: <span class="font-semibold">{{ ucfirst($absensiLast->status) }}</span>
        </div>
        @endif
        <a href="{{ route('izin.create') }}" class="mt-4 inline-flex w-full items-center justify-center bg-amber-500 hover:bg-amber-600 text-white py-2.5 rounded-xl text-sm font-semibold transition-colors">Ajukan Izin</a>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">Seksi Kegiatan</p>
            <div class="w-9 h-9 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>
        @if($mySeksi->count())
        <ul class="space-y-3">
            @foreach($mySeksi as $s)
            <li class="rounded-2xl border border-slate-200 dark:border-slate-700 p-3 text-sm text-slate-700 dark:text-slate-200">
                <div class="font-medium">{{ $s->name }}</div>
                <div class="text-xs text-slate-500 dark:text-slate-400">Ketua: {{ $s->ketua?->user?->name ?? '—' }}</div>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-sm text-slate-500 dark:text-slate-400">Belum bergabung dengan seksi kegiatan.</p>
        @endif
    </div>
</div>
@endif

{{-- STATS CARDS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 p-4 flex items-start gap-3 shadow-sm hover:shadow-md transition-shadow">
        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-500 dark:text-slate-400">Total Siswa</p>
            <p class="text-xl font-semibold text-slate-800 dark:text-slate-100 mt-0.5">{{ $totalStudents }}</p>
            <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">siswa terdaftar</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 p-4 flex items-start gap-3 shadow-sm hover:shadow-md transition-shadow">
        <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-500 dark:text-slate-400">Kas Terkumpul</p>
            <p class="text-lg font-semibold text-slate-800 dark:text-slate-100 mt-0.5 truncate">Rp {{ number_format($kasCollected, 0, ',', '.') }}</p>
            <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">terkumpul</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 p-4 flex items-start gap-3 shadow-sm hover:shadow-md transition-shadow">
        <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-500 dark:text-slate-400">Nilai Investasi</p>
            <p class="text-lg font-semibold text-slate-800 dark:text-slate-100 mt-0.5 truncate">Rp {{ number_format($investmentValue, 0, ',', '.') }}</p>
            <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">obligasi kelas</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 p-4 flex items-start gap-3 shadow-sm hover:shadow-md transition-shadow">
        <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-500 dark:text-slate-400">Kas Belum Bayar</p>
            <p class="text-xl font-semibold text-slate-800 dark:text-slate-100 mt-0.5">{{ $unpaidKas }}</p>
            <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">perlu perhatian</p>
        </div>
    </div>
</div>

{{-- CHARTS ROW --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Pemasukan Kas</h3>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">8 minggu terakhir</p>
            </div>
            <span class="text-xs bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 px-2 py-1 rounded-full font-medium">
                Rp {{ number_format($kasChartData->sum(), 0, ',', '.') }}
            </span>
        </div>
        <canvas id="kasChart" height="180"></canvas>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Pertumbuhan Investasi</h3>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Simulasi obligasi (12 bulan)</p>
            </div>
            <span class="text-xs bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 px-2 py-1 rounded-full font-medium">Fixed Rate</span>
        </div>
        <canvas id="investChart" height="180"></canvas>
    </div>
</div>

{{-- TWO COLUMN GRID --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">
    {{-- SEAT LAYOUT --}}
    <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm">
        <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">Denah Tempat Duduk</h3>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Klik kursi untuk melihat detail siswa</p>
            </div>
            <span class="text-xs bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full font-medium">{{ $seatLayout->count() }} kursi</span>
        </div>
        <div class="p-5" x-data="{
            selected: null,
            student: null,
            selectSeat(id, data) {
                if (this.selected === id) {
                    this.selected = null;
                    this.student = null;
                    return;
                }
                this.selected = id;
                this.student = data;
            }
        }">
            <div class="grid gap-2" style="grid-template-columns: repeat(auto-fill, minmax(72px, 1fr));">
                @forelse($seatLayout as $seat)
                @php
                    $studentData = $seat->student ? [
                        'name' => $seat->student->user->name ?? '—',
                        'nis' => $seat->student->nis ?? '—',
                        'class' => $seat->student->class ?? '—',
                        'avatar' => strtoupper(substr($seat->student->user->name ?? '?', 0, 2)),
                    ] : null;
                @endphp
                <button
                    @click="selectSeat({{ $seat->id }}, @json($studentData))"
                    :class="selected === {{ $seat->id }} ? 'ring-2 ring-blue-500 scale-105 bg-blue-600 text-white border-blue-600' : '{{ $seat->student_id ? 'bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-100 dark:bg-slate-700/50 dark:text-slate-200 dark:border-slate-700' : 'bg-slate-50 text-slate-400 border-slate-200 dark:bg-slate-700/50 dark:text-slate-500 dark:border-slate-700' }}'"
                    class="border rounded-lg py-2 px-1 text-[10px] font-medium transition-all text-center leading-tight">
                    {{ $seat->student ? \Illuminate\Support\Str::limit($seat->student->user->name ?? '—', 8) : 'Kosong' }}
                    <div class="text-[8px] opacity-60 mt-0.5">R{{ $seat->row }}C{{ $seat->col }}</div>
                </button>
                @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-xs text-slate-400">Belum ada denah kursi</p>
                </div>
                @endforelse
            </div>
            <div x-show="student !== null" x-transition class="mt-5 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800" style="display:none;">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-base flex-shrink-0" x-text="student?.avatar"></div>
                    <div>
                        <p class="font-semibold text-slate-800 dark:text-slate-100 text-sm" x-text="student?.name"></p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">NIS: <span x-text="student?.nis"></span></p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Kelas: <span x-text="student?.class"></span></p>
                    </div>
                    <button @click="selected = null; student = null" class="ml-auto text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @forelse($announcements as $ann)
            @php
                $typeStyle = match($ann->type ?? 'info') {
                    'warning' => 'border-amber-400 bg-amber-50',
                    'danger'  => 'border-red-400 bg-red-50',
                    default   => 'border-blue-400 bg-blue-50',
                };
                $typeText = match($ann->type ?? 'info') {
                    'warning' => 'text-amber-700',
                    'danger'  => 'text-red-700',
                    default   => 'text-blue-700',
                };
            @endphp
            <div class="border-l-4 {{ $typeStyle }} rounded-r-lg p-3">
                <p class="text-xs font-semibold {{ $typeText }}">{{ $ann->title }}</p>
                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1">{{ $ann->creator->name ?? '—' }} · {{ \Carbon\Carbon::parse($ann->published_at ?? $ann->created_at)->timezone('Asia/Jakarta')->format('H:i') }}</p>
            </div>
            @empty
            <div class="text-center py-8">
                <p class="text-xs text-slate-400 dark:text-slate-500">Belum ada pengumuman</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- BOTTOM ROW --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    {{-- PIKET --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm">
        <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">Piket Hari Ini</h3>
        </div>
        <div class="p-4 space-y-2">
            @forelse($piket as $piketItem)
            <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-slate-700 flex items-center justify-center text-blue-700 dark:text-blue-300 text-xs font-semibold flex-shrink-0">
                    {{ strtoupper(substr($piketItem->student->user->name ?? '?', 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-slate-800 dark:text-slate-200 font-medium truncate">{{ $piketItem->student->user->name ?? '—' }}</p>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full font-medium flex-shrink-0
                    {{ $piketItem->status === 'hadir' ? 'bg-green-50 text-green-700' : ($piketItem->status === 'terlambat' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-600') }}">
                    {{ ucfirst($piketItem->status) }}
                </span>
            </div>
            @empty
            <div class="text-center py-8">
                <p class="text-xs text-slate-400 dark:text-slate-500">Tidak ada piket hari ini</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- JADWAL HARI INI --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm">
        <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">Jadwal Hari Ini</h3>
        </div>
        <div class="p-4">
            <div class="space-y-2">
                @forelse($schedule as $sch)
                @php $isActive = $activeLesson && $activeLesson->id === $sch->id; @endphp
                <div class="flex items-center gap-3 p-2.5 rounded-lg {{ $isActive ? 'bg-blue-50 dark:bg-slate-800 border border-blue-100 dark:border-blue-700' : 'hover:bg-slate-50 dark:hover:bg-slate-700/50' }} transition">
                    <div class="w-1.5 h-8 rounded-full {{ $isActive ? 'bg-blue-500' : 'bg-slate-200 dark:bg-slate-600' }}"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium {{ $isActive ? 'text-blue-800 dark:text-blue-200' : 'text-slate-700 dark:text-slate-200' }} truncate">
                            {{ $sch->lesson_name }}
                            @if($isActive)<span class="ml-1 text-[9px] bg-blue-500 text-white px-1.5 py-0.5 rounded-full">AKTIF</span>@endif
                        </p>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500">{{ \Carbon\Carbon::parse($sch->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($sch->end_time)->format('H:i') }}</p>
                    </div>
                    <span class="text-[10px] text-slate-400 dark:text-slate-500 flex-shrink-0">{{ $sch->teacher_code }}</span>
                </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-xs text-slate-400 dark:text-slate-500">Tidak ada jadwal hari ini</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@include('partials.payment-modal')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const textColor = isDark ? '#94a3b8' : '#64748b';
    const defaultFont = { family: 'Inter, sans-serif', size: 11 };

    new Chart(document.getElementById('kasChart'), {
        type: 'bar',
        data: {
            labels: @json($kasChartLabels),
            datasets: [{
                label: 'Kas Masuk',
                data: @json($kasChartData),
                backgroundColor: 'rgba(37,99,235,0.15)',
                borderColor: '#2563eb',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: { grid: { color: gridColor }, ticks: { color: textColor, font: defaultFont } },
                y: {
                    grid: { color: gridColor },
                    ticks: {
                        color: textColor,
                        font: defaultFont,
                        callback: v => 'Rp ' + (v / 1000) + 'k'
                    }
                }
            }
        }
    });

    const investColors = ['#2563eb', '#7c3aed', '#059669', '#d97706', '#dc2626'];
    const investData = @json($investData);
    const investLabels = @json($investLabels);
    const investments = @json($investments->map(fn($i) => ['name' => $i->name, 'rate_percent' => $i->rate_percent]));

    new Chart(document.getElementById('investChart'), {
        type: 'line',
        data: {
            labels: investLabels,
            datasets: investData.map((d, i) => ({
                label: investments[i]?.name ?? ('Obligasi ' + (i + 1)),
                data: d,
                borderColor: investColors[i % investColors.length],
                backgroundColor: investColors[i % investColors.length] + '15',
                borderWidth: 2,
                pointRadius: 3,
                fill: true,
                tension: 0.4,
            }))
        },
        options: {
            responsive: true,
            plugins: {
                legend: { labels: { color: textColor, font: defaultFont, boxWidth: 12 } },
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.dataset.label + ': Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: { grid: { color: gridColor }, ticks: { color: textColor, font: defaultFont } },
                y: {
                    grid: { color: gridColor },
                    ticks: { color: textColor, font: defaultFont, callback: v => 'Rp ' + (v / 1000) + 'k' }
                }
            }
        }
    });
</script>

@endsection