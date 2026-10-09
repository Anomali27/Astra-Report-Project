@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="flex justify-center w-full mt-10">
        <div class="w-full max-w-5xl bg-white p-6 rounded-lg shadow-md border border-gray-200">
            
            <div class="flex justify-between items-center mb-4 border-b pb-4">
                <h1 class="text-2xl font-bold text-gray-800">Daftar Tugas (Tasks)</h1>
                
                <a href="{{ route('tasks.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold shadow transition">
                    + Tambah Tugas
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-sm relative">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300">
                    
                    <thead class="bg-gray-200 text-center">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 align-middle">No</th>
                            <th class="border border-gray-300 px-4 py-2 align-middle">Nama Laporan</th>
                            <th class="border border-gray-300 px-4 py-2 align-middle">Batas Waktu</th>
                            <th class="border border-gray-300 px-4 py-2 align-middle">Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody class="text-center">
                        {{-- Contoh data statis, nanti akan diganti dengan @foreach dari variabel $tasks --}}
                        @foreach ($tasks as $task)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 align-middle">
                                {{ $loop->iteration }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 align-middle font-medium">
                                {{ $task['title'] }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 align-middle text-red-600 font-semibold">
                                {{ $task['due_at'] }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 align-middle">
                                
                                <div class="flex justify-center gap-2">
                                    {{-- Tombol Detail --}}
                                    <a href="{{ route('tasks.show', [ 'task' => $task['id']]) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded shadow">
                                        Detail
                                    </a>
                                    
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('tasks.edit', [ 'task' => $task['id']]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded shadow">
                                        Edit
                                    </a>

                                    {{-- Tombol khusus Review (Sesuai rute kustom Anda sebelumnya) --}}
                                    <a href="{{ route('tasks.review', [ 'task' => $task['id']]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded shadow">
                                        Review
                                    </a>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection