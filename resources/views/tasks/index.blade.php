@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white rounded-lg shadow">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">Daftar Task</h1>
                <p class="text-sm text-gray-500">
                    {{ auth()->user()->role === 'supervisor' ? 'Halaman Manajemen Tugas (Supervisor)' : 'Daftar Tugas Yang Harus Dikumpulkan (Dealer)' }}
                </p>
            </div>

            {{-- Hanya Supervisor yang bisa menambah task --}}
            @if(auth()->user()->role === 'supervisor')
                <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded font-medium hover:bg-blue-700">
                    + Tambah Task
                </a>
            @endif
        </div>

        @if (session('success'))
            <p class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </p>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-3">No</th>
                        <th class="border p-3 text-left">Nama Laporan</th>
                        <th class="border p-3">Departemen</th>
                        <th class="border p-3">Area</th>
                        <th class="border p-3">Deadline</th>
                        @if(auth()->user()->role === 'supervisor')
                            <th class="border p-3">Pengumpulan</th>
                        @endif
                        <th class="border p-3">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tasks as $task)
                        <tr class="text-center hover:bg-gray-50">
                            <td class="border p-3">{{ $loop->iteration }}</td>
                            <td class="border p-3 text-left font-medium">{{ $task->title }}</td>
                            <td class="border p-3">
                                {{ $task->department->name ?? '-' }}
                            </td>
                            <td class="border p-3">
                                {{ $task->area->name ?? '-' }}
                            </td>
                            <td class="border p-3">
                                <span class="{{ now()->startOfDay()->gt($task->due_at) ? 'text-red-600 font-semibold' : '' }}">
                                    {{ $task->due_at->format('d-m-Y') }}
                                </span>
                            </td>

                            {{-- Info jumlah pengumpulan untuk supervisor --}}
                            @if(auth()->user()->role === 'supervisor')
                                <td class="border p-3">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $task->submissions_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $task->submissions_count }} Pengumpulan
                                    </span>
                                </td>
                            @endif

                            <td class="border p-3">
                                <div class="flex justify-center gap-2 flex-wrap items-center">
                                    {{-- AKSI SUPERVISOR --}}
                                    @if(auth()->user()->role === 'supervisor')
                                        <a href="{{ route('tasks.show', $task->id) }}"
                                            class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                            Detail
                                        </a>

                                        <a href="{{ route('tasks.review', $task->id) }}"
                                            class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                            Review
                                        </a>

                                        {{-- Jika sudah ada dealer yang mengumpulkan, tidak boleh di-edit dan di-hapus --}}
                                        @if ($task->submissions_count == 0)
                                            <a href="{{ route('tasks.edit', $task->id) }}"
                                                class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">
                                                Edit
                                            </a>

                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus task ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                                    Hapus
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs font-semibold px-2 py-1 bg-gray-200 text-gray-600 rounded cursor-not-allowed" title="Tugas tidak dapat diedit atau dihapus karena sudah ada dealer yang mengumpulkan">
                                                Terkunci
                                            </span>
                                        @endif

                                    {{-- AKSI DEALER: HANYA MUNCUL TOMBOL KUMPULKAN TASK --}}
                                    @else
                                        <a href="{{ route('tasks.submit', $task->id) }}"
                                            class="bg-blue-600 text-white px-4 py-1.5 rounded text-sm font-semibold hover:bg-blue-700 shadow">
                                            Kumpulkan
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'supervisor' ? '7' : '6' }}" class="border p-4 text-center text-gray-500">
                                Belum ada task yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection