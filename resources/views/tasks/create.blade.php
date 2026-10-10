@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Tambah Task</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <label class="block mb-1">Judul Task</label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border p-2 rounded mb-4" required>

            <label class="block mb-1">Departemen</label>
            <select name="department_id" class="w-full border p-2 rounded mb-4" required>
                <option value="">Pilih Departemen</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>

            <label class="block mb-1">Area</label>
            <select name="area_id" class="w-full border p-2 rounded mb-4" required>
                <option value="">Pilih Area</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}" @selected(old('area_id') == $area->id)>
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>

            <label class="block mb-1">Deadline</label>
            <input type="date" name="due_at" value="{{ old('due_at', now()->format('Y-m-d')) }}"
                class="w-full border p-2 rounded mb-6" required>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>

                <a href="{{ route('tasks.index') }}" class="bg-gray-300 px-4 py-2 rounded">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection