<div class="p-6 bg-white dark:bg-gray-900 shadow-md rounded-2xl space-y-6 max-w-7xl mx-auto h-[80vh] overflow-y-scroll mt-4"
    x-data="{
        openForm: @entangle('openForm'),
        showNotif: @entangle('showNotif'),
        deleteConfirmation: @entangle('deleteConfirmation'),
    }" x-init="setTimeout(() => loading = false, 500)">
    <x-dashboard.notification showNotif="showNotif" message="{{ $pesanNotif }}" status="{{ $statusNotif }}" />
    <button @click="openForm = true"
        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-xl shadow">
        + Jadwal Baru
    </button>
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">📜 History Pengiriman Jadwal</h2>

    <div class="overflow-x-auto">
        <table
            class="min-w-full border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-800 text-sm text-gray-600 dark:text-gray-300 uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">Nomor WA</th>
                    <th class="px-4 py-3 text-left">Pesan</th>
                    <th class="px-4 py-3 text-left">Jadwal Kirim</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody
                class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800 text-sm text-gray-700 dark:text-gray-200">
                @if($history->isEmpty())
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada riwayat pengiriman jadwal.
                        </td>
                    </tr>
                @else
                    @foreach ($history as $historyItem)
                        <tr>
                            <td class="px-4 py-3 font-mono text-blue-600 dark:text-blue-400 break-words max-w-36">
                                @php
                                    echo $historyItem->joinKontak?->nomor
                                        ? $historyItem->joinKontak->nama
                                        : collect(explode(',', $historyItem->no_tujuan))->map(function ($nomor) use ($daftarKontak) {
                                            $kontak = collect($daftarKontak)->firstWhere('nomor', $nomor);
                                            return $kontak ? $kontak['nama'] : $nomor;
                                        })->implode(',');
                                @endphp
                            </td>
                            <td class="px-4 py-3">{{ $historyItem->pesan }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::createFromTimestamp((int) $historyItem->scheduled_at, 'Asia/Jakarta')->translatedFormat('d F Y, H:i') . " WIB"}}</td>
                            <td class="px-4 py-3">
                                @php
                                    $isPast = \Carbon\Carbon::createFromTimestamp((int) $historyItem->scheduled_at, 'Asia/Jakarta')->isPast();
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full {{ $isPast ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }} ">
                                    {{ $isPast ? 'Terkirim' : 'Pending' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <button @click="deleteConfirmation = true"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-xs font-semibold shadow flex items-center gap-1 relative">
                                    <x-icons.trash wire:loading.remove wire:target="deleteHistory({{ $historyItem->id }})" />
                                    
                                    <div wire:loading wire:target='deleteHistory({{ $historyItem->id }})'
                                        class="h-4 w-4 animate-spin rounded-full border-2 border-solid border-white border-t-transparent absolute top-0 left-0 inset-0 m-auto">
                                    </div>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div x-show="openForm" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 overflow-y-auto">

        <!-- Modal Container -->
        <div x-show="openForm" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" @click.outside="openForm = false"
            class="w-full max-w-lg bg-white dark:bg-gray-900 rounded-xl shadow-xl p-6 space-y-6">

            <!-- Header -->
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Jadwalkan Pesan</h3>
                <button @click="openForm = false" class="text-gray-500 hover:text-gray-800 dark:hover:text-white">
                    ✖
                </button>
            </div>

            <!-- Form -->
            <form class="space-y-4" wire:submit='insertHistory'>
                <div x-data="{
                    daftarKontak: @js($daftarKontak),
                    search: '',
                    showList: false,
                    get filteredKontak() {
                        return this.daftarKontak.filter(k => k.nama.toLowerCase().includes(this.search.toLowerCase()))
                    },
                    tambahNomor(nomor) {
                        if (!$wire.no_tujuan.includes(nomor)) {
                            $wire.no_tujuan = $wire.no_tujuan ? $wire.no_tujuan + ',' + nomor : nomor;
                        }
                    }
                }" @click.away="showList = false" class="relative">

                    <!-- Input Nomor WA (fokus = munculkan daftar) -->
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor WA
                            Tujuan</label>
                        <input type="text" wire:model="no_tujuan" @focus="showList = true"
                            placeholder="628xxx,628xxx..."
                            class="w-full mt-1 rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring focus:ring-brand-200 dark:bg-gray-900 dark:border-gray-700 dark:text-white " />
                        @error('no_tujuan')
                            <span class="text-xs text-red-800">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Search Box (hanya muncul saat showList) -->
                    <div x-show="showList" x-transition>
                        <input type="text" x-model="search" placeholder="Cari nama kontak..."
                            class="w-full rounded-lg  px-3 py-2 text-sm focus:ring focus:ring-blue-200 dark:bg-gray-900 dark:border-gray-700 dark:text-white mb-2">
                    </div>

                    <!-- Daftar Kontak -->
                    <div x-show="showList" x-transition
                        class="absolute z-50 mt-1 max-h-48 w-full overflow-y-scroll rounded-lg  bg-white shadow dark:border-gray-700 dark:bg-gray-900 divide-y">
                        <template x-for="kontak in filteredKontak" :key="kontak.nomor">
                            <div @click="tambahNomor(kontak.nomor)"
                                class="cursor-pointer px-4 py-2 text-sm hover:bg-blue-100 dark:hover:bg-blue-900 dark:text-white">
                                <span x-text="kontak.nama"></span> – <span x-text="kontak.nomor"></span>
                            </div>
                        </template>
                        <div x-show="filteredKontak.length === 0"
                            class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">
                            Tidak ditemukan.
                        </div>
                    </div>
                </div>
                <div x-data="{ editHeader: false }">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Header Pesan</label>
                    <textarea rows="2"
                        :disabled="!editHeader"
                        wire:model='headerPesan'
                        class="mt-1 w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm px-4 py-2.5"
                    ></textarea>
                    @error('headerPesan')
                        <span class="text-xs text-red-800">{{ $message }}</span>
                    @enderror
                    <div class="flex items-center gap-2 mb-2">
                        <input type="checkbox" id="editHeader" x-model="editHeader"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <label for="editHeader" class="text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                            Edit Header Pesan
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">📝 Pesan</label>
                    <textarea rows="4" wire:model='pesan'
                        class="mt-1 w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm px-4 py-2.5"
                        placeholder="Tulis pesan yang ingin dijadwalkan..."></textarea>
                    @error('pesan')
                        <span class="text-xs text-red-800">{{ $message }}</span>
                    @enderror
                </div>
                <div x-data="{ editFooter: false }">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Footer Pesan</label>
                    <textarea rows="2"
                        :disabled="!editFooter"
                        wire:model='footerPesan'
                        class="mt-1 w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm px-4 py-2.5"
                    ></textarea>
                    @error('footerPesan')
                        <span class="text-xs text-red-800">{{ $message }}</span>
                    @enderror
                    <div class="flex items-center gap-2 mb-2">
                        <input type="checkbox" id="editFooter" x-model="editFooter"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <label for="editFooter" class="text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                            Edit Footer Pesan
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jadwal Kirim</label>
                    <input type="datetime-local" wire:model='scheduled_at'
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    @error('scheduled_at')
                        <span class="text-xs text-red-800">{{ $message }}</span>
                    @enderror
                </div>

                <div class="text-right">
                    <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 text-sm rounded-lg shadow flex items-center gap-2">
                        Buat Reminder
                        <div wire:loading wire:target='insertHistory'
                            class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>

     <!-- Delete Confirmator -->
    <div x-show="deleteConfirmation" x-cloak
        class="space-y-6 fixed inset-0 flex items-center justify-center bg-black/50 z-50 overflow-scroll scrollbar-hide">
        <div x-show="deleteConfirmation" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start ="opacity-0 -translate-y-52" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-52"
            @click.outside = "deleteConfirmation = !deleteConfirmation" x-cloak
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
                        anda akan menghapus data pengiriman pesan terjadwal ini. Data yang sudah dihapus tidak dapat
                        dikembalikan.
                    </p>
                    <div class="flex gap-x-2 mt-2">
                        <button 
                            wire:click="deleteHistory({{ $historyItem->id ?? '' }})" 
                            class="inline-flex items-center gap-2 px-4 py-1 text-sm font-medium text-white transition rounded-lg bg-red-500 shadow-theme-xs hover:bg-red-600 active:bg-red-500/50">
                            Hapus
                            <div wire:loading 
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

</div>
