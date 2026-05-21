@extends('layouts.admin')
@section('title', 'Kas Kelas')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-lg font-semibold text-slate-800">Kas Kelas</h1>
        <p class="text-xs text-slate-500 mt-0.5">Kelola transaksi kas kelas</p>
    </div>
</div>

{{-- MOST WANTED (Top 3 Unpaid) --}}
@php $unpaidTop3 = $kasTransactions->where('status', 'unpaid')->sortByDesc('amount')->take(3); @endphp
@if($unpaidTop3->count() > 0)
<div class="mb-6">
    <h2 class="text-sm font-semibold text-slate-800 mb-3">🚨 Perlu Perhatian - Kas Belum Bayar</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($unpaidTop3 as $kas)
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-700 font-semibold text-sm flex-shrink-0">
                    {{ strtoupper(substr($kas->student->user->name ?? 'Unknown', 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-800 truncate">{{ $kas->student->user->name ?? '—' }}</p>
                    <p class="text-xs text-slate-500">Minggu {{ $kas->week }}</p>
                </div>
            </div>
            <p class="text-lg font-bold text-red-700">Rp {{ number_format($kas->amount, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-500 mt-1">{{ $kas->method ?? 'Transfer' }}</p>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- FULL TABLE --}}
<div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
        <input type="text" placeholder="Cari siswa..." class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-1.5 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
        <span class="text-xs text-slate-500 font-medium">Total: Rp {{ number_format($kasTransactions->sum('amount'), 0, ',', '.') }}</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Minggu</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Jumlah</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Metode</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Terbayar</th>
                    <th class="text-right px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($kasTransactions->sortByDesc('created_at') as $kas)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-semibold flex-shrink-0">
                                {{ strtoupper(substr($kas->student->user->name ?? 'Unknown', 0, 2)) }}
                            </div>
                            <span class="text-slate-700 font-medium">{{ $kas->student->user->name ?? '—' }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600">W{{ $kas->week }}</td>
                    <td class="px-5 py-3.5 font-medium text-slate-800">Rp {{ number_format($kas->amount, 0, ',', '.') }}</td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs">{{ $kas->method ?? 'Transfer' }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $kas->status === 'paid' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-600' }}">
                            {{ ucfirst($kas->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs">
                        @if($kas->paid_at)
                        {{ $kas->paid_at->timezone('Asia/Jakarta')->format('d M Y') }}
                        @else
                        —
                        @endif
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center justify-end gap-2">
                            @if($kas->status === 'unpaid')
                            <form method="POST" action="{{ route('admin.kas.update', $kas) }}" class="inline">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="paid">
                                <button type="submit" class="text-xs bg-green-50 hover:bg-green-100 text-green-600 px-3 py-1.5 rounded-lg transition">Tandai Bayar</button>
                            </form>
                            @else
                            <span class="text-xs text-slate-400">—</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center text-slate-400 text-sm">Belum ada transaksi kas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
