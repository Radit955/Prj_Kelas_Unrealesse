@extends('layouts.admin')
@section('title', 'Detail Pengguna')
@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.users.index') }}" class="w-10 h-10 inline-flex items-center justify-center rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-500 hover:text-slate-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Detail Pengguna</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Informasi lengkap akun dan status.</p>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm overflow-hidden">
        <div class="h-28 bg-gradient-to-r from-sky-600 to-blue-500"></div>
        <div class="px-6 pb-6 pt-4">
            <div class="-mt-12 flex items-center gap-4">
                <div class="h-24 w-24 rounded-3xl border-4 border-white dark:border-slate-800 overflow-hidden bg-slate-300 flex items-center justify-center text-3xl font-bold text-white">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="h-full w-full object-cover">
                    @else
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    @endif
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white">{{ $user->name }}</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                </div>
            </div>
            <div class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Status</p>
                    <p class="mt-2 font-semibold {{ $user->status === 'active' ? 'text-emerald-700' : ($user->status === 'suspended' ? 'text-red-700' : 'text-amber-700') }}">{{ ucfirst($user->status) }}</p>
                    @if($user->status === 'timeout' && $user->timeout_until)
                    <p class="text-xs text-slate-500 mt-1">Timeout sampai {{ \Carbon\Carbon::parse($user->timeout_until)->format('d M Y H:i') }}</p>
                    @endif
                </div>
                <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Telepon</p>
                    <p class="mt-2 text-sm text-slate-700 dark:text-slate-200">{{ $user->phone ?? 'Belum diisi' }}</p>
                    <p class="text-xs text-slate-500 mt-3">Alamat</p>
                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200">{{ $user->address ?? 'Belum diisi' }}</p>
                </div>
            </div>

            <div class="mt-6 rounded-3xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 p-4">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Bio</p>
                <p class="mt-2 text-sm text-slate-700 dark:text-slate-200">{{ $user->bio ?? 'Belum ada bio.' }}</p>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">Edit</a>
                @if($user->status === 'active')
                <form action="{{ route('admin.users.suspend', $user) }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-100 transition">Suspend</button>
                </form>
                <form action="{{ route('admin.users.timeout', $user) }}" method="POST" class="inline-flex items-center gap-2">
                    @csrf
                    <input type="number" name="hours" value="24" min="1" max="720" class="w-20 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30" />
                    <button type="submit" class="rounded-2xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-600 transition">Timeout</button>
                </form>
                @else
                <form action="{{ route('admin.users.unsuspend', $user) }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-100 transition">Aktifkan</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
