@extends('layouts.admin')
@section('title', 'Edit Banner')
@section('content')

<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.banners.index') }}" class="text-slate-400 hover:text-slate-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-lg font-semibold text-slate-800">Edit Banner</h1>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-6">
        <form method="POST" action="{{ route('admin.banners.update', $banner) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="space-y-4" x-data="{ preview: null }">
                {{-- Judul --}}
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Judul</label>
                    <input type="text" name="title" value="{{ old('title', $banner->title) }}" required
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition @error('title') border-red-400 @enderror">
                    @error('title')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Gambar --}}
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Gambar</label>
                    <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-slate-400 transition cursor-pointer" @click="$refs.imageInput.click()">
                        <svg class="w-8 h-8 mx-auto text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-slate-600 font-medium">Klik atau drag gambar di sini untuk mengubah</p>
                        <p class="text-xs text-slate-500 mt-1">PNG, JPG, GIF (Max 2MB)</p>
                    </div>
                    <input type="file" x-ref="imageInput" name="image" accept="image/*" class="hidden"
                           @change="preview = URL.createObjectURL($event.target.files[0])">
                    
                    @if($banner->image_path && !$preview)
                    <img src="{{ Storage::url($banner->image_path) }}" class="mt-4 h-40 rounded-lg object-cover w-full">
                    @endif
                    <img x-show="preview" :src="preview" class="mt-4 h-40 rounded-lg object-cover w-full">
                    @error('image')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Link (optional) --}}
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Link (Opsional)</label>
                    <input type="url" name="link" value="{{ old('link', $banner->link) }}" placeholder="https://example.com"
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition @error('link') border-red-400 @enderror">
                    @error('link')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Order --}}
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Urutan</label>
                    <input type="number" name="order" value="{{ old('order', $banner->order) }}" min="1" required
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition @error('order') border-red-400 @enderror">
                    @error('order')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-500/30">
                        <span class="text-xs font-medium text-slate-700">Aktifkan banner ini</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-5 border-t border-slate-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-5 py-2.5 rounded-lg transition font-medium">Simpan Perubahan</button>
                <a href="{{ route('admin.banners.index') }}" class="text-sm text-slate-500 hover:text-slate-700 px-4 py-2.5">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
