@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Edit Task</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label class="block mb-1">Judul Task</label>
            <input type="text" name="title" value="{{ old('title', $task->title) }}" class="w-full border p-2 rounded mb-4"
                required>

            <label class="block mb-1">Departemen</label>
            <select name="department_id" class="w-full border p-2 rounded mb-4" required>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @selected(old('department_id', $task->department_id) == $department->id)>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>

            <label class="block mb-1">Area</label>
            <select name="area_id" class="w-full border p-2 rounded mb-4" required>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}" @selected(old('area_id', $task->area_id) == $area->id)>
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>

            <label class="block mb-1">Deadline</label>
            <input type="date" name="due_at" value="{{ old('due_at', $task->due_at->format('Y-m-d')) }}"
                class="w-full border p-2 rounded mb-6" required>

            <div class="flex gap-2">
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">
                    Simpan Perubahan
                </button>

                <a href="{{ route('tasks.index') }}" class="bg-gray-300 px-4 py-2 rounded">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection