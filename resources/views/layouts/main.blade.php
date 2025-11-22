<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Master App</title>
    {{-- <link rel="shortcut icon" href="https://live.hrdsukun.id/assets/images/logo-only3.png"> --}}
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-white antialiased text-gray-800">


    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-white">

        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 flex w-64 flex-shrink-0 flex-col
                   bg-white border-gray-200 transition-transform duration-300 ease-in-out
                   lg:static lg:z-30 lg:translate-x-0">

            <div class="flex h-16 shrink-0 items-center justify-center border-b border-gray-200">

                {{-- <img src="https://hpanel.hostinger.com/assets/images/logos/hostinger-black.svg" alt="Logo Sukun"
                    class="h-6"> --}}

                <h1 class="text-xl font-semibold text-gray-800">Master App</h1>
            </div>

            <nav class="flex-1 overflow-y-auto p-4 border-r border-gray-200 space-y-1" x-data="{ domainOpen: false }">
                <p class="px-3 text-xs font-medium uppercase tracking-wider text-gray-400">Menu</p>

                <!-- Dashboard (Tanpa Dropdown) -->
                <a href="{{ route('dashboard') }}" wire:navigate
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="h-5 w-5 stroke-[1.6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 11L12 3l9 8" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M5 10v10h4m6 0h4V10" stroke-linecap="round" />
                    </svg>
                    Dashboard
                </a>

                <!-- Dropdown Domain -->
                {{-- <button @click="domainOpen = !domainOpen"
                    class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium
               text-gray-700 hover:bg-gray-100 transition">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 stroke-[1.6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="12" cy="12" r="9" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M3 12h18" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 3a16.5 16.5 0 010 18" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 3a16.5 16.5 0 000 18" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        Domain
                    </div>

                    <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': domainOpen }"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
                    </svg>
                </button> --}}

                <!-- Submenu -->
                {{-- <div x-show="domainOpen" x-collapse class="ml-9 mt-1 space-y-1 border-l border-gray-300 pl-3">

                    <a href="#"
                        class="block px-3 py-1.5 rounded-md text-sm text-gray-700 hover:bg-gray-100 transition">
                        Portofolio domain
                    </a>

                    <a href="#"
                        class="block px-3 py-1.5 rounded-md text-sm text-gray-700 hover:bg-gray-100 transition">
                        Beli domain baru
                    </a>

                    <a href="#"
                        class="block px-3 py-1.5 rounded-md text-sm text-gray-700 hover:bg-gray-100 transition">
                        Transfer
                    </a>

                </div> --}}


                <p class="px-3 pt-4 text-xs font-medium uppercase tracking-wider text-gray-400">SETTING</p>


                <a href="{{ route('users.index') }}" wire:navigate
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('users.*') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="h-5 w-5 stroke-[1.6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="12" cy="8" r="4" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M4 20c0-4 4-6 8-6s8 2 8 6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    Pengguna
                </a>

                <a href="{{ route('roles.index') }}" wire:navigate
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('roles.*') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="h-5 w-5 stroke-[1.6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Roles & Permissions
                </a>

            </nav>




        </aside>

        {{-- Backdrop --}}
        <div x-cloak x-show="sidebarOpen" class="fixed inset-0 z-40 bg-gray-900/75 lg:hidden" x-transition.opacity
            @click="sidebarOpen = false"></div>

        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Header --}}
            <header
                class="flex h-16 shrink-0 items-center justify-between border-b border-gray-200 bg-white px-4 sm:px-6 lg:px-8">
                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>
                {{-- <div class="text-xl font-medium text-gray-800">
                    @yield('title')
                </div> --}}
                <div class="flex items-center space-x-3">
                </div>

                <livewire:partials.user-menu />
            </header>

            {{-- Main Content --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 lg:p-8">
                <div class="max-w-6xl mx-auto">
                    @yield('content')
                    {{ $slot ?? '' }}
                </div>
            </main>
        </div>
    </div>
    @stack('scripts')
    @livewireScripts
</body>




</html>
