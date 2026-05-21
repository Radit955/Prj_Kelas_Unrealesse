<div class="border-l-4 {{ $type == 'info' ? 'border-blue-500' : ($type == 'warning' ? 'border-yellow-500' : 'border-red-500') }} pl-4 py-2 mb-2">
    <h4 class="font-semibold">{{ $title }}</h4>
    <p class="text-sm">{{ $body }}</p>
    <small class="text-gray-500">{{ $created_at->diffForHumans() }}</small>
</div>