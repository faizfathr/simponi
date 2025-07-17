<div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 " x-data="{ openForm: @entangle('openForm'), showNotif: $wire.entangle('showNotif'), message: @entangle('message'), status: @entangle('status') }">
    {{-- HEADER --}}
    <x-dashboard.notification showNotif="showNotif" message="{{ $message }}" status="{{ $status }}" />
    <div class="flex flex-col items-start mb-6">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Petugas-petugas</h2>
        <hr class="w-full my-2 border-gray-300 dark:border-gray-600">
        <div class="flex items-center gap-3 w-full mt-2">
            <input wire:model.live.debounce.500ms="search" type="text" placeholder="Cari nama petugas..."
                class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 shadow-inner focus:ring-4 focus:ring-blue-300 transition w-2/4">
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
                Tambah Petugas
            </h2>

            <form wire:submit.prevent="simpanData" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Input Nama --}}
                <div>
                    <label for="nama" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">Nama</label>
                    <input type="text" id="nama" wire:model.defer="nama"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 focus:ring focus:ring-blue-300 px-5 py-3 text-gray-900 dark:text-white">
                    @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Input No. Rekening --}}
                <div>
                    <label for="no_rek"
                        class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">No. Rekening</label>
                    <input type="text" id="no_rek" wire:model.defer="no_rek"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 focus:ring focus:ring-blue-300 px-5 py-3 text-gray-900 dark:text-white">
                    @error('no_rek') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Status --}}
                <div class="md:col-span-2">
                    <label for="statusDb"
                        class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">Status</label>
                    <select wire:model.defer="statusDb"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 focus:ring focus:ring-blue-300 px-5 py-3 text-gray-900 dark:text-white">
                        <option value="">Pilih Status</option>
                        <option value="0">Pegawai</option>
                        <option value="1">Kemitraan</option>
                    </select>
                    @error('statusDb') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="md:col-span-2 flex justify-end gap-4 mt-6">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-lg shadow-lg transition">
                        Simpan
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
            </tr>
        </thead>
        <tbody>
            @forelse ($listPetugas as $item)
                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <td class="py-3 px-5">{{ $item->id }}</td>
                    <td class="py-3 px-5">{{ $item->nama }}</td>
                    <td class="py-3 px-5">{{ $item->no_rek }}</td>
                    <td class="py-3 px-5">{{ $item->status === 0 ? 'Pegawai' : 'Kemitraan' }}</td>
                    <td class="py-3 px-5">-</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-500">Belum ada data petugas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

