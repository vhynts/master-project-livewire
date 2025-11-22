<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Daftar Pengguna</h1>
            <p class="mt-1 text-sm text-gray-500">
                Kelola data pengguna, role, dan status akun di dalam sistem.
            </p>
        </div>

        <a
            href="{{ route('users.create') }}"
            wire:navigate
            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
        >
            <svg class="h-4 w-4 stroke-[2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M12 5v14M5 12h14" stroke-linecap="round" />
            </svg>
            <span>Tambah Pengguna</span>
        </a>
    </div>

    {{-- Alert --}}
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

    {{-- Filters --}}
    <div class="space-y-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

            {{-- Search --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Cari Nama / Email
                </label>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="q"
                    placeholder="Ketik nama atau email..."
                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Role
                </label>
                <select
                    wire:model.live="role"
                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">Semua Role</option>
                    @foreach ($roles as $roleOption)
                        <option value="{{ $roleOption->name }}">
                            {{ ucfirst($roleOption->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Status
                </label>
                <select
                    wire:model.live="status"
                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div class="flex flex-col items-start justify-between gap-3 pt-2 sm:flex-row sm:items-center">
            <button
                type="button"
                wire:click="resetFilters"
                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
            >
                Reset Filter
            </button>

            <div class="flex items-center gap-2 text-xs text-gray-500">
                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-1">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    <span>{{ $users->total() }} pengguna ditemukan</span>
                </span>
            </div>
        </div>
    </div>

    {{-- Users Table --}}
    <div
        class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
        wire:loading.class="opacity-50 pointer-events-none"
    >
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        {{-- Pengguna --}}
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 cursor-pointer hover:bg-gray-100"
                            wire:click="sortBy('name')"
                        >
                            <div class="flex items-center gap-1">
                                <span>Pengguna</span>
                                @if ($sortCol === 'name')
                                    <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if ($sortAsc)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>

                        {{-- Email --}}
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 cursor-pointer hover:bg-gray-100"
                            wire:click="sortBy('email')"
                        >
                            <div class="flex items-center gap-1">
                                <span>Email</span>
                                @if ($sortCol === 'email')
                                    <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if ($sortAsc)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>

                        {{-- Role --}}
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Role
                        </th>

                        {{-- Status --}}
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 cursor-pointer hover:bg-gray-100"
                            wire:click="sortBy('status')"
                        >
                            <div class="flex items-center gap-1">
                                <span>Status</span>
                                @if ($sortCol === 'status')
                                    <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if ($sortAsc)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>

                        {{-- Aksi --}}
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50">
                            {{-- Pengguna --}}
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                   <div
    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-600 text-sm font-semibold uppercase text-white"
>
    {{ strtoupper(substr($user->name, 0, 1)) }}
</div>
                                    <div>
                                        <div class="font-medium text-gray-900">
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="px-4 py-3 text-gray-700">
                                {{ $user->email }}
                            </td>

                            {{-- Role(s) --}}
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @forelse ($user->roles as $role)
                                        @php
                                            $roleColor = match ($role->name) {
                                                'root'  => 'bg-purple-100 text-purple-700',
                                                'admin' => 'bg-blue-100 text-blue-700',
                                                default => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp
                                        <span class="rounded-md px-2 py-1 text-xs font-medium {{ $roleColor }}">
                                            {{ $role->name }}
                                        </span>
                                    @empty
                                        <span class="rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-500">
                                            Tidak ada role
                                        </span>
                                    @endforelse
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-3">
                                @if ($user->status === 'active')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                        <span>Aktif</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        <span>Tidak Aktif</span>
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">

                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('users.edit', $user) }}"
                                        wire:navigate
                                        class="inline-flex items-center justify-center rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                                        title="Edit Pengguna"
                                    >
                                        <svg class="h-4 w-4 stroke-[2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M16.5 3L21 7.5L8 20H3V15L16.5 3Z" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>

                                    {{-- Delete --}}
                                    <button
                                        type="button"
                                        class="inline-flex items-center justify-center rounded-lg p-2 text-red-600 hover:bg-red-50"
                                        title="Hapus Pengguna"
                                        @click="$dispatch('swal:confirm', {
                                            title: 'Apakah Anda yakin?',
                                            text: 'Pengguna yang dihapus tidak dapat dikembalikan!',
                                            icon: 'warning',
                                            method: 'deleteConfirmed',
                                            id: {{ $user->id }}
                                        })"
                                    >
                                        <svg class="h-4 w-4 stroke-[2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path
                                                d="M4 7h16M10 11v6M14 11v6M5 7l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M9 7V4h6v3"
                                                stroke-linecap="round"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">
                                Tidak ada pengguna yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex flex-col gap-2 border-t border-gray-100 px-4 py-3 text-xs text-gray-500 sm:flex-row sm:items-center sm:justify-between">
            <div>
                Menampilkan
                <span class="font-medium">{{ $users->firstItem() ?? 0 }}</span>
                -
                <span class="font-medium">{{ $users->lastItem() ?? 0 }}</span>
                dari
                <span class="font-medium">{{ $users->total() }}</span>
                data
            </div>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>

</div>
