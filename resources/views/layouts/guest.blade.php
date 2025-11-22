<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login' }}</title>
    <meta name="color-scheme" content="light">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100 font-sans min-h-screen flex flex-col">

    <div class="flex flex-col items-center justify-center flex-grow p-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 md:p-8">
                {{ $slot }}
            </div>
        </div>
    </div>
    <footer class="text-center text-xs text-gray-500 py-4">
        &copy; {{ date('Y') }} Vhynts. All rights reserved.
    </footer>

    @livewireScripts
</body>

</html>
