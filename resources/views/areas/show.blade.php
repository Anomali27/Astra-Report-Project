@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="max-w-5xl mx-auto mt-10">
    
    <div class="bg-black text-white p-5 rounded-t-lg flex justify-between items-center">
        <h1 class="text-2xl font-bold">Detail Informasi Area</h1>
        <a href="{{ route('areas.index') }}" class="bg-gray-700 px-4 py-2 text-white rounded font-semibold hover:bg-gray-600">
            Kembali
        </a>
    </div>

    <div class="bg-white p-8 rounded-b-lg border border-gray-200">
        
        <div class="flex flex-row gap-4 border-b pb-4 mb-4">
            <div class="text-gray-500 font-semibold w-40">Kode Area</div>
            <div class="font-medium text-gray-800">{{ $area->code }}</div>
        </div>

        <div class="flex flex-row gap-4 border-b pb-4 mb-4">
            <div class="text-gray-500 font-semibold w-40">Nama Area</div>
            <div class="font-medium text-gray-800">{{ $area->name }}</div>
        </div>

        <div class="flex flex-row gap-4 border-b pb-4 mb-4">
            <div class="text-gray-500 font-semibold w-40">Tanggal Terdaftar</div>
            <div class="font-medium text-gray-800">
                {{ $area->created_at->format('d F Y') }}
            </div>
        </div>

        @if(auth()->user()->role === 'supervisor')
            <div class="mt-8 flex gap-4">
                <a href="{{ route('areas.edit', ['area' => $area['id']]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded shadow">
                    Edit Data
                </a>
                
                <form 
                    action="{{ route('areas.destroy', ['area' => $area['id']]) }}" 
                    method="POST" 
                    onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded shadow">
                        Hapus
                    </button>
                </form>
            </div>
        @endif

    </div>
</div>
@endsection