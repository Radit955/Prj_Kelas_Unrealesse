@extends('layouts.admin')
@section('title', 'Kelola Pengguna')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Kelola Pengguna</h1>
        <p class="text-xs text-slate-400 mt-0.5">{{ $users->total() }} pengguna terdaftar</p>
    </div>
    <a href="{{ route('admin.users.create') }}"
       class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Pengguna
    </a>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-100 dark:border-slate-700">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengguna</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="text-right px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-700">
                @php
                $roleBadge = [
                    'admin'       => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                    'wali_kelas'  => 'bg-purple-100 text-purple-700',
                    'guru'        => 'bg-blue-100 text-blue-700',
                    'guru_piket'  => 'bg-cyan-100 text-cyan-700',
                    'ketua_kelas' => 'bg-amber-100 text-amber-700',
                    'wakil_kelas' => 'bg-orange-100 text-orange-700',
                    'seksi_kelas' => 'bg-teal-100 text-teal-700',
                    'murid'       => 'bg-green-100 text-green-700',
                ];
                @endphp
                @forelse($users as $user)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors" x-data="{ timeoutOpen: false }">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full overflow-hidden flex-shrink-0 bg-blue-600 flex items-center justify-center">
                                @if($user->avatar)
                                    <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-white text-xs font-bold">{{ strtoupper(substr($user->name,0,2)) }}</span>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-slate-800 dark:text-slate-200 text-sm">{{ $user->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $user->phone ?? '' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 text-sm">{{ $user->email }}</td>
                    <td class="px-5 py-3.5">
                        @foreach($user->roles as $role)
                        @php $s = $roleBadge[$role->name] ?? 'bg-gray-100 text-gray-700'; @endphp
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded {{ $s }}">
                            {{ ucwords(str_replace('_',' ',$role->name)) }}
                        </span>
                        @endforeach
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full
                            {{ ($user->status ?? 'active') === 'active' ? 'bg-green-100 text-green-700' : (($user->status ?? 'active') === 'suspended' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ ucfirst($user->status ?? 'active') }}
                            @if(($user->status ?? '') === 'timeout' && $user->timeout_until)
                                · {{ \Carbon\Carbon::parse($user->timeout_until)->diffForHumans() }}
                            @endif
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center justify-end gap-1.5 flex-wrap">
                            {{-- View --}}
                            <a href="{{ route('admin.users.show', $user) }}"
                               class="text-xs bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 px-2.5 py-1.5 rounded-lg transition-colors">
                                Info
                            </a>
                            {{-- Edit --}}
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="text-xs bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 text-blue-600 dark:text-blue-400 px-2.5 py-1.5 rounded-lg transition-colors">
                                Edit
                            </a>
                            @if($user->id !== auth()->id())
                                {{-- Suspend / Unsuspend --}}
                                @if(($user->status ?? 'active') === 'active' || ($user->status ?? '') === 'timeout')
                                <form method="POST" action="{{ route('admin.users.suspend', $user) }}"
                                      onsubmit="return confirm('Suspend akun {{ addslashes($user->name) }}?')">
                                    @csrf
                                    <button class="text-xs bg-orange-50 dark:bg-orange-900/20 hover:bg-orange-100 text-orange-600 dark:text-orange-400 px-2.5 py-1.5 rounded-lg transition-colors">
                                        Suspend
                                    </button>
                                </form>
                                @else
                                <form method="POST" action="{{ route('admin.users.unsuspend', $user) }}">
                                    @csrf
                                    <button class="text-xs bg-green-50 dark:bg-green-900/20 hover:bg-green-100 text-green-600 dark:text-green-400 px-2.5 py-1.5 rounded-lg transition-colors">
                                        Aktifkan
                                    </button>
                                </form>
                                @endif

                                {{-- Timeout --}}
                                <div class="relative">
                                    <button @click="timeoutOpen = !timeoutOpen"
                                            class="text-xs bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 text-amber-600 dark:text-amber-400 px-2.5 py-1.5 rounded-lg transition-colors">
                                        Timeout
                                    </button>
                                    <div x-show="timeoutOpen" @click.away="timeoutOpen = false"
                                         class="absolute right-0 top-8 z-20 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg p-3 w-44"
                                         style="display:none;">
                                        <form method="POST" action="{{ route('admin.users.timeout', $user) }}" class="space-y-2">
                                            @csrf
                                            <p class="text-[10px] text-slate-500 dark:text-slate-400 font-medium">Durasi timeout</p>
                                            <select name="hours" class="w-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg px-2 py-1.5 text-xs text-slate-700 dark:text-slate-200 focus:outline-none">
                                                <option value="1">1 jam</option>
                                                <option value="3">3 jam</option>
                                                <option value="6">6 jam</option>
                                                <option value="12">12 jam</option>
                                                <option value="24" selected>24 jam</option>
                                                <option value="72">3 hari</option>
                                                <option value="168">1 minggu</option>
                                            </select>
                                            <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-1.5 rounded-lg text-xs font-medium transition-colors">
                                                Terapkan
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                      onsubmit="return confirm('Hapus pengguna {{ addslashes($user->name) }}? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs bg-red-50 dark:bg-red-900/20 hover:bg-red-100 text-red-600 dark:text-red-400 px-2.5 py-1.5 rounded-lg transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-16 text-center text-slate-400 text-sm">Belum ada pengguna</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-700">
        {{ $users->links() }}
    </div>
</div>
@endsection
