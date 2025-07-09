<div x-data="{
    openForm: @entangle('openForm'),
    idTabel: @entangle('id_tabel'),
    showNotif: @entangle('showNotif'),
    monitorings: @js($monitorings),
    event: @js($event),
    formatJadwal(tglMulai, tglSelesai) {
        if (!tglMulai || !tglSelesai) return 'Tanggal Belum diatur';

        const bulan = [
            '', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        const dateMulai = new Date(tglMulai);
        const dateSelesai = new Date(tglSelesai);

        const hariMulai = dateMulai.getDate();
        const hariSelesai = dateSelesai.getDate();
        const bulanMulai = dateMulai.getMonth() + 1;
        const bulanSelesai = dateSelesai.getMonth() + 1;
        const tahunMulai = dateMulai.getFullYear();
        const tahunSelesai = dateSelesai.getFullYear();

        if (bulanMulai === bulanSelesai) {
            return `${hariMulai} - ${hariSelesai} ${bulan[bulanSelesai]} ${tahunSelesai}`;
        } else {
            return `${hariMulai} ${bulan[bulanMulai]} - ${hariSelesai} ${bulan[bulanSelesai]} ${tahunSelesai}`;
        }
    },
}" x-init="setTimeout(() => loading = false, 500)">
    <x-dashboard.notification showNotif="showNotif" message="{{ $message }}" status="{{ $status }}" />
    @if (Auth::user() && intVal(Auth::user()?->id_role) === 3)
        <div class="flex items-center gap-x-2 mb-2 w-full">
            <a href="#" @click.prevent="history.back()"
                class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
            </a>
            <button wire:click.prevent="openModalForm"
                class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                <span class="mr-1 text-xs hidden md:block">Tambah Manual</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <div wire:loading wire:target='openModalForm'
                    class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
                </div>
            </button>
            <a href="/dashboard/downloadTemplate/{{ $id_tabel }}"
                class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-success-500 shadow-theme-xs hover:bg-success-600">
                <span class="mr-1 text-xs hidden md:block">Template</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
            </a>
            <a href="/dashboard/downloadDirektori"
                class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-success-500 shadow-theme-xs hover:bg-success-600">
                <span class="mr-1 text-xs hidden md:block">Direktori</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
            </a>
            <form wire:submit.prevent='import'>
                <div class="flex gap-x-2 items-center">
                    <div
                        class="relative z-0 text-white transition rounded-lg bg-success-500 shadow-theme-xs hover:bg-success-600">
                        <label for="template-input" class="text-xs flex gap-x-2 h-full p-2 cursor-pointer">Import
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                            </svg>
                        </label>
                        <input type="file" wire:model='file'
                            class="w-full h-full absolute top-0 left-0 opacity-0 cursor-pointer">
                    </div>
                    <div wire:loading wire:target='file'
                        class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-success-500 border-t-transparent">
                    </div>
                    @if ($file)
                        <span class="font-semibold text-gray-500 text-xs">{{ $file->getClientOriginalName() }}</span>
                        <button
                            class="inline-flex items-center p-2 text-xs font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600"
                            type="submit">Upload
                            <div wire:loading wire:target='import'
                                class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent ml-2">
                            </div>
                        </button>
                    @endif
                </div>
            </form>
        </div>
    @endif
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto custom-scrollbar h-[80vh]" x-data="{
            columns: {
                no: true,
                jadwal: true,
                proses: true,
                status: true,
                pcl: true,
                pml: true,
                @foreach ($sampel_header as $key => $item) sampel{{ $key }}: true, @endforeach
                @foreach ($prosess_header as $key => $item) proses{{ $key }}: true, @endforeach
            }
        }">
            @if ($idPage)
                <div class="sticky top-0 z-30 bg-white dark:bg-gray-900" x-data="{ openColumnFilter: false }">
                    <div class="text-sm text-gray-700 dark:text-gray-300 relative w-fit p-2">
                        <!-- Toggle Button -->
                        <div class="flex gap-x-2">
                            <button @click="openColumnFilter = !openColumnFilter"
                                class="flex items-center gap-2 cursor-pointer font-semibold text-white transition-all bg-slate-500 dark:bg-gray-800 rounded-lg p-2">
                                <!-- SVG Palu & Tang -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                                </svg>

                                <span class="text-xs">Pilih Kolom</span>
                            </button>
                            <button
                                class="flex items-center gap-2 cursor-pointer font-semibold text-white transition-all bg-slate-500 dark:bg-gray-800 rounded-lg p-2">
                                <!-- SVG Palu & Tang -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                                </svg>
                                <span class="text-xs">Terapkan Filter</span>
                            </button>
                        </div>

                        <!-- Dropdown Kolom Checkbox -->
                        <div x-show="openColumnFilter" @click.outside="openColumnFilter = false" x-transition
                            class="absolute mt-2 z-50 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-4 grid grid-cols-2 md:grid-cols-3 gap-3 w-[400px] max-h-[400px] overflow-y-auto custom-scrollbar">

                            <!-- Kolom "No" -->
                            <label class="flex items-center gap-2">
                                <input type="checkbox" x-model="columns.no"
                                    class="accent-brand-500 rounded focus:ring-0" />
                                <span>No</span>
                            </label>

                            <!-- Kolom Sampel -->
                            @foreach ($sampel_header as $key => $item)
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" x-model="columns.sampel{{ $key }}"
                                        class="accent-brand-500 rounded focus:ring-0" />
                                    <span>{{ $item }}</span>
                                </label>
                            @endforeach

                            <!-- Kolom Jadwal -->
                            <label class="flex items-center gap-2">
                                <input type="checkbox" x-model="columns.jadwal"
                                    class="accent-brand-500 rounded focus:ring-0" />
                                <span>Jadwal</span>
                            </label>

                            <!-- Kolom Proses -->
                            @foreach ($prosess_header as $key => $item)
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" x-model="columns.proses{{ $key }}"
                                        class="accent-brand-500 rounded focus:ring-0" />
                                    <span>{{ $item }}</span>
                                </label>
                            @endforeach

                            <!-- Kolom Status -->
                            <label class="flex items-center gap-2">
                                <input type="checkbox" x-model="columns.status"
                                    class="accent-brand-500 rounded focus:ring-0" />
                                <span>Status</span>
                            </label>

                            <!-- Kolom PCL -->
                            <label class="flex items-center gap-2">
                                <input type="checkbox" x-model="columns.pcl"
                                    class="accent-brand-500 rounded focus:ring-0" />
                                <span>PCL</span>
                            </label>

                            <!-- Kolom PML -->
                            <label class="flex items-center gap-2">
                                <input type="checkbox" x-model="columns.pml"
                                    class="accent-brand-500 rounded focus:ring-0" />
                                <span>PML</span>
                            </label>
                        </div>
                    </div>
                </div>
                <table class="min-w-full custom-scrollbar h-auto overflow-y-auto">
                    <!-- table header start -->
                    <!-- Filter Row -->
                    <thead class="sticky top-[50px]  z-10 bg-gray-200 dark:bg-gray-800">
                        <!-- Baris Judul Kolom -->
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <th x-show="columns.no"
                                class="px-5 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                <span>No</span>
                            </th>

                            @foreach ($sampel_header as $itemSampel)
                                <th x-show="columns.sampel{{ $loop->index }}"
                                    class="px-5 py-3 sm:px-6 text-center text-xs font-medium text-gray-500 dark:text-gray-400">
                                    {{ $itemSampel }}
                                </th>
                            @endforeach

                            <th x-show="columns.jadwal"
                                class="px-5 py-3 sm:px-6 text-center text-xs font-medium text-gray-500 dark:text-gray-400">
                                Jadwal</th>

                            @foreach ($prosess_header as $itemProses)
                                <th x-show="columns.proses{{ $loop->index }}"
                                    class="px-5 py-3 sm:px-6 text-center text-xs font-medium text-gray-500 dark:text-gray-400">
                                    {{ $itemProses }}
                                </th>
                            @endforeach

                            <th x-show="columns.status"
                                class="px-5 py-3 sm:px-6 text-xs font-medium text-gray-500 dark:text-gray-400">
                                Status
                            </th>
                            <th x-show="columns.pcl"
                                class="px-5 py-3 sm:px-6 text-xs font-medium text-gray-500 dark:text-gray-400">PCL
                            </th>
                            <th x-show="columns.pml"
                                class="px-5 py-3 sm:px-6 text-xs font-medium text-gray-500 dark:text-gray-400">PML
                            </th>
                        </tr>

                        <!-- Baris Input Filter -->
                        <tr class="border-b border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-900">
                            <th class="px-5 py-2 sm:px-6" x-show="columns.no">
                                <input type="text" placeholder="No"
                                    class="w-full text-xs rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-white px-2 py-1 focus:ring-brand-500 focus:border-brand-500" />
                            </th>

                            @foreach ($sampel_header as $item)
                                <th x-show="columns.sampel{{ $loop->index }}" class="px-5 py-2 sm:px-6">
                                    <input type="text" placeholder="{{ $item }}"
                                        class="w-full text-xs rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-white px-2 py-1 focus:ring-brand-500 focus:border-brand-500" />
                                </th>
                            @endforeach

                            <th x-show="columns.jadwal" class="px-5 py-2 sm:px-6">
                                <input type="text" placeholder="Cari Jadwal"
                                    class="w-full text-xs rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-white px-2 py-1 focus:ring-brand-500 focus:border-brand-500" />
                            </th>

                            @foreach ($prosess_header as $item)
                                <th x-show="columns.proses{{ $loop->index }}" class="px-5 py-2 sm:px-6">
                                    <select
                                        class="w-full text-xs rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-white px-2 py-1 focus:ring-brand-500 focus:border-brand-500">
                                        <option value="">{{ $item }}</option>
                                        <option value="1">✓</option>
                                        <option value="0">✗</option>
                                    </select>
                                </th>
                            @endforeach

                            <th x-show="columns.status" class="px-5 py-2 sm:px-6">
                                <select
                                    class="w-full text-xs rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-white px-2 py-1 focus:ring-brand-500 focus:border-brand-500">
                                    <option value="">Status</option>
                                    <option value="0">Belum</option>
                                    <option value="1">Progres</option>
                                    <option value="2">Selesai</option>
                                </select>
                            </th>

                            <th x-show="columns.pcl" class="px-5 py-2 sm:px-6">
                                <select
                                    class="w-full text-xs rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-white px-2 py-1 focus:ring-brand-500 focus:border-brand-500">
                                    <option value="">PCL</option>
                                    @foreach ($pcl as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </th>

                            <th x-show="columns.pml" class="px-5 py-2 sm:px-6">
                                <select
                                    class="w-full text-xs rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-white px-2 py-1 focus:ring-brand-500 focus:border-brand-500">
                                    <option value="">PML</option>
                                    @foreach ($pml as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </th>
                        </tr>
                    </thead>


                    <!-- table header end -->
                    <!-- table body start -->
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                        @if ($monitorings)
                            @foreach ($monitorings as $row => $monitoring)
                                <tr>
                                    <td x-show="columns.no" class="px-6 py-2">
                                        <div class="flex items-center">
                                            <div class="flex items-center gap-3">
                                                <span class="font-medium text-gray-800 text-xs dark:text-white/90">
                                                    {{ $row + 1 }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    @foreach ($allItem[$row]['sampel_body'] as $key => $itemSampelBody)
                                        <td x-show="columns.sampel{{ $key }}"
                                            class="px-0.5 py-2 whitespace-nowrap">
                                            <input
                                                wire:model='allItem.{{ $row }}.sampel_body.{{ $key }}'
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 rounded-lg border border-gray-300 bg-transparent px-4 py-1 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 max-w-max" />
                                        </td>
                                    @endforeach
                                    <td x-show="columns.jadwal" class="px-0.5 py-2 whitespace-nowrap">
                                        <p class="text-gray-500 text-xs dark:text-gray-400">
                                            {{ is_null($event->tanggal_mulai) || is_null($event->tanggal_selesai) ? 'Tanggal Belum diatur' : (date('m', strtotime($event->tanggal_mulai)) === date('m', strtotime($event->tanggal_selesai)) ? date('d', strtotime($event->tanggal_mulai)) . date(' - d ', strtotime($event->tanggal_selesai)) . $bulan[(int) date('m', strtotime($event->tanggal_selesai))] . date(' Y', strtotime($event->tanggal_selesai)) : date('d', strtotime($event->tanggal_mulai)) . ' ' . $bulan[(int) date('m', strtotime($event->tanggal_mulai))] . date(' - d ', strtotime($event->tanggal_selesai)) . $bulan[(int) date('m', strtotime($event->tanggal_selesai))] . date(' Y', strtotime($event->tanggal_selesai))) }}
                                        </p>
                                    </td>
                                    @foreach ($allItem[$row]['prosess'] as $key => $itemProsesBody)
                                        <td x-show="columns.proses{{ $key }}" class="px-0.5 py-2">
                                            <div x-data="{ checkboxToggle{{ $monitoring['id'] }}{{ $key }}: {{ $itemProsesBody === '1' ? 'true' : 'false' }} }">
                                                <label for="checkboxLabel{{ $monitoring['id'] }}{{ $key }}"
                                                    class="flex justify-center cursor-pointer select-none ">
                                                    <div class="relative">
                                                        <input
                                                            wire:model='allItem.{{ $row }}.prosess.{{ $key }}'
                                                            type="checkbox"
                                                            id="checkboxLabel{{ $monitoring['id'] }}{{ $key }}"
                                                            class="sr-only"
                                                            :checked='checkboxToggle{{ $monitoring['id'] }}{{ $key }}'
                                                            @change="checkboxToggle{{ $monitoring['id'] }}{{ $key }} = !checkboxToggle{{ $monitoring['id'] }}{{ $key }}" />
                                                        <div :class="checkboxToggle{{ $monitoring['id'] }}{{ $key }} ?
                                                            'border-brand-500 bg-brand-500' :
                                                            'bg-transparent border-gray-300 dark:border-gray-700'"
                                                            class="hover:border-brand-500 dark:hover:border-brand-500 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]">
                                                            <span
                                                                :class="checkboxToggle{{ $monitoring['id'] }}{{ $key }}
                                                                    ?
                                                                    '' : 'opacity-0'">
                                                                <svg width="14" height="14"
                                                                    viewBox="0 0 14 14" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7"
                                                                        stroke="white" stroke-width="1.94437"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round" />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </td>
                                    @endforeach
                                    <td x-show="columns.status" class="px-0.5 py-2">
                                        <div class="flex items-center">
                                            <p
                                                class="rounded-full px-2 py-0.5 text-xs font-medium {{ (int) $allItem[$row]['status'] === 0 ? 'bg-gray-50 text-gray-600' : ((int) $allItem[$row]['status'] === 1 ? 'bg-warning-50 text-orange-600' : 'bg-success-50 text-success-600') }} dark:bg-success-500/15 dark:text-success-500">
                                                {{ (int) $allItem[$row]['status'] === 0 ? 'Belum Terlaksana' : ((int) $allItem[$row]['status'] === 1 ? 'On Progres' : 'Selesai') }}
                                            </p>
                                        </div>
                                    </td>
                                    <td x-show="columns.pcl" class="px-0.5">
                                        <select wire:model='allItem.{{ $row }}.pcl'
                                            class="dark:bg-dark-900  shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 max-w-max appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-2 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                            <option
                                                class="text-gray-700 dark:bg-gray-900 dark:text-gray-400 hidden text-center">
                                                --- Petugas ---
                                            </option>
                                            @foreach ($pcl as $key => $p)
                                                <option value="{{ $p->id }}"
                                                    class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                    {{ $p->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td x-show="columns.pml" class="px-0.5">
                                        <div class="flex items-center">
                                            <select wire:model='allItem.{{ $row }}.pml'
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 max-w-max appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-2 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                                <option
                                                    class="text-gray-700 dark:bg-gray-900 dark:text-gray-400 hidden text-center">
                                                    --- Petugas ---
                                                </option>
                                                @foreach ($pml as $key => $p)
                                                    <option value="{{ $p->id }}"
                                                        class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                        {{ $p->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100" class="py-10 text-center">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                        Belum ada data untuk dimonitoring
                                    </div>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            @endif
        </div>
    </div>
    @if (Auth::user() && intVal(Auth::user()?->id_role) === 3)
        <button wire:click.prevent='updateProgres'
            class=" px-3 py-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex gap-x-2 items-center">
            <span>Simpan</span>
            <div wire:loading wire:target='updateProgres'
                class="h-4 w-4 animate-spin rounded-full border-2 border-solid border-white border-t-transparent">
            </div>
        </button>
    @endif
    <div x-show="openForm"
        class="space-y-6 fixed inset-0 flex items-center justify-center bg-black/50 z-50 overflow-scroll scrollbar-hide">
        @livewire('progres.modal-form', ['id' => $idPage])
    </div>
</div>
