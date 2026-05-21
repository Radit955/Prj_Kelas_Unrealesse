@extends('layouts.admin')
@section('title', 'Izin & Absensi')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-lg font-semibold text-slate-800">Izin & Absensi</h1>
        <p class="text-xs text-slate-500 mt-0.5">Kelola pengajuan izin dan sakit siswa</p>
    </div>
</div>

{{-- TABLE --}}
<div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3">
        <input type="text" placeholder="Cari siswa..." class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-1.5 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Siswa</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tipe</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Alasan</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="text-right px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($absences as $absence)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 text-xs font-semibold flex-shrink-0">
                                {{ strtoupper(substr($absence->student->user->name ?? 'Unknown', 0, 2)) }}
                            </div>
                            <span class="text-slate-700 font-medium">{{ $absence->student->user->name ?? '—' }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600">{{ \Carbon\Carbon::parse($absence->date)->timezone('Asia/Jakarta')->format('d M Y') }}</td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $absence->type === 'sakit' ? 'bg-red-50 text-red-700' : 'bg-blue-50 text-blue-700' }}">
                            {{ ucfirst($absence->type) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs">
                        {{ \Illuminate\Support\Str::limit($absence->reason ?? '—', 30) }}
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full
                            {{ $absence->status === 'approved' ? 'bg-green-50 text-green-700' : ($absence->status === 'rejected' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-700') }}">
                            {{ ucfirst($absence->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center justify-end gap-2">
                            @if($absence->status === 'pending')
                            <form method="POST" action="{{ route('admin.absences.approve', $absence->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs bg-green-50 hover:bg-green-100 text-green-600 px-3 py-1.5 rounded-lg transition">Setujui</button>
                            </form>
                            <form method="POST" action="{{ route('admin.absences.reject', $absence->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg transition">Tolak</button>
                            </form>
                            @else
                            <span class="text-xs text-slate-400">—</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-slate-400 text-sm">Belum ada pengajuan izin/sakit</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $absences->links() }}
    </div>
</div>

@endsection
