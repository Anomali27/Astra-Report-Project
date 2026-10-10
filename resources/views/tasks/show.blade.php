@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-2xl font-bold">Detail Task</h1>
            <span class="text-xs px-2.5 py-1 rounded font-semibold {{ $task->submissions()->exists() ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                {{ $task->submissions()->exists() ? 'Sudah Ada Pengumpulan (Terkunci)' : 'Belum Ada Pengumpulan' }}
            </span>
        </div>

        <div class="space-y-4 text-sm">
            <div class="border-b pb-3">
                <p class="text-gray-500 font-medium">Nama Laporan (Title)</p>
                <p class="text-lg font-bold text-gray-800">{{ $task->title }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4 border-b pb-3">
                <div>
                    <p class="text-gray-500 font-medium">Departemen</p>
                    <p class="font-semibold text-gray-700">{{ $task->department->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Area</p>
                    <p class="font-semibold text-gray-700">{{ $task->area->name ?? '-' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 border-b pb-3">
                <div>
                    <p class="text-gray-500 font-medium">Batas Waktu (Deadline)</p>
                    <p class="font-semibold text-gray-700">{{ $task->due_at->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Tugas Dibuat Oleh</p>
                    <p class="font-semibold text-gray-700">{{ $task->creator->name ?? '-' }}</p>
                </div>
            </div>

            <div>
                <p class="text-gray-500 font-medium">Total Dealer Mengumpulkan</p>
                <p class="font-semibold text-gray-700">{{ $task->submissions()->count() }} Dealer</p>
            </div>
        </div>

        <div class="flex justify-between items-center mt-8 pt-4 border-t">
            <a href="{{ route('tasks.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded font-medium">
                Kembali
            </a>

            <div class="flex gap-2">
                @if(auth()->user()->role === 'supervisor')
                    <a href="{{ route('tasks.review', $task->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-medium">
                        Lihat Pemeriksaan Tugas
                    </a>

                    @if(!$task->submissions()->exists())
                        <a href="{{ route('tasks.edit', $task->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded font-medium">
                            Edit Task
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection