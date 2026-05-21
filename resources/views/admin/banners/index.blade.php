@extends('layouts.admin')
@section('title', 'Kelola Banner')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Banner Dashboard</h1>
        <p class="text-xs text-slate-400 mt-0.5">Kelola slide banner halaman utama</p>
    </div>
    <a href="{{ route('admin.banners.create') }}"
       class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Banner
    </a>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($banners as $banner)
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="h-36 bg-slate-100 dark:bg-slate-700 relative overflow-hidden">
            @if($banner->image_path)
            <img src="{{ Storage::url($banner->image_path) }}" class="w-full h-full object-cover">
            @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            @endif
            <div class="absolute top-2 right-2">
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $banner->is_active ? 'bg-green-500 text-white' : 'bg-slate-500 text-white' }}">
                    {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            <div class="absolute top-2 left-2">
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-black/50 text-white">
                    #{{ $banner->order }}
                </span>
            </div>
        </div>
        <div class="p-4">
            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 truncate">{{ $banner->title }}</p>
            @if($banner->link)
            <p class="text-[10px] text-blue-500 truncate mt-0.5">{{ $banner->link }}</p>
            @endif
            <div class="flex gap-2 mt-3 pt-3 border-t border-slate-100 dark:border-slate-700">
                <form method="POST" action="{{ route('admin.banners.toggle', $banner->id) }}" class="flex-1">
                    @csrf
                    <button class="w-full text-xs py-1.5 rounded-lg transition-colors {{ $banner->is_active ? 'bg-amber-50 text-amber-600 hover:bg-amber-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }}">
                        {{ $banner->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
                <a href="{{ route('admin.banners.edit', $banner->id) }}"
                   class="px-3 py-1.5 text-xs bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 text-blue-600 dark:text-blue-400 rounded-lg transition-colors">
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.banners.destroy', $banner->id) }}" onsubmit="return confirm('Hapus banner ini?')">
                    @csrf @method('DELETE')
                    <button class="px-3 py-1.5 text-xs bg-red-50 dark:bg-red-900/20 hover:bg-red-100 text-red-600 dark:text-red-400 rounded-lg transition-colors">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-16">
        <svg class="w-12 h-12 text-slate-300 dark:text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="text-slate-400 text-sm">Belum ada banner. Tambahkan banner pertama!</p>
        <a href="{{ route('admin.banners.create') }}" class="mt-3 inline-block text-sm text-blue-600 hover:underline">Tambah Banner</a>
    </div>
    @endforelse
</div>
@endsection
