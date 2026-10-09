<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-lg shadow-md border border-gray-200">
    <div class="mb-6 border-b pb-4 text-center">
        <h1 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h1>
    </div>

    <form 
        action="{{ route('register-post') }}" 
        method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 px-4 py-2 rounded focus:ring-blue-500" required>
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 px-4 py-2 rounded focus:ring-blue-500" required>
            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Password</label>
            <input type="password" name="password" class="w-full border border-gray-300 px-4 py-2 rounded focus:ring-blue-500" required>
            @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
            Daftar
        </button>
        
        <p class="mt-4 text-center text-sm text-gray-600">
            Sudah punya akun? <a href="/login" class="text-blue-600 hover:underline">Login di sini</a>
        </p>
    </form>
</div>
</body>
</html>