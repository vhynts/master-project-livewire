<div>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang</h2>
        <p class="text-sm text-gray-600">silakan masuk untuk melanjutkan</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md mb-6" role="alert">
            <p class="font-bold">Oops!</p>
            <p>{{ $errors->first() }}</p>
        </div>
    @endif

    <form wire:submit="login" class="space-y-6" x-data="{ showPassword: false }">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
            <input wire:model="email" id="email" type="email" required autofocus autocomplete="username"
                class="w-full px-4 py-2 mt-2 border border-gray-300 bg-white text-gray-900 rounded-md shadow-xs focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <div class="relative mt-2">
                <input wire:model="password" id="password" :type="showPassword ? 'text' : 'password'" required
                    autocomplete="current-password"
                    class="w-full pr-10 px-4 py-2 border border-gray-300 bg-white text-gray-900 rounded-md shadow-xs focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                <button type="button"
                    class="absolute inset-y-0 right-2 inline-flex items-center px-2 text-gray-500 hover:text-gray-700 focus:outline-none"
                    @click="showPassword = !showPassword">
                    <svg x-show="!showPassword" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showPassword" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.986 9.986 0 012.57-4.042m1.7-1.7A9.957 9.957 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.96 9.96 0 01-1.436 2.9M3 3l18 18" />
                    </svg>
                </button>
            </div>
           
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center space-x-2">
                <input wire:model="remember" id="remember" type="checkbox"
                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="block text-sm text-gray-900">Ingat saya</span>
            </label>
        </div>

        <div>
            <button type="submit" wire:loading.attr="disabled"
                class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-md shadow-xs text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors disabled:opacity-70 disabled:cursor-not-allowed">
                <svg wire:loading wire:target="login" class="mr-2 h-4 w-4 animate-spin text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                    </path>
                </svg>
                <span wire:loading.remove wire:target="login">Masuk</span>
                <span wire:loading wire:target="login">Masuk....</span>
            </button>
        </div>
    </form>

    <div class="mt-6 text-center text-sm">
        <p class="text-gray-600">
            Belum punya akun?
            <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                Daftar
            </a>
        </p>
    </div>
</div>
