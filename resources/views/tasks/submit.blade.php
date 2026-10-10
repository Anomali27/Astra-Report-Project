@extends('layouts.app')

@section('title', 'Pengumpulan Task')

@section('content')
    <div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Pengumpulan Task</h1>

        @if (session('success'))
            <p class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </p>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="space-y-3 mb-6">
            <p><strong>Judul:</strong> {{ $task->title }}</p>
            <p><strong>Departemen:</strong> {{ $task->department->name ?? '-' }}</p>
            <p><strong>Area:</strong> {{ $task->area->name ?? '-' }}</p>
            <p><strong>Deadline:</strong> {{ $task->due_at->format('d-m-Y') }}</p>

            <p>
                <strong>Status:</strong>
                {{ $submission->status ?? 'Belum Mengumpulkan' }}
            </p>
        </div>

        @php
            $deadlinePassed = now()->startOfDay()->gt($task->due_at);
            $canSubmit = !$submission || $submission->status === 'REVISI';
        @endphp

        @if (!$deadlinePassed && $canSubmit)
            <form action="{{ route('tasks.submit.store', $task->id) }}" method="POST">
                @csrf

                <label class="block mb-1">Link Google Drive</label>
                <input type="url" name="google_drive_url"
                    value="{{ old('google_drive_url', $submission->google_drive_url ?? '') }}"
                    placeholder="https://drive.google.com/..." class="w-full border p-2 rounded mb-4" required>

                <label class="block mb-1">Catatan (opsional)</label>
                <textarea name="note" rows="3" class="w-full border p-2 rounded mb-4">{{ old('note') }}</textarea>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    {{ $submission ? 'Kumpulkan Ulang' : 'Kumpulkan Task' }}
                </button>
            </form>
        @elseif ($deadlinePassed)
            <p class="bg-red-100 text-red-700 p-3 rounded">
                Deadline pengumpulan sudah lewat.
            </p>
        @else
            <p class="bg-yellow-100 text-yellow-800 p-3 rounded">
                Kamu tidak dapat mengumpulkan ulang karena status bukan REVISI.
            </p>
        @endif

        <a href="{{ url()->previous() }}" class="inline-block mt-5 bg-gray-300 px-4 py-2 rounded">
            Kembali
        </a>
    </div>
@endsection