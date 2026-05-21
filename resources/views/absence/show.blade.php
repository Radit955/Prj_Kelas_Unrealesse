@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-semibold text-gray-900">Detail Izin</h1>
    <div class="mt-4 bg-white rounded-lg shadow p-4">
        <p><strong>Siswa:</strong> {{ $absence->student->user->name }}</p>
        <p><strong>Tanggal:</strong> {{ $absence->date }}</p>
        <p><strong>Jenis:</strong> {{ $absence->type }}</p>
        <p><strong>Status:</strong> {{ $absence->status }}</p>
    </div>
</div>
@endsection