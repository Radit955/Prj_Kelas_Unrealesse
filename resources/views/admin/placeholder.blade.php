@extends('layouts.admin')

@section('title', $title ?? 'Admin')

@section('breadcrumb')
    <span class="text-slate-400">Admin</span>
    <span class="text-slate-500">/</span>
    <span class="font-semibold text-slate-900">{{ $title }}</span>
@endsection

@section('content')
<div class="space-y-6">
    <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">{{ $title }}</h1>
                <p class="mt-1 text-sm text-slate-500">{{ $action }} view untuk panel admin.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                <span>Kembali</span>
            </a>
        </div>
    </div>

    @if(session('success') || session('warning'))
        <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
            <p class="text-sm {{ session('warning') ? 'text-amber-700' : 'text-emerald-700' }}">{{ session('success') ?? session('warning') }}</p>
        </div>
    @endif

    @if(isset($items))
        <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Daftar {{ $title }}</h2>
                    <p class="text-sm text-slate-500">Total: {{ $items->total() }} item</p>
                </div>
                <div class="text-sm text-slate-500">Halaman {{ $items->currentPage() }} dari {{ $items->lastPage() }}</div>
            </div>
            @if($items->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="border-b border-slate-200 bg-slate-50 text-slate-600">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Detail</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($items as $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 font-medium text-slate-900">{{ $item->id ?? '-' }}</td>
                                    <td class="px-4 py-3 text-slate-700">{{ data_get($item, 'name') ?? data_get($item, 'title') ?? '—' }}</td>
                                    <td class="px-4 py-3 text-slate-500">{{ data_get($item, 'email') ?? data_get($item, 'class') ?? data_get($item, 'type') ?? data_get($item, 'lesson_name') ?? '—' }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="#" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Lihat</a>
                                            <a href="#" class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">{{ $items->links() }}</div>
            @else
                <div class="rounded-2xl border border-dashed border-slate-200 p-8 text-center text-sm text-slate-400">Belum ada data untuk ditampilkan.</div>
            @endif
        </div>
    @endif

    @if(isset($item) && !isset($items))
        <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Detail {{ $title }}</h2>
            <pre class="whitespace-pre-wrap break-words text-sm text-slate-700">{{ json_encode($item->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
    @endif

    @if(!isset($items) && !isset($item))
        <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <p class="text-sm text-slate-500">Halaman ini disiapkan, tetapi data lengkap belum terhubung dengan fungsionalitas admin penuh.</p>
        </div>
    @endif
</div>
@endsection
