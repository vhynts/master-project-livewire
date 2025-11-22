<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Manajemen Role</h1>
            <p class="mt-1 text-sm text-gray-500">
                Kelola role dan permissions yang digunakan di dalam sistem.
            </p>
        </div>

        <a href="{{ route('roles.create') }}" wire:navigate
           class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-xs hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
            <svg class="h-4 w-4 stroke-[2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M12 5v14M5 12h14" stroke-linecap="round" />
            </svg>
            <span>Tambah Role</span>
        </a>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            <div class="mt-0.5">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m-3-7a9 9 0 110 18 9 9 0 010-18z" />
                </svg>
            </div>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            <div class="mt-0.5">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v4m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
                </svg>
            </div>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    {{-- Search Filter --}}
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-xs">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div class="w-full sm:max-w-sm">
                <label class="block text-sm font-medium text-gray-700">
                    Cari Role
                </label>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari berdasarkan nama role..."
                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            <div class="flex items-center gap-2 text-xs text-gray-500">
                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-1">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    <span>{{ $roles->total() }} role terdaftar</span>
                </span>
            </div>
        </div>
    </div>

    {{-- Roles Table --}}
    <div
        class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xs"
        wire:loading.class="opacity-50 pointer-events-none"
    >
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Role
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Permissions
                        </th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($roles as $role)
                        <tr class="hover:bg-gray-50">
                            {{-- Role --}}
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                   <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-100 text-sm font-semibold uppercase text-gray-700">
    {{ strtoupper(substr($role->name, 0, 1)) }}
</div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-medium text-gray-900">
                                                {{ $role->name }}
                                            </span>
                                            @if ($role->name === 'root')
                                                <span class="inline-flex items-center rounded-full bg-purple-50 px-2 py-0.5 text-[11px] font-medium text-purple-700 ring-1 ring-purple-100">
                                                    Super Role
                                                </span>
                                            @endif
                                        </div>
                                        <!-- <p class="text-xs text-gray-500">
                                            Digunakan untuk mengatur akses pengguna.
                                        </p> -->
                                    </div>
                                </div>
                            </td>

                            {{-- Permissions count --}}
                            <td class="px-4 py-2 align-middle text-gray-700">
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">
                                    {{ $role->permissions_count }} permissions
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-3 text-right align-top">
                                <div class="flex items-center justify-end gap-2">

                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('roles.edit', $role->id) }}"
                                        wire:navigate
                                        class="inline-flex items-center justify-center rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                                        title="Edit Role"
                                    >
                                        <svg class="h-4 w-4 stroke-[2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M16.5 3L21 7.5L8 20H3V15L16.5 3Z" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>

                                    {{-- Delete (kecuali root) --}}
                                    @if ($role->name !== 'root')
                                        <button
                                            type="button"
                                            class="inline-flex items-center justify-center rounded-lg p-2 text-red-600 hover:bg-red-50"
                                            title="Hapus Role"
                                            @click="$dispatch('swal:confirm', {
                                                title: 'Apakah Anda yakin?',
                                                text: 'Role yang dihapus tidak dapat dikembalikan!',
                                                icon: 'warning',
                                                method: 'deleteConfirmed',
                                                id: {{ $role->id }}
                                            })"
                                        >
                                            <svg class="h-4 w-4 stroke-[2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path
                                                    d="M4 7h16M10 11v6M14 11v6M5 7l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M9 7V4h6v3"
                                                    stroke-linecap="round"
                                                />
                                            </svg>
                                        </button>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-sm text-gray-500">
                                Tidak ada role yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-between border-t border-gray-100 px-4 py-3 text-xs text-gray-500">
            <div>
                Menampilkan
                <span class="font-medium">{{ $roles->firstItem() ?? 0 }}</span>
                -
                <span class="font-medium">{{ $roles->lastItem() ?? 0 }}</span>
                dari
                <span class="font-medium">{{ $roles->total() }}</span>
                data
            </div>
            <div>
                {{ $roles->links() }}
            </div>
        </div>
    </div>

</div>
