<div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 "x-data="{
    openForm: $wire.entangle('openForm'),
    action: '{{ $action }}',
    openWarningDelete: $wire.entangle('openWarningDelete'),
    showNotif: $wire.entangle('showNotif'),
    showDetail: $wire.entangle('showDetail'), }"x-init="setTimeout(() => loading = false, 500)">
    {{-- HEADER --}}
    
        <!-- Delete Confirmator -->
        <div x-show="openWarningDelete"
            class="space-y-6 fixed inset-0 flex items-center justify-center bg-black/50 z-50 overflow-scroll scrollbar-hide">
            <div x-show="openWarningDelete" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start ="opacity-0 -translate-y-52" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-52"
                @click.outside = "openWarningDelete = !openWarningDelete"
                class="rounded-xl border border-warning-500 bg-warning-50 p-4 dark:border-warning-500/30 dark:bg-warning-500/15">
                <div class="flex items-start gap-3">
                    <div class="-mt-0.5 text-warning-500 dark:text-orange-400">
                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.6501 12.0001C3.6501 7.38852 7.38852 3.6501 12.0001 3.6501C16.6117 3.6501 20.3501 7.38852 20.3501 12.0001C20.3501 16.6117 16.6117 20.3501 12.0001 20.3501C7.38852 20.3501 3.6501 16.6117 3.6501 12.0001ZM12.0001 1.8501C6.39441 1.8501 1.8501 6.39441 1.8501 12.0001C1.8501 17.6058 6.39441 22.1501 12.0001 22.1501C17.6058 22.1501 22.1501 17.6058 22.1501 12.0001C22.1501 6.39441 17.6058 1.8501 12.0001 1.8501ZM10.9992 7.52517C10.9992 8.07746 11.4469 8.52517 11.9992 8.52517H12.0002C12.5525 8.52517 13.0002 8.07746 13.0002 7.52517C13.0002 6.97289 12.5525 6.52517 12.0002 6.52517H11.9992C11.4469 6.52517 10.9992 6.97289 10.9992 7.52517ZM12.0002 17.3715C11.586 17.3715 11.2502 17.0357 11.2502 16.6215V10.945C11.2502 10.5308 11.586 10.195 12.0002 10.195C12.4144 10.195 12.7502 10.5308 12.7502 10.945V16.6215C12.7502 17.0357 12.4144 17.3715 12.0002 17.3715Z"
                                fill="" />
                        </svg>
                    </div>

                    <div>
                        <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                            Perhatian, anda akan menghapus kegiatan secara <b>Permanen</b>
                        </h4>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            anda akan menghapus {{ $this->nama ?? '' }}
                        </p>
                        <div class="flex gap-x-2 mt-2">
                            <button wire:click="deletePetugas('{{ $this->id }}')"
                                class="inline-flex items-center gap-2 px-4 py-1 text-sm font-medium text-white transition rounded-lg bg-red-500 shadow-theme-xs hover:bg-red-600 active:bg-red-500/50">
                                Hapus
                                <div wire:loading wire:target="deletePetugas('{{ $this->id }}')"
                                    class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
                                </div>
                            </button>
                            <button @click="openWarningDelete = false" wire:prevent
                                class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-1 text-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                                batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Confirmator -->
    <x-dashboard.notification showNotif="showNotif" message="{{ $message }}" status="{{ $status }}" />
    <div class="flex flex-col items-start mb-6">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Petugas-petugas</h2>
        <hr class="w-full my-2 border-gray-300 dark:border-gray-600">
        <div class="flex items-center gap-3 w-full mt-2">
            <input wire:model.live.debounce.500ms="search" type="text" placeholder="Cari nama petugas..."
                class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 shadow-inner outline-none focus:ring-4 focus:ring-blue-300 transition w-2/4">
            <button type="button" wire:click="tambahForm"
                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg shadow-md flex items-center gap-2 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah
            </button>
        </div>
    </div>
    
    {{-- MODAL --}}
    <div x-show="openForm" x-transition x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
        style="overflow-y:auto">
        <div @click.outside="openForm = false"
            class="bg-white dark:bg-gray-900 rounded-lg shadow-2xl p-10 w-full max-w-4xl mt-20 relative">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8 border-b pb-4">
                {{ $action === 'Edit' ? 'Edit Kegiatan' : 'Tambah Kegiatan' }}
            </h2>

            <form wire:submit.prevent="simpanData" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Input Nama --}}
                <div>
                    <label for="nama" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">Nama</label>
                        <input type="hidden" wire:model.lazy="action">
                    <input type="text" id="nama" wire:model.defer="nama"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 focus:ring focus:ring-blue-300 px-5 py-3 text-gray-900 dark:text-white">
                    @error('nama')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Input No. Rekening --}}
                <div>
                    <label for="no_rek" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">No.
                        Rekening</label>    <input type="hidden" wire:model.lazy="action">
                    <input type="text" id="no_rek" wire:model.defer="no_rek"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 focus:ring focus:ring-blue-300 px-5 py-3 text-gray-900 dark:text-white">
                    @error('no_rek')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="md:col-span-2">
                    <label for="statusDb"
                        class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">Status</label>    <input type="hidden" wire:model.lazy="action">
                    <select wire:model.defer="statusDb"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 focus:ring focus:ring-blue-300 px-5 py-3 text-gray-900 dark:text-white">
                        <option value="">Pilih Status</option>
                        <option value="0">Pegawai</option>
                        <option value="1">Kemitraan</option>
                    </select>
                    @error('statusDb')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="md:col-span-2 flex justify-end gap-4 mt-6">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg transition flex items-center gap-3">
                 {{ $action === 'Edit' ? 'Update' : 'Simpan' }}
                        <div wire:loading wire:target="simpanData"
                            class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
                        </div>
                    </button>
                    <button type="button" @click="openForm = false"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-lg transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL --}}
    <table class="w-full mt-4 text-left text-sm text-gray-900 dark:text-gray-200">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th class="py-3 px-5">ID</th>
                <th class="py-3 px-5">Nama</th>
                <th class="py-3 px-5">No. Rekening</th>
                <th class="py-3 px-5">Status</th>
                <th class="py-3 px-5">Kegiatan</th>
                <th class="py-3 px-5 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($listPetugas as $item)
                <tr
                    class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <td class="py-3 px-5">{{ $item->id }}</td>
                    <td class="py-3 px-5">{{ $item->nama }}</td>
                    <td class="py-3 px-5">{{ $item->no_rek }}</td>
                    <td class="py-3 px-5">{{ $item->status === 0 ? 'Pegawai' : 'Kemitraan' }}</td>
                    <td class="py-3 px-5">
                        @php
                            $kegiatanPml = collect($item->getKegiatanPml)
                                ->map(fn($kegiatan) => $kegiatan->joinKegiatan?->alias)
                                ->unique()
                                ->filter();

                            $kegiatanPcl = collect($item->getKegiatanPcl)
                                ->map(fn($kegiatan) => $kegiatan->joinKegiatan?->alias)
                                ->unique()
                                ->filter();
                        @endphp

                        @foreach ($kegiatanPml as $alias)
                            <span
                                class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 mb-1">
                                {{ $alias }}
                            </span>
                        @endforeach
                        @foreach ($kegiatanPcl as $alias)
                            <span
                                class="inline-block bg-green-100 text-green-800 text-xs font-semibold mr-1 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 mb-1">
                                {{ $alias }}
                            </span>
                        @endforeach
                    </td>
                    <td ><button wire:click="editPetugas('{{ $item->id }}')"
                                class="inline-flex items-center px-2 py-1 m-3 bg-orange-400 hover:bg-orange-500 text-white rounded-lg text-xs font-medium transition shadow-sm"
                                type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0L9 13zm-6 6h6" />
                                </svg>
                                Sunting
                            </button>
                             <button wire:click="confirmDelete('{{ $item->id }}')"
                                class="inline-flex items-center px-2 py-1 m-3 bg-red-400 hover:bg-red-500 text-white rounded-lg text-xs font-medium transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Hapus
                            </button>
                        </td>

                </tr>

            @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-500">Belum ada data petugas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
