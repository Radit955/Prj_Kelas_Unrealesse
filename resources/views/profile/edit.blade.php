@extends('layouts.app')

@section('title', 'Edit Profil')
@section('content')

<div class="max-w-3xl space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Edit Profil</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Perbarui informasi akun dan kata sandi Anda.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:underline">Kembali ke dashboard</a>
    </div>

    @if(session('success'))
    <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-200">
        {{ session('success') }}
    </div>
    @endif

    <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-6">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Avatar Upload --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">Foto Profil</label>
                <div class="flex items-end gap-4">
                    <div class="w-20 h-20 rounded-full overflow-hidden flex-shrink-0 bg-blue-600 flex items-center justify-center border-2 border-slate-200 dark:border-slate-700">
                        @php $user = auth()->user(); @endphp
                        @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover" x-show="!preview">
                        @else
                        <span class="text-white font-bold text-xl">{{ strtoupper(substr($user->name,0,2)) }}</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" name="avatar" accept="image/*" class="block w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-400" />
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">PNG, JPG, GIF atau WebP. Maksimal 2MB.</p>
                    </div>
                </div>
                @error('avatar')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" />
                @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" />
                @error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Nomor Telepon</label>
                <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" />
                @error('phone')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Bio</label>
                <textarea name="bio" rows="3" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">{{ old('bio', auth()->user()->bio) }}</textarea>
                @error('bio')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Kata Sandi Baru</label>
                    <input type="password" name="password" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" />
                    @error('password')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" />
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection