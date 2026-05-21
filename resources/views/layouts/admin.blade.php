<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - SMK AR RAHMAT</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50" x-data="{ sidebarOpen: true, userDropdown: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <aside class="w-60 bg-[#1a2744] flex flex-col flex-shrink-0 transition-all duration-300 fixed lg:relative h-screen left-0 top-0 z-40 lg:z-auto"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            <!-- Logo -->
            <div class="px-5 py-4 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm leading-tight">Panel Admin</p>
                        <p class="text-white/40 text-[10px]">SMK AR RAHMAT</p>
                    </div>
                </div>
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5">
                <!-- Admin Section -->
                <p class="text-white/30 text-[9px] font-semibold uppercase tracking-widest px-3 pb-2 pt-1">Dashboard</p>
                
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                          {{ request()->routeIs('admin.dashboard') 
                             ? 'bg-white/10 text-white border-l-2 border-blue-400' 
                             : 'text-white/60 hover:bg-white/6 hover:text-white' }}">
                    <x-nav-icon name="home" />
                    Overview
                </a>

                <!-- Data Section -->
                <p class="text-white/30 text-[9px] font-semibold uppercase tracking-widest px-3 pb-2 pt-4">Data</p>

                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                          {{ request()->routeIs('admin.users.*') 
                             ? 'bg-white/10 text-white border-l-2 border-blue-400' 
                             : 'text-white/60 hover:bg-white/6 hover:text-white' }}">
                    <x-nav-icon name="users" />
                    Pengguna
                </a>

                <a href="{{ route('admin.teachers.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                          {{ request()->routeIs('admin.teachers.*') 
                             ? 'bg-white/10 text-white border-l-2 border-blue-400' 
                             : 'text-white/60 hover:bg-white/6 hover:text-white' }}">
                    <svg style="width:15px;height:15px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479"/>
                    </svg>
                    Data Guru
                </a>

                <a href="{{ route('admin.students.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                          {{ request()->routeIs('admin.students.*') 
                             ? 'bg-white/10 text-white border-l-2 border-blue-400' 
                             : 'text-white/60 hover:bg-white/6 hover:text-white' }}">
                    <x-nav-icon name="academic-cap" />
                    Data Siswa
                </a>

                <!-- Content Section -->
                <p class="text-white/30 text-[9px] font-semibold uppercase tracking-widest px-3 pb-2 pt-4">Konten</p>

                <a href="{{ route('admin.banners.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                          {{ request()->routeIs('admin.banners.*') 
                             ? 'bg-white/10 text-white border-l-2 border-blue-400' 
                             : 'text-white/60 hover:bg-white/6 hover:text-white' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"/>
                    </svg>
                    Banner
                </a>

                <a href="{{ route('admin.announcements.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                          {{ request()->routeIs('admin.announcements.*') 
                             ? 'bg-white/10 text-white border-l-2 border-blue-400' 
                             : 'text-white/60 hover:bg-white/6 hover:text-white' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.961 1.961 0 01-2.437-1.97V5.882m14.147 0a2.846 2.846 0 00-5.648-1.666V5.882m5.648 0A2.844 2.844 0 0015.041 6.908M9 19.241a2.844 2.844 0 001.563.823c1.406 0 2.659-.646 3.437-1.68M9 19.241V5.882m0 0a1.961 1.961 0 012.437-1.97"/>
                    </svg>
                    Pengumuman
                </a>

                <!-- Operations Section -->
                <p class="text-white/30 text-[9px] font-semibold uppercase tracking-widest px-3 pb-2 pt-4">Operasional</p>

                <a href="{{ route('admin.schedules.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                          {{ request()->routeIs('admin.schedules.*') 
                             ? 'bg-white/10 text-white border-l-2 border-blue-400' 
                             : 'text-white/60 hover:bg-white/6 hover:text-white' }}">
                    <x-nav-icon name="calendar" />
                    Jadwal
                </a>

                <a href="{{ route('admin.piket.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                          {{ request()->routeIs('admin.piket.*') 
                             ? 'bg-white/10 text-white border-l-2 border-blue-400' 
                             : 'text-white/60 hover:bg-white/6 hover:text-white' }}">
                    <x-nav-icon name="clipboard-list" />
                    Piket
                </a>

                <a href="{{ route('admin.seksi.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                          {{ request()->routeIs('admin.seksi.*') 
                             ? 'bg-white/10 text-white border-l-2 border-blue-400' 
                             : 'text-white/60 hover:bg-white/6 hover:text-white' }}">
                    <svg style="width:15px;height:15px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857"/>
                    </svg>
                    Seksi Kegiatan
                </a>

                <a href="{{ route('admin.absences.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                          {{ request()->routeIs('admin.absences.*') 
                             ? 'bg-white/10 text-white border-l-2 border-blue-400' 
                             : 'text-white/60 hover:bg-white/6 hover:text-white' }}">
                    <x-nav-icon name="document-text" />
                    Izin & Absensi
                </a>

                <a href="{{ route('admin.absences.settings') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                          {{ request()->routeIs('admin.absences.settings') 
                             ? 'bg-white/10 text-white border-l-2 border-blue-400' 
                             : 'text-white/60 hover:bg-white/6 hover:text-white' }}">
                    <svg style="width:15px;height:15px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Pengaturan Izin
                </a>

                <!-- Finance Section -->
                <p class="text-white/30 text-[9px] font-semibold uppercase tracking-widest px-3 pb-2 pt-4">Keuangan</p>

                <a href="{{ route('admin.kas.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                          {{ request()->routeIs('admin.kas.*') 
                             ? 'bg-white/10 text-white border-l-2 border-blue-400' 
                             : 'text-white/60 hover:bg-white/6 hover:text-white' }}">
                    <x-nav-icon name="cash" />
                    Kas Kelas
                </a>

                <a href="{{ route('admin.investments.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                          {{ request()->routeIs('admin.investments.*') 
                             ? 'bg-white/10 text-white border-l-2 border-blue-400' 
                             : 'text-white/60 hover:bg-white/6 hover:text-white' }}">
                    <x-nav-icon name="trending-up" />
                    Investasi
                </a>
            </nav>

            <!-- User Chip -->
            <div class="px-4 py-3 border-t border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-white text-xs font-medium truncate">{{ auth()->user()->name }}</p>
                        <p class="text-white/35 text-[10px] truncate">Admin</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <header class="h-14 bg-white border-b border-slate-200 flex items-center px-6 gap-4 flex-shrink-0">
                <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-slate-700 lg:hidden">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="text-sm text-slate-600 flex items-center gap-2">
                    <span class="text-amber-600 bg-amber-50 px-2 py-0.5 rounded text-xs font-medium">ADMIN</span>
                    <span class="font-medium text-slate-800">@yield('title', 'Admin Panel')</span>
                </div>

                <div class="flex-1"></div>

                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 text-sm text-slate-700 hover:text-slate-900 transition">
                        <div class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center text-white text-xs font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    </button>

                    <div x-show="open" x-transition
                         class="absolute right-0 top-10 w-44 bg-white rounded-xl shadow-lg border border-slate-100 py-1 z-50">
                        <div class="px-4 py-2 border-b border-slate-100">
                            <p class="text-xs font-medium text-slate-800">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="w-full text-left px-4 py-2 text-xs text-slate-600 hover:bg-slate-50 transition block">Kembali ke User</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-xs text-red-500 hover:bg-red-50 transition">Keluar</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2 animate-fade-in">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2 animate-fade-in">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    {{ session('error') }}
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
