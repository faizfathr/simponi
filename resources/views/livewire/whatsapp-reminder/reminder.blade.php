<div class="p-6 bg-white dark:bg-gray-900 shadow-md rounded-2xl space-y-6 max-w-7xl mx-auto h-[80vh] overflow-y-scroll mt-4"
    x-data="{
        openForm: @entangle('openForm'),
        showNotif: @entangle('showNotif')
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
                </tr>
            </thead>
            <tbody
                class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800 text-sm text-gray-700 dark:text-gray-200">
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
                        <td class="px-4 py-3">{{ $historyItem->scheduled_at }}</td>
                        <td class="px-4 py-3">
                            @php
                                $isPast = \Carbon\Carbon::parse($historyItem->scheduled_at, 'Asia/Jakarta')->isPast();
                            @endphp
                            <span
                                class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full {{ $isPast ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }} ">
                                {{ $isPast ? 'Terkirim' : 'Pending' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
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
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 text-sm rounded-lg shadow">
                        Buat Reminder
                        <div wire:loading wire:target='insertHistory'
                            class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>


</div>
