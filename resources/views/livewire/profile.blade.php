<div class="space-y-6">

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- User Details -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">Informasi Profil</h2>
            <p class="mt-1 text-sm text-gray-600">Detail informasi pribadi Anda.</p>
        </div>
        <div class="border-t border-gray-200 px-6 py-4">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Nama</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Alamat Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Role</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        @foreach ($user->roles as $role)
                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-md font-medium">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        @if ($user->status == 'active')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-md font-medium">
                                Aktif
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-md font-medium">
                                Tidak Aktif
                            </span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Change Password Form -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">Ganti Password</h2>
            <p class="mt-1 text-sm text-gray-600">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</p>
        </div>

        <form wire:submit="updatePassword" class="border-t border-gray-200">
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                    <div class="sm:col-span-4">
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                        <input type="password" wire:model="current_password" id="current_password"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('current_password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <input type="password" wire:model="password" id="password"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                        <input type="password" wire:model="password_confirmation" id="password_confirmation"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>
            </div>

            <div class="p-6 bg-gray-50 flex items-center justify-end gap-3 rounded-b-xl">
                <button type="submit"
                    class="inline-flex justify-center items-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors disabled:opacity-70 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled">
                    <svg wire:loading wire:target="updatePassword" class="mr-2 h-4 w-4 animate-spin text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                        </path>
                    </svg>
                    <span wire:loading.remove wire:target="updatePassword">Simpan Perubahan</span>
                    <span wire:loading wire:target="updatePassword">Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>
