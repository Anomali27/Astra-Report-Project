@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-lg border border-gray-200">

        <div class="mb-6 border-b pb-4">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Data Dealer</h1>
        </div>

        <form 
            action="{{ route('dealers.store') }}" 
            method="POST">

            @csrf

            <div class="mb-4">
                <label for="code" class="block text-gray-700 font-semibold mb-2">Kode Dealer</label>
                <input 
                    type="text"
                    placeholder="4 Digit Number Example: 1234" 
                    name="code" 
                    id="code" 
                    value="{{ old('code') }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded">
    
                @error('code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Dealer</label>
                <input 
                    type="text" 
                    placeholder="Name of Company Exam: Fillable Motor"
                    name="name" 
                    id="name" 
                    value="{{ old('name') }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded">

                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('dealers.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded font-semibold transition">
                    Batal
                </a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded font-semibold shadow transition">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
@endsection