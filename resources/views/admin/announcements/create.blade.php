@extends('layouts.admin')
@section('title', 'Tambah Pengumuman')
@section('content')

<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.announcements.index') }}" class="text-slate-400 hover:text-slate-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-lg font-semibold text-slate-800">Tambah Pengumuman</h1>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-6">
        <form method="POST" action="{{ route('admin.announcements.store') }}">
            @csrf

            <div class="space-y-4">
                {{-- Judul --}}
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Judul Pengumuman</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition @error('title') border-red-400 @enderror">
                    @error('title')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Isi --}}
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Isi Pengumuman</label>
                    <textarea name="body" rows="5" required
                              class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition @error('body') border-red-400 @enderror">{{ old('body') }}</textarea>
                    @error('body')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Tipe --}}
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Tipe Pengumuman</label>
                    <select name="type" required
                            class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition @error('type') border-red-400 @enderror">
                        <option value="info" {{ old('type') === 'info' ? 'selected' : '' }}>ℹ️ Informasi</option>
                        <option value="warning" {{ old('type') === 'warning' ? 'selected' : '' }}>⚠️ Peringatan</option>
                        <option value="danger" {{ old('type') === 'danger' ? 'selected' : '' }}>🔴 Penting</option>
                    </select>
                    @error('type')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Pinned --}}
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="pinned" value="1" {{ old('pinned') ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-500/30">
                        <span class="text-xs font-medium text-slate-700">📌 Pin pengumuman ini (tampil di atas)</span>
                    </label>
                </div>

                {{-- Published --}}
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="publish_now" value="1" checked class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-500/30">
                        <span class="text-xs font-medium text-slate-700">Publikasikan sekarang</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-5 border-t border-slate-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-5 py-2.5 rounded-lg transition font-medium">Simpan</button>
                <a href="{{ route('admin.announcements.index') }}" class="text-sm text-slate-500 hover:text-slate-700 px-4 py-2.5">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
