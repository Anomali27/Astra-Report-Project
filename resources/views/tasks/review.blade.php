@extends('layouts.app')

@section('title', 'Review Task')

@section('content')
    <div class="max-w-5xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-2">Review Task</h1>
        <p class="text-gray-600 mb-6">
            Judul Task: {{ $task->title }}
        </p>

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

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-3">No</th>
                        <th class="border p-3">Dealer</th>
                        <th class="border p-3">Tanggal Kumpul</th>
                        <th class="border p-3">Link</th>
                        <th class="border p-3">Status</th>
                        <th class="border p-3">Review</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($submissions as $submission)
                        <tr class="align-top">
                            <td class="border p-3 text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border p-3">
                                {{ $submission->dealer->name ?? '-' }}
                            </td>

                            <td class="border p-3">
                                {{ $submission->submitted_at->format('d-m-Y H:i') }}
                            </td>

                            <td class="border p-3">
                                <a href="{{ $submission->google_drive_url }}" target="_blank" rel="noopener noreferrer"
                                    class="text-blue-600 underline">
                                    Buka Google Drive
                                </a>
                            </td>

                            <td class="border p-3">
                                {{ $submission->status }}
                            </td>

                            <td class="border p-3 min-w-64">
                                @if (!in_array($submission->status, ['DISETUJUI', 'DITOLAK'], true))
                                                    <form action="{{ route('tasks.review.store', [
                                        'task' => $task->id,
                                        'submission' => $submission->id
                                    ]) }}" method="POST">
                                                        @csrf

                                                        <label class="block mb-1">Status</label>
                                                        <select name="status" class="w-full border p-2 rounded mb-3" required>
                                                            <option value="DISETUJUI">Disetujui</option>
                                                            <option value="REVISI">Revisi</option>
                                                            <option value="DITOLAK">Ditolak</option>
                                                        </select>

                                                        <label class="block mb-1">Catatan</label>
                                                        <textarea name="note" rows="2" class="w-full border p-2 rounded mb-3"></textarea>

                                                        <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded">
                                                            Simpan Review
                                                        </button>
                                                    </form>
                                @else
                                    <span class="text-gray-500">
                                        Status final
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border p-4 text-center">
                                Belum ada dealer yang mengumpulkan task ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ route('tasks.index') }}" class="inline-block mt-6 bg-gray-300 px-4 py-2 rounded">
            Kembali
        </a>
    </div>
@endsection