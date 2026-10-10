@extends('layouts.app')

@section('title', 'Halaman Pemeriksaan Tugas')

@section('content')
    <div class="max-w-6xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4 border-b pb-4">
            <div>
                <h1 class="text-2xl font-bold">Halaman Pemeriksaan Tugas</h1>
                <p class="text-sm text-gray-500">Periksa hasil pekerjaan dan berikan status (DISETUJUI, REVISI, DITOLAK).</p>
            </div>
            <a href="{{ route('tasks.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded text-sm font-medium">
                Kembali ke Daftar Task
            </a>
        </div>

        {{-- INFORMASI LAPORAN / TUGAS --}}
        <div class="bg-gray-50 p-4 rounded-lg border mb-6 text-sm">
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <span class="text-gray-500 block">Nama Laporan:</span>
                    <span class="font-bold text-gray-800 text-base">{{ $task->title }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block">Departemen:</span>
                    <span class="font-semibold text-gray-800">{{ $task->department->name ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block">Area:</span>
                    <span class="font-semibold text-gray-800">{{ $task->area->name ?? '-' }}</span>
                </div>
            </div>
        </div>

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

        {{-- DAFTAR PENGUMPULAN DEALER --}}
        <div class="space-y-6">
            @forelse ($submissions as $submission)
                <div class="border rounded-lg p-5 bg-white shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4 border-b">
                        <div class="space-y-2 text-sm">
                            <div>
                                <span class="text-gray-500 block">b. Nama Dealer:</span>
                                <span class="font-bold text-gray-800 text-base">{{ $submission->dealer->name ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 block">c. Tanggal Kumpul:</span>
                                <span class="font-medium text-gray-800">{{ $submission->submitted_at ? $submission->submitted_at->format('d-m-Y H:i') : '-' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 block">d. Link Google Drive:</span>
                                <a href="{{ $submission->google_drive_url }}" target="_blank" rel="noopener noreferrer"
                                    class="text-blue-600 hover:underline font-semibold flex items-center gap-1">
                                    Buka Link Google Drive &rarr;
                                </a>
                            </div>
                        </div>

                        {{-- FORM PEMERIKSAAN OLEH SUPERVISOR --}}
                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <h3 class="font-bold text-sm mb-2 text-gray-700">Form Pemeriksaan Tugas:</h3>

                            @if (!in_array($submission->status, ['DISETUJUI', 'DITOLAK'], true))
                                <form action="{{ route('tasks.review.store', ['task' => $task->id, 'submission' => $submission->id]) }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Status Pengumpulan</label>
                                        <select name="status" class="w-full border border-gray-300 p-2 rounded text-sm bg-white" required>
                                            <option value="">-- Pilih Status --</option>
                                            <option value="DISETUJUI" @selected($submission->status === 'DISETUJUI')>DISETUJUI</option>
                                            <option value="REVISI" @selected($submission->status === 'REVISI')>REVISI</option>
                                            <option value="DITOLAK" @selected($submission->status === 'DITOLAK')>DITOLAK</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Catatan Supervisor</label>
                                        <textarea name="note" rows="2" placeholder="Tuliskan catatan revisi atau alasan..."
                                            class="w-full border border-gray-300 p-2 rounded text-sm bg-white"></textarea>
                                    </div>

                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-1.5 rounded text-sm shadow">
                                        Simpan Pemeriksaan
                                    </button>
                                </form>
                            @else
                                <div class="p-3 bg-gray-100 rounded text-sm">
                                    <p class="font-bold text-gray-700">Status Saat Ini: 
                                        <span class="{{ $submission->status === 'DISETUJUI' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $submission->status }}
                                        </span>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">Status sudah bersifat final.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- TABEL DATA LOG AKTIVITAS SESUAI SOAL --}}
                    <div class="mt-4 pt-3">
                        <h4 class="font-bold text-xs uppercase text-gray-500 tracking-wider mb-2">
                            Riwayat Log Aktivitas Pengumpulan & Pemeriksaan:
                        </h4>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border text-xs">
                                <thead class="bg-gray-100 text-center">
                                    <tr>
                                        <th class="border p-2 w-10">No</th>
                                        <th class="border p-2 text-left">Tanggal</th>
                                        <th class="border p-2 text-left">Aktivitas</th>
                                        <th class="border p-2 text-left">Catatan</th>
                                        <th class="border p-2">Pelaku</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($submission->logs && $submission->logs->count() > 0)
                                        @foreach ($submission->logs as $log)
                                            <tr>
                                                <td class="border p-2 text-center">{{ $loop->iteration }}</td>
                                                <td class="border p-2">{{ $log->created_at ? $log->created_at->format('d-m-Y H:i') : '-' }}</td>
                                                <td class="border p-2 font-semibold {{ str_contains($log->activity, 'Revisi') ? 'text-amber-600' : (str_contains($log->activity, 'Menyetujui') ? 'text-green-600' : (str_contains($log->activity, 'Menolak') ? 'text-red-600' : 'text-blue-600')) }}">
                                                    {{ $log->activity }}
                                                </td>
                                                <td class="border p-2 text-gray-700">{{ $log->note ?: '-' }}</td>
                                                <td class="border p-2 text-center text-gray-600">
                                                    {{ $log->user->name ?? '-' }} ({{ $log->user->role ?? '-' }})
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="border p-2 text-center text-gray-400">
                                                Belum ada aktivitas tercatat.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 border rounded-lg bg-gray-50 text-gray-500">
                    Belum ada dealer yang mengumpulkan tugas ini.
                </div>
            @endforelse
        </div>
    </div>
@endsection