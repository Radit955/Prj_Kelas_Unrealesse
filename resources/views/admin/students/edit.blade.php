@extends('layouts.admin')
@section('title', 'Edit Siswa')
@section('content')

<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.students.index') }}" class="text-slate-400 hover:text-slate-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-lg font-semibold text-slate-800">Edit Siswa: {{ $student->user->name }}</h1>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-6">
        <form method="POST" action="{{ route('admin.students.update', $student) }}">
            @csrf @method('PUT')

            <div class="space-y-4">
                {{-- NIS --}}
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">NIS (Nomor Induk Siswa)</label>
                    <input type="text" name="nis" value="{{ old('nis', $student->nis) }}"
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition @error('nis') border-red-400 @enderror">
                    @error('nis')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Kelas --}}
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Kelas</label>
                    <input type="text" name="class" value="{{ old('class', $student->class) }}" placeholder="e.g. 12 RPL 1"
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition @error('class') border-red-400 @enderror">
                    @error('class')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Seat Position Info --}}
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-xs font-medium text-blue-900 mb-2">Posisi Kursi</p>
                    @php $seatLayout = \App\Models\SeatLayout::where('student_id', $student->id)->first(); @endphp
                    @if($seatLayout)
                    <p class="text-sm text-blue-800">Saat ini: <strong>Baris {{ $seatLayout->row }}, Kolom {{ $seatLayout->col }}</strong></p>
                    <p class="text-xs text-blue-700 mt-1">Ubah posisi kursi melalui halaman Denah Kursi di dashboard admin.</p>
                    @else
                    <p class="text-sm text-blue-800">Siswa ini belum ditempatkan di kursi manapun.</p>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-5 border-t border-slate-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-5 py-2.5 rounded-lg transition font-medium">Simpan Perubahan</button>
                <a href="{{ route('admin.students.index') }}" class="text-sm text-slate-500 hover:text-slate-700 px-4 py-2.5">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
