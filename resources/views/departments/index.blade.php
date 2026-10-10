@extends('layouts.app')

@section('title', $title)

@section('content')

    <div class="mx-auto max-w-4xl text-white bg-black rounded-lg mb-4 gap-2 px-6 py-4 justify-between flex items-center">
        <div class="flex flex-col">
            <span class="font-bold text-2xl">
                Daftar Department Yang Tersedia
            </span>
            <span class="font-semibold text-sm text-gray-400">
                Tahun 2026
            </span>
        </div>
        @if(auth()->user()->role === 'supervisor')
            <a href="{{ route('departments.create') }}" class="px-4 py-2 bg-green-500 text-sm rounded-lg flex items-center text-white hover:bg-green-600 font-semibold">
                + Tambah Department
            </a>
        @endif
    </div>

    <div class="bg-white items-center flex justify-center w-full">
        <table class="w-full max-w-4xl border border-gray-300">
            <thead class="bg-gray-200 text-center">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 align-middle">No</th>
                    <th class="border border-gray-300 px-4 py-2 align-middle">Code</th>
                    <th class="border border-gray-300 px-4 py-2 align-middle">Name</th>
                    <th class="border border-gray-300 px-4 py-2 align-middle">Action</th>
                </tr>
            </thead>

            <tbody class="text-center">
                @foreach ($departments as $department)
                <tr>
                    <td class="border border-gray-300 px-4 py-2 text-sm text-black">
                        {{ $loop->iteration }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $department['code'] }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $department['name'] }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        <div class="flex gap-2 justify-center">
                            <a href="{{ route('departments.show', ['department' => $department['id']]) }}" class="px-3 py-1 bg-blue-500 text-sm rounded text-white hover:bg-blue-600">
                                Lihat
                            </a>

                            @if(auth()->user()->role === 'supervisor')
                                <a href="{{ route('departments.edit', ['department' => $department['id']]) }}" class="px-3 py-1 bg-yellow-500 text-sm rounded text-white hover:bg-yellow-600">
                                    Edit
                                </a>
                                <form 
                                    action="{{ route('departments.destroy', ['department' => $department->id]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus data Department ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="px-3 py-1 bg-red-500 text-sm rounded text-white hover:bg-red-600">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 max-w-4xl mx-auto">
        {{ $departments->links() }}
    </div>
@endsection
