<div x-data="{ dropdownOpen: false }" class="relative flex items-center space-x-3">
    <span class="text-sm font-medium text-gray-600 hidden sm:block">{{ $user->name }}</span>
    <button @click="dropdownOpen = !dropdownOpen"
        class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-white font-medium text-sm focus:outline-none">
        {{ strtoupper(substr($user->name, 0, 1)) }}
    </button>
    <div x-cloak x-show="dropdownOpen" @click.outside="dropdownOpen = false" x-transition
        class="absolute right-0 top-full mt-2 w-48 origin-top-right rounded-md bg-white border border-gray-200 z-50">

        <a href="{{ route('profile') }}" wire:navigate
            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            Profil Saya
        </a>

        <div class="border-t border-gray-100"></div>

        <button wire:click="logout" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
            Logout
        </button>
    </div>
</div>
