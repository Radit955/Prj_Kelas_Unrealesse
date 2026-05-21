<div class="bg-white shadow p-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold">@yield('title', 'Dashboard')</h2>
    <div class="flex items-center space-x-4">
        <input type="text" placeholder="Search..." class="border rounded px-3 py-1">
        <button class="relative">
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
            🔔
        </button>
    </div>
</div>