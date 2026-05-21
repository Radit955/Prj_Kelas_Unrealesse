@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-semibold text-gray-900">Detail Tugas</h1>
    <div class="mt-4 bg-white rounded-lg shadow p-4">
        <p><strong>Judul:</strong> {{ $task->title }}</p>
        <p><strong>Mata Pelajaran:</strong> {{ $task->subject }}</p>
        <p><strong>Batas Waktu:</strong> {{ $task->due_date }}</p>
    </div>
</div>
@endsection