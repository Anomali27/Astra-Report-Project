@extends('layouts.app')

@section('title', 'Halaman Pengumpulan Tugas')

@section('content')
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-2">Halaman Pengumpulan Tugas</h1>
        <p class="text-sm text-gray-500 mb-6">Silakan kumpulkan hasil pekerjaan Anda dalam bentuk link Google Drive.</p>

        @if (session('success'))
            <p class="bg-green-100 text-green-700 p-3 rounded mb-4 font-medium">
                {{ session('success') }}
            </p>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- INFORMASI TUGAS SESUAI SOAL --}}
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
            <h2 class="text-md font-bold text-gray-800 mb-3 border-b pb-2">Informasi Tugas</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500 block">a. Nama Laporan:</span>
                    <span class="font-semibold text-gray-800">{{ $task->title }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block">b. Departemen:</span>
                    <span class="font-semibold text-gray-800">{{ $task->department->name ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block">c. Area:</span>
                    <span class="font-semibold text-gray-800">{{ $task->area->name ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block">d. Deadline:</span>
                    <span class="font-semibold {{ now()->startOfDay()->gt($task->due_at) ? 'text-red-600' : 'text-gray-800' }}">
                        {{ $task->due_at->format('d-m-Y') }}
                    </span>
                </div>
                <div class="col-span-2 pt-2 border-t mt-1">
                    <span class="text-gray-500 block">Status Pengumpulan Saat Ini:</span>
                    @if(!$submission)
                        <span class="inline-block px-2.5 py-1 rounded text-xs font-bold bg-gray-200 text-gray-700">
                            Belum Mengumpulkan
                        </span>
                    @elseif($submission->status === 'MENUNGGU_PEMERIKSAAN')
                        <span class="inline-block px-2.5 py-1 rounded text-xs font-bold bg-blue-100 text-blue-800">
                            Menunggu Pemeriksaan
                        </span>
                    @elseif($submission->status === 'REVISI')
                        <span class="inline-block px-2.5 py-1 rounded text-xs font-bold bg-yellow-100 text-yellow-800">
                            REVISI (Perlu Diperbaiki)
                        </span>
                    @elseif($submission->status === 'DISETUJUI')
                        <span class="inline-block px-2.5 py-1 rounded text-xs font-bold bg-green-100 text-green-800">
                            DISETUJUI
                        </span>
                    @elseif($submission->status === 'DITOLAK')
                        <span class="inline-block px-2.5 py-1 rounded text-xs font-bold bg-red-100 text-red-800">
                            DITOLAK
                        </span>
                    @endif
                </div>
            </div>
        </div>

        @php
            $deadlinePassed = now()->startOfDay()->gt($task->due_at);
            // Pengumpulan pertama kali atau jika status revisi
            $canSubmit = (!$submission || $submission->status === 'REVISI') && !$deadlinePassed;
        @endphp

        {{-- FORM PENGUMPULAN --}}
        @if ($canSubmit)
            <form action="{{ route('tasks.submit.store', $task->id) }}" method="POST" class="mb-8">
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold mb-1 text-sm text-gray-700">
                        a. Link Google Drive <span class="text-red-500">*</span>
                    </label>
                    <input type="url" name="google_drive_url"
                        value="{{ old('google_drive_url', $submission->google_drive_url ?? '') }}"
                        placeholder="https://drive.google.com/..." 
                        class="w-full border border-gray-300 p-2.5 rounded focus:ring focus:ring-blue-200" required>
                    <p class="text-xs text-gray-500 mt-1">Pastikan link Google Drive dapat diakses publik/supervisor.</p>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1 text-sm text-gray-700">
                        b. Catatan (Opsional)
                    </label>
                    <textarea name="note" rows="3" 
                        placeholder="Tambahkan catatan jika ada penjelasan tambahan..."
                        class="w-full border border-gray-300 p-2.5 rounded focus:ring focus:ring-blue-200">{{ old('note') }}</textarea>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded shadow">
                    {{ $submission && $submission->status === 'REVISI' ? 'Kumpulkan Ulang' : 'Kumpul Tugas' }}
                </button>
            </form>
        @else
            {{-- KONDISI TIDAK BISA KUMPUL SESUAI ATURAN SOAL --}}
            <div class="p-4 rounded-lg mb-8 {{ $deadlinePassed ? 'bg-red-50 text-red-800 border border-red-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                <div class="font-bold mb-1">Pengumpulan Ditutup:</div>
                @if ($deadlinePassed)
                    <p class="text-sm">Batas waktu (deadline) pengumpulan sudah lewat. Anda tidak dapat mengumpulkan tugas lagi.</p>
                @elseif ($submission && in_array($submission->status, ['DISETUJUI', 'DITOLAK']))
                    <p class="text-sm">Status tugas ini adalah <strong>{{ $submission->status }}</strong>. Pengumpulan sudah bersifat final dan tidak dapat diubah lagi.</p>
                @elseif ($submission && $submission->status === 'MENUNGGU_PEMERIKSAAN')
                    <p class="text-sm">Tugas Anda telah dikumpulkan dan sedang <strong>Menunggu Pemeriksaan</strong> oleh Supervisor.</p>
                @endif
            </div>
        @endif

        {{-- TABEL DATA LOG AKTIVITAS SESUAI SOAL --}}
        <div class="mt-8 border-t pt-6">
            <h2 class="text-lg font-bold mb-3">Tabel Log Aktivitas</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border text-sm">
                    <thead class="bg-gray-100 text-center">
                        <tr>
                            <th class="border p-2.5 w-12">No</th>
                            <th class="border p-2.5 text-left">Tanggal</th>
                            <th class="border p-2.5 text-left">Aktivitas</th>
                            <th class="border p-2.5 text-left">Catatan</th>
                            <th class="border p-2.5">Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($submission && $submission->logs && $submission->logs->count() > 0)
                            @foreach ($submission->logs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="border p-2.5 text-center">{{ $loop->iteration }}</td>
                                    <td class="border p-2.5">{{ $log->created_at ? $log->created_at->format('d-m-Y H:i') : '-' }}</td>
                                    <td class="border p-2.5 font-semibold {{ str_contains($log->activity, 'Revisi') ? 'text-amber-600' : (str_contains($log->activity, 'Menyetujui') ? 'text-green-600' : (str_contains($log->activity, 'Menolak') ? 'text-red-600' : 'text-blue-600')) }}">
                                        {{ $log->activity }}
                                    </td>
                                    <td class="border p-2.5 text-gray-700">{{ $log->note ?: '-' }}</td>
                                    <td class="border p-2.5 text-center text-xs font-medium text-gray-600">
                                        {{ $log->user->name ?? '-' }} ({{ $log->user->role ?? '-' }})
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="border p-4 text-center text-gray-500">
                                    Belum ada catatan aktivitas log.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('tasks.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded text-sm font-medium">
                Kembali ke Daftar Task
            </a>
        </div>
    </div>
@endsection