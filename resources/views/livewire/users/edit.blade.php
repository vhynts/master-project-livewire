<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Edit Pengguna</h1>
            <p class="mt-1 text-sm text-gray-500">
                Perbarui data pengguna di bawah ini. Pastikan data sudah benar sebelum menyimpan.
            </p>
        </div>

        <a
            href="{{ route('users.index') }}"
            wire:navigate
            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-xs hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 19l-7-7m0 0 7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Card --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xs">

        {{-- Card Header --}}
        <div class="border-b border-gray-200 px-6 py-4">
            <h2 class="text-base font-medium text-gray-900">
                Detail Pengguna
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Ubah informasi pengguna, role, dan status akun sesuai kebutuhan.
            </p>
        </div>

        {{-- Form --}}
        <form wire:submit="save" class="flex flex-col">

            {{-- Body --}}
            <div class="space-y-6 p-6">

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    {{-- Nama --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nama
                        </label>
                        <input
                            id="name"
                            type="text"
                            wire:model="name"
                            required
                            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-xs focus:border-blue-600 focus:ring-blue-600"
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <input
                            id="email"
                            type="email"
                            wire:model="email"
                            required
                            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-xs focus:border-blue-600 focus:ring-blue-600"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password (opsional) --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password (Opsional)
                        </label>
                        <input
                            id="password"
                            type="password"
                            wire:model="password"
                            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-xs focus:border-blue-600 focus:ring-blue-600"
                            placeholder="Isi jika ingin mengganti password"
                        >
                        <p class="mt-1 text-xs text-gray-500">
                            Biarkan kosong jika tidak ingin mengubah password.
                        </p>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            Konfirmasi Password
                        </label>
                        <input
                            id="password_confirmation"
                            type="password"
                            wire:model="password_confirmation"
                            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-xs focus:border-blue-600 focus:ring-blue-600"
                            placeholder="Ulangi password baru"
                        >
                    </div>

                    {{-- Role --}}
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">
                            Role
                        </label>
                        <select
                            id="role"
                            wire:model="role"
                            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-xs focus:border-blue-600 focus:ring-blue-600"
                        >
                            @foreach ($roles as $roleOption)
                                <option value="{{ $roleOption->name }}">
                                    {{ ucfirst($roleOption->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">
                            Status
                        </label>
                        <select
                            id="status"
                            wire:model="status"
                            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-xs focus:border-blue-600 focus:ring-blue-600"
                        >
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 rounded-b-xl">
                <a
                    href="{{ route('users.index') }}"
                    wire:navigate
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-xs hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-70 transition"
                >
                    <svg
                        wire:loading
                        wire:target="save"
                        class="h-4 w-4 animate-spin text-white"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                        ></path>
                    </svg>

                    <span wire:loading.remove wire:target="save">
                        Simpan Perubahan
                    </span>
                    <span wire:loading wire:target="save">
                        Menyimpan...
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>
