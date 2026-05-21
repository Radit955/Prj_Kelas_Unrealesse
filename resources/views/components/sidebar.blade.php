<div x-data="{ open: false }" class="bg-slate-800 text-white w-64 min-h-screen flex flex-col">
    <div class="p-4 border-b border-slate-700">
        <h1 class="text-xl font-bold">Portal Kelas</h1>
    </div>
    <nav class="flex-1 p-4">
        <ul class="space-y-2">
            <li><a href="{{ route('dashboard') }}" class="block p-2 rounded {{ request()->routeIs('dashboard') ? 'bg-slate-700' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('students.index') }}" class="block p-2 rounded">Students</a></li>
            <li><a href="{{ route('teachers.index') }}" class="block p-2 rounded">Teachers</a></li>
            <li><a href="{{ route('piket.index') }}" class="block p-2 rounded">Piket</a></li>
            <li><a href="{{ route('kas.index') }}" class="block p-2 rounded">Kas</a></li>
            <li><a href="{{ route('izin.index') }}" class="block p-2 rounded">Izin</a></li>
            <li><a href="{{ route('jadwal.index') }}" class="block p-2 rounded">Jadwal</a></li>
            <li><a href="{{ route('tugas.index') }}" class="block p-2 rounded">Tugas</a></li>
            @if(auth()->user()->hasRole(['admin', 'wali_kelas', 'ketua_kelas']))
            <li><a href="{{ route('admin.dashboard') }}" class="block p-2 rounded">Admin</a></li>
            @endif
        </ul>
    </nav>
    <div class="p-4 border-t border-slate-700">
        <div class="flex items-center">
            <img src="{{ auth()->user()->avatar ?? 'https://picsum.photos/seed/' . auth()->user()->id . '/40/40' }}" class="w-8 h-8 rounded-full mr-2">
            <span>{{ auth()->user()->name }}</span>
        </div>
    </div>
</div>