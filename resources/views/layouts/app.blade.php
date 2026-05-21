<!DOCTYPE html>
<html lang="id" x-data x-bind:class="$store.theme.dark ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Kelas') - SMK AR RAHMAT</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        #main-sidebar { width: 240px; }
        .sidebar-nav { background-color: #1a2744 !important; }
        .sidebar-section { color: rgba(255,255,255,0.35); font-size: 10px; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase; padding: 12px 12px 4px; }
        .nav-link { color: #d1d5db; transition: color .2s ease, background-color .2s ease; }
        .nav-link:hover { color: #ffffff; background-color: rgba(255,255,255,0.06); }
        .nav-link.active { color: #ffffff; background-color: rgba(255,255,255,0.12); }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 transition-colors duration-200"
      x-data="{
          sidebarOpen: window.innerWidth >= 1024,
          get isMobile() { return window.innerWidth < 1024; }
      }"
      x-init="
          window.addEventListener('resize', () => {
              if (window.innerWidth >= 1024) sidebarOpen = true;
          });
          Alpine.store('theme', {
              dark: localStorage.getItem('theme') === 'dark',
              toggle() {
                  this.dark = !this.dark;
                  localStorage.setItem('theme', this.dark ? 'dark' : 'light');
              }
          });
          if (localStorage.getItem('theme') === 'dark') {
              document.documentElement.classList.add('dark');
          }
      ">

    {{-- MOBILE OVERLAY --}}
    <div x-show="sidebarOpen && window.innerWidth < 1024"
         x-transition:enter="transition-opacity duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-20 lg:hidden"
         style="display:none;">
    </div>

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside id="main-sidebar" class="fixed lg:static inset-y-0 left-0 z-30 flex flex-col flex-shrink-0 transition-transform duration-300 ease-in-out sidebar-nav"
               :style="sidebarOpen ? 'transform: translateX(0)' : 'transform: translateX(-100%)'">
            <!-- Logo -->
            <div class="flex items-center gap-3 px-5 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: #2563eb;">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m0-6l-6.16 3.422"/>
                    </svg>
                </div>
                <div>
                    <p style="color: #ffffff; font-size: 13px; font-weight: 600; line-height: 1.2;">Portal Kelas</p>
                    <p style="color: rgba(255,255,255,0.35); font-size: 10px;">SMK AR RAHMAT</p>
                </div>
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto py-3 px-3 space-y-0.5 sidebar-nav">
                <p class="sidebar-section">Menu Utama</p>

                <a href="{{ route('dashboard') }}"
                   class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all {{ request()->routeIs('dashboard') ? 'active bg-white/10 border-l-2 border-blue-400' : '' }}">
                    <x-nav-icon name="home" />
                    Dashboard
                </a>
                <a href="{{ route('students.index') }}"
                   class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all {{ request()->routeIs('students.*') ? 'active bg-white/10 border-l-2 border-blue-400' : '' }}">
                    <x-nav-icon name="users" />
                    Siswa
                </a>
                <a href="{{ route('teachers.index') }}"
                   class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all {{ request()->routeIs('teachers.*') ? 'active bg-white/10 border-l-2 border-blue-400' : '' }}">
                    <x-nav-icon name="academic-cap" />
                    Guru
                </a>
                <a href="{{ route('piket.index') }}"
                   class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all {{ request()->routeIs('piket.*') ? 'active bg-white/10 border-l-2 border-blue-400' : '' }}">
                    <x-nav-icon name="clipboard-list" />
                    Piket
                </a>
                <a href="{{ route('jadwal.index') }}"
                   class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all {{ request()->routeIs('jadwal.*') ? 'active bg-white/10 border-l-2 border-blue-400' : '' }}">
                    <x-nav-icon name="calendar" />
                    Jadwal
                </a>

                <p class="sidebar-section">Keuangan</p>

                <a href="{{ route('kas.index') }}"
                   class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all {{ request()->routeIs('kas.*') ? 'active bg-white/10 border-l-2 border-blue-400' : '' }}">
                    <x-nav-icon name="cash" />
                    Kas Kelas
                </a>

                <p class="sidebar-section">Lainnya</p>

                <a href="{{ route('izin.index') }}"
                   class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all {{ request()->routeIs('izin.*') ? 'active bg-white/10 border-l-2 border-blue-400' : '' }}">
                    <x-nav-icon name="document-text" />
                    Izin & Sakit
                </a>
                <a href="{{ route('tugas.index') }}"
                   class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all {{ request()->routeIs('tugas.*') ? 'active bg-white/10 border-l-2 border-blue-400' : '' }}">
                    <x-nav-icon name="pencil" />
                    Tugas
                </a>

                @if(auth()->user()->hasAnyRole(['admin','wali_kelas','ketua_kelas']))
                <p class="sidebar-section">Admin</p>
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all {{ request()->routeIs('admin.*') ? 'active bg-white/10 border-l-2 border-blue-400' : '' }}">
                    <x-nav-icon name="cog" />
                    Admin Panel
                </a>
                @endif
            </nav>

            <div style="padding:12px 16px;border-top:1px solid rgba(255,255,255,0.08);">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:32px;height:32px;border-radius:50%;background:#2563eb;display:flex;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:600;flex-shrink:0;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div style="min-width:0;">
                        <p style="color:#ffffff;font-size:12px;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->name }}</p>
                        <p style="color:rgba(255,255,255,0.35);font-size:10px;">{{ auth()->user()->getRoleNames()->first() ?? 'User' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden min-w-0">

            <header class="h-14 flex items-center px-4 gap-4 flex-shrink-0 bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 transition-colors duration-200">

                <button @click="sidebarOpen = !sidebarOpen"
                        class="w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors flex-shrink-0">
                    <svg x-show="!sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <span class="text-sm font-semibold text-slate-700 dark:text-slate-200 flex-shrink-0">@yield('title', 'Dashboard')</span>

                <div class="flex-1"></div>

                <div class="relative hidden md:block">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" placeholder="Cari..."
                           class="pl-9 pr-4 py-1.5 text-sm w-56 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 border-0 transition-colors">
                </div>

                <button @click="$store.theme.toggle(); document.documentElement.classList.toggle('dark')"
                        class="w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors"
                        title="Toggle dark mode">
                    <svg x-show="!$store.theme.dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg x-show="$store.theme.dark" class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                </button>

                <button class="relative w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @php
                        try { $notificationCount = auth()->user()->unreadNotifications->count(); }
                        catch (\Exception $e) { $notificationCount = 0; }
                    @endphp
                    @if($notificationCount > 0)
                    <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 rounded-full text-[9px] text-white flex items-center justify-center font-semibold">
                        {{ $notificationCount }}
                    </span>
                    @endif
                </button>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        <div class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <span class="text-sm text-slate-700 dark:text-slate-200 hidden sm:block">{{ auth()->user()->name }}</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 top-11 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 py-1 z-50"
                         style="display:none;">
                        <div class="px-4 py-2.5 border-b border-slate-100 dark:border-slate-700">
                            <p class="text-xs font-semibold text-slate-800 dark:text-slate-200">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">{{ auth()->user()->getRoleNames()->first() ?? 'User' }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profil Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full flex items-center gap-2 px-4 py-2 text-xs text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            {{-- FULLSCREEN & DASHBOARD ANNOUNCEMENTS --}}
            @php
            $fullscreenAnns = collect();
            $dashboardAnns  = collect();
            try {
                if (\Illuminate\Support\Facades\Schema::hasColumn('announcements','display_mode')) {
                    $fullscreenAnns = \App\Models\Announcement::where('display_mode','fullscreen')
                        ->where(fn($q) => $q->whereNull('expires_at')->orWhere('expires_at','>',now()))
                        ->orderByDesc('created_at')
                        ->get();
                    $dashboardAnns = \App\Models\Announcement::where('display_mode','dashboard')
                        ->where(fn($q) => $q->whereNull('expires_at')->orWhere('expires_at','>',now()))
                        ->where('pinned', true)
                        ->orderByDesc('created_at')
                        ->limit(3)
                        ->get();
                }
            } catch (\Exception $e) {
                $fullscreenAnns = collect();
                $dashboardAnns  = collect();
            }
            @endphp

            @foreach($fullscreenAnns as $ann)
            @php $cookieKey = 'ann_closed_' . $ann->id; @endphp
            @if(!request()->cookie($cookieKey))
            <div id="ann-fullscreen-{{ $ann->id }}"
                 class="fixed inset-0 z-50 flex items-center justify-center p-6"
                 style="background:rgba(0,0,0,0.75);">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-lg w-full p-6">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                            {{ $ann->type==='danger' ? 'bg-red-100' : ($ann->type==='warning' ? 'bg-amber-100' : 'bg-blue-100') }}">
                            <svg class="w-5 h-5 {{ $ann->type==='danger' ? 'text-red-600' : ($ann->type==='warning' ? 'text-amber-600' : 'text-blue-600') }}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="{{ $ann->type==='danger' ? 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z' : 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-slate-800 dark:text-slate-100">{{ $ann->title }}</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">{{ $ann->body }}</p>
                        </div>
                    </div>
                    @if($ann->closeable)
                    <div class="flex justify-end">
                        <button onclick="
                            document.getElementById('ann-fullscreen-{{ $ann->id }}').remove();
                            document.cookie='{{ $cookieKey }}=1;path=/;max-age=86400';
                        " class="px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-lg text-sm font-medium transition-colors">
                            Tutup
                        </button>
                    </div>
                    @else
                    <p class="text-xs text-slate-400 text-center">Pengumuman ini tidak dapat ditutup</p>
                    @endif
                </div>
            </div>
            @endif
            @endforeach

            @if($dashboardAnns->count() > 0 && request()->routeIs('dashboard'))
            <div class="px-5 pt-3 space-y-2">
                @foreach($dashboardAnns as $ann)
                <div id="dash-ann-{{ $ann->id }}"
                     class="flex items-start gap-3 px-4 py-3 rounded-xl border
                     {{ $ann->type==='danger' ? 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800' : ($ann->type==='warning' ? 'bg-amber-50 dark:bg-amber-900/20 border-amber-200 dark:border-amber-800' : 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800') }}">
                    <p class="text-sm font-medium {{ $ann->type==='danger' ? 'text-red-700 dark:text-red-400' : ($ann->type==='warning' ? 'text-amber-700 dark:text-amber-400' : 'text-blue-700 dark:text-blue-400') }} flex-1">
                        <span class="font-bold">{{ $ann->title }}:</span> {{ $ann->body }}
                    </p>
                    @if($ann->closeable)
                    <button onclick="document.getElementById('dash-ann-{{ $ann->id }}').remove()"
                            class="text-slate-400 hover:text-slate-600 flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            <main class="flex-1 overflow-y-auto p-6 bg-slate-50 dark:bg-slate-900 transition-colors duration-200">
                @if(session('success'))
                <div class="mb-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
                @endif
                @yield('content')
            </main>

        </div>
    </div>
</body>
</html>