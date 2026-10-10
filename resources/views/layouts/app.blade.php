<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col">
    @include('layouts.partials.header')

    <main class="mx-auto w-full max-w-7xl flex-1 px-6 py-10">
        @yield('content')
    </main>

    @include('layouts.partials.footer')
</body>
</html>