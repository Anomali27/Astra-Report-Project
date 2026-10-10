@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Detail Task</h1>

        <div class="space-y-4">
            <div>
                <p class="text-gray-500">Judul Task</p>
                <p class="font-semibold">{{ $task->title }}</p>
            </div>

            <div>
                <p class="text-gray-500">Departemen</p>
                <p>{{ $task->department->name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Area</p>
                <p>{{ $task->area->name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Deadline</p>
                <p>{{ $task->due_at->format('d-m-Y') }}</p>
            </div>

            <div>
                <p class="text-gray-500">Dibuat oleh</p>
                <p>{{ $task->creator->name ?? '-' }}</p>
            </div>
        </div>

        <div class="flex gap-2 mt-6">
            <a href="{{ route('tasks.index') }}" class="bg-gray-300 px-4 py-2 rounded">
                Kembali
            </a>

            <a href="{{ route('tasks.review', $task->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                Lihat Pengumpulan
            </a>
        </div>
    </div>
@endsection