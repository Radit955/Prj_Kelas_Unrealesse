@extends('layouts.admin')
@section('title', 'Seksi Kegiatan')
@section('content')
<div class="flex flex-col gap-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Seksi Kegiatan</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Kelola seksi kegiatan dan anggota kelas.</p>
        </div>
        <a href="{{ route('admin.seksi.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">Tambah Seksi</a>
    </div>

    <div class="grid gap-4 xl:grid-cols-2">
        @forelse($seksi as $item)
        <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $item->name }}</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $item->category ?? 'Umum' }}</p>
                </div>
                <span class="inline-flex items-center rounded-full bg-slate-100 dark:bg-slate-700 px-3 py-1 text-xs text-slate-600 dark:text-slate-300">{{ $item->members->count() }} anggota</span>
            </div>
            <div class="p-5 space-y-4">
                @if($item->ketua)
                <div class="rounded-2xl bg-slate-50 dark:bg-slate-900 p-4">
                    <p class="text-xs text-slate-400">Ketua Seksi</p>
                    <p class="mt-2 font-medium text-slate-900 dark:text-slate-100">{{ $item->ketua->user->name ?? 'Tidak ditentukan' }}</p>
                </div>
                @endif
                <div class="space-y-2">
                    <p class="text-xs text-slate-400">Anggota</p>
                    <div class="flex flex-wrap gap-2">
                        @forelse($item->members as $member)
                        <span class="rounded-full bg-slate-100 dark:bg-slate-900 px-3 py-1 text-xs text-slate-700 dark:text-slate-300">{{ $member->user->name ?? '—' }}</span>
                        @empty
                        <span class="text-sm text-slate-400">Belum ada anggota.</span>
                        @endforelse
                    </div>
                </div>
                <div class="flex flex-wrap gap-3 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('admin.seksi.edit', $item) }}" class="rounded-2xl bg-slate-100 dark:bg-slate-700 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-100 hover:bg-slate-200 dark:hover:bg-slate-600 transition">Edit</a>
                    <form action="{{ route('admin.seksi.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus seksi kegiatan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-2xl bg-red-50 dark:bg-red-900/20 px-4 py-2 text-sm font-medium text-red-600 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-800 transition">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="rounded-3xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 p-8 text-center text-slate-500 dark:text-slate-400">
            Belum ada seksi kegiatan.
        </div>
        @endforelse
    </div>

    <div>{{ $seksi->links() }}</div>
</div>
@endsection
