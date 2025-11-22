<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">
                Edit Role: {{ $role->name }}
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Perbarui nama role dan permissions yang dimiliki role ini.
            </p>
        </div>

        <a href="{{ route('roles.index') }}" wire:navigate
           class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 19l-7-7m0 0 7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Card --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xs">
        <form wire:submit="save" class="flex flex-col">

            {{-- Body --}}
            <div class="space-y-6 p-6">

                {{-- Role Name --}}
                <div class="max-w-md">
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Nama Role
                    </label>
                    <input
                        id="name"
                        type="text"
                        wire:model="name"
                        placeholder="Contoh: editor, admin, manager"
                        @if($role->name === 'root') readonly title="Role root tidak dapat diubah namanya" @endif
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-xs focus:border-blue-500 focus:ring-blue-500 disabled:bg-gray-100 disabled:text-gray-500"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                    @if($role->name === 'root')
                        <p class="mt-1 text-xs text-gray-500">
                            Nama role <span class="font-semibold">root</span> tidak dapat diubah.
                        </p>
                    @endif
                </div>

                {{-- Permissions --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between gap-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Permissions
                            </label>
                            <p class="mt-1 text-xs text-gray-500">
                                Atur ulang permissions yang boleh digunakan oleh role ini.
                            </p>
                        </div>
                        <button
                            type="button"
                            @click="$wire.selectedPermissions = $wire.selectedPermissions.length === {{ $groupedPermissions->flatten()->count() }} ? [] : {{ $groupedPermissions->flatten()->pluck('name')->toJson() }}"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
                        >
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span x-text="$wire.selectedPermissions.length === {{ $groupedPermissions->flatten()->count() }} ? 'Uncheck All' : 'Check All'"></span>
                        </button>
                    </div>

                    <div class="space-y-4">
                        @foreach ($groupedPermissions as $group => $permissions)
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                                <div class="mb-3 flex items-center justify-between">
                                    <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-700">
                                        {{ $group }}
                                    </h3>
                                    <button
                                        type="button"
                                        @click="
                                            let groupPerms = {{ $permissions->pluck('name')->toJson() }};
                                            let allChecked = groupPerms.every(p => $wire.selectedPermissions.includes(p));
                                            if (allChecked) {
                                                $wire.selectedPermissions = $wire.selectedPermissions.filter(p => !groupPerms.includes(p));
                                            } else {
                                                $wire.selectedPermissions = [...new Set([...$wire.selectedPermissions, ...groupPerms])];
                                            }
                                        "
                                        class="inline-flex items-center gap-1.5 rounded-md border border-gray-300 bg-white px-2 py-1 text-xs font-medium text-gray-600 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition"
                                    >
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Check All</span>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
                                    @foreach ($permissions as $permission)
                                        @php
                                            $parts = explode('.', $permission->name);
                                            $displayName = count($parts) > 1 ? $parts[1] : $permission->name;
                                        @endphp

                                        <label class="flex cursor-pointer items-center gap-3 rounded-md bg-white px-3 py-2 text-sm text-gray-700 shadow-xs ring-1 ring-gray-200 hover:bg-gray-50">
                                            <input
                                                type="checkbox"
                                                value="{{ $permission->name }}"
                                                wire:model="selectedPermissions"
                                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                            >
                                            <span class="truncate">
                                                {{ Str::of($displayName)->replace('_', ' ')->headline() }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4">
                <a href="{{ route('roles.index') }}" wire:navigate
                   class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                    Batal
                </a>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-xs hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-70 transition"
                >
                    <svg
                        wire:loading
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
                    <span wire:loading.remove>
                        Simpan Perubahan
                    </span>
                </button>
            </div>

        </form>
    </div>

</div>
