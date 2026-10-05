@extends('layouts.app')

@section('title',$title)

@section('content')
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
                @foreach ( $dealers as $dealer )
                <tr>
                    <td class="border border-gray-300 px-4 py-2 text-sm text-black">
                        {{ $loop->iteration }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $dealer['code'] }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $dealer['name'] }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        <div class="flex gap-5 justify-center">
                            <a href="{{ route('dealers.show' , ['dealer' => $dealer['id']]) }}" class="px-4 py-2 bg-blue-500 text-s rounded-lg text-white hover:bg-blue-500/40">Lihat</a>
                            <a href="{{ route('dealers.edit' , ['dealer' => $dealer['id']]) }}" class="px-4 py-2 bg-yellow-500 text-s rounded-lg text-white hover:bg-yellow-500/40">Edit</a>
                            <a href="" class="px-4 py-2 bg-red-500 text-s rounded-lg text-white hover:bg-red-500/40">Delete</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
