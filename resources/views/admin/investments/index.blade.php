@extends('layouts.admin')
@section('title', 'Manajemen Investasi')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-lg font-semibold text-slate-800">Manajemen Investasi</h1>
        <p class="text-xs text-slate-500 mt-0.5">Kelola data investasi siswa</p>
    </div>
    <a href="{{ route('admin.investments.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
        <span>+</span> Tambah Investasi
    </a>
</div>

{{-- TABLE --}}
<div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Siswa</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Jumlah Investasi</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nilai Saat Ini</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal Input</th>
                    <th class="text-right px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($investments as $investment)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 text-xs font-semibold flex-shrink-0">
                                {{ strtoupper(substr($investment->student->user->name ?? 'Unknown', 0, 2)) }}
                            </div>
                            <span class="text-slate-700 font-medium">{{ $investment->student->user->name ?? '—' }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600 font-medium">Rp {{ number_format($investment->amount, 0, ',', '.') }}</td>
                    <td class="px-5 py-3.5 text-slate-600 font-medium">Rp {{ number_format($investment->current_value ?? $investment->amount, 0, ',', '.') }}</td>
                    <td class="px-5 py-3.5 text-slate-600">{{ \Carbon\Carbon::parse($investment->created_at)->timezone('Asia/Jakarta')->format('d M Y') }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.investments.edit', $investment) }}" class="text-xs bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg transition">Edit</a>
                            <form method="POST" action="{{ route('admin.investments.destroy', $investment) }}" class="inline" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg transition">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-slate-400 text-sm">Belum ada data investasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $investments->links() }}
    </div>
</div>

@endsection
