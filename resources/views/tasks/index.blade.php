@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white rounded-lg shadow">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar Task</h1>

            <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                + Tambah Task
            </a>
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
                        <th class="border p-3">Judul</th>
                        <th class="border p-3">Departemen</th>
                        <th class="border p-3">Area</th>
                        <th class="border p-3">Deadline</th>
                        <th class="border p-3">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tasks as $task)
                        <tr class="text-center">
                            <td class="border p-3">{{ $loop->iteration }}</td>
                            <td class="border p-3">{{ $task->title }}</td>
                            <td class="border p-3">
                                {{ $task->department->name ?? '-' }}
                            </td>
                            <td class="border p-3">
                                {{ $task->area->name ?? '-' }}
                            </td>
                            <td class="border p-3">
                                {{ $task->due_at->format('d-m-Y') }}
                            </td>
                            <td class="border p-3">
                                <div class="flex justify-center gap-2 flex-wrap">
                                    <a href="{{ route('tasks.show', $task->id) }}"
                                        class="bg-green-600 text-white px-3 py-1 rounded">
                                        Detail
                                    </a>

                                    <a href="{{ route('tasks.review', $task->id) }}"
                                        class="bg-blue-600 text-white px-3 py-1 rounded">
                                        Review
                                    </a>

                                    @if ($task->submissions_count == 0)
                                        <a href="{{ route('tasks.edit', $task->id) }}"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded">
                                            Edit
                                        </a>

                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus task ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-500 text-sm">
                                            Terkunci
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border p-4 text-center">
                                Belum ada task.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection