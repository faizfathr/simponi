<div x-data="{
    openForm: @entangle('openForm'),
    idTabel: @entangle('id_tabel'),
    showNotif: @entangle('showNotif'),
    openDelete: false,
    showList: false,
    loadingIdList: null,
    monitorings: @js($monitorings),
    events: @js($events),
    listKegiatan: [],
    checkedColumns: [],
    checkedAll: false,
    tandai_semua: @entangle('tandai_semua'),
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
    getListKegiatan() {
        fetch('/dashboard/listMonitoringById', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({ id: this.idTabel })
            })
            .then(response => response.json())
            .then(data => {
                this.listKegiatan = data;
                this.showList = true;
            })
            .catch(error => console.error('Fetch error:', error));
    },
    async copy(idTarget, tahunTarget, waktuTarget, tahun, waktu) {
        this.loadingIdList = idTarget + '-' + tahunTarget + '-' + waktuTarget;
        await @this.copyMonitoring(idTarget, tahunTarget, waktuTarget, tahun, waktu);
        this.showList = false;
        this.loadingIdList = null;
    },
    pushDelete(id) {
        if (!this.checkedColumns.includes(id)) {
            this.checkedColumns.push(id);
        }
    },
    popDelete(id) {
        const index = this.checkedColumns.indexOf(id);
        if (index !== -1) {
            this.checkedColumns.splice(index, 1);
        }
    },
    async deleteSelected() {
        if (this.checkedColumns.length === 0) {
            return;
        }
        this.loadingIdList = 'delete';
        await @this.deleteMonitorings(this.checkedColumns);
        this.checkedColumns = [];
        this.loadingIdList = null;
        this.openDelete = false;
    },
}" x-init="setTimeout(() => loading = false, 500);
$watch('checkedAll', value => value ? monitorings.forEach(item => pushDelete(item.id)) : monitorings.forEach(item => popDelete(item.id)))">
    <style>
        .btn-dashboard {
            @apply inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg shadow-theme-xs hover:bg-brand-600 transition select-none;
        }

        .loader-white {
            @apply h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent;
        }

        .loader-green {
            @apply h-4 w-4 animate-spin rounded-full border-2 border-success-500 border-t-transparent;
        }
    </style>
    <x-dashboard.notification showNotif="showNotif" message="{{ $message }}" status="{{ $status }}" />

    <div class="flex-1 mb-4">
        <h1 class="text-xl font-semibold text-gray-800 dark:text-white">
            {{ $events->kegiatan }} ({{ $tahun }}) - {{ $waktu }}
        </h1>
        <p class="text-xs text-gray-500 dark:text-gray-400">
            Jadwal: <span x-text="formatJadwal(events.tanggal_mulai, events.tanggal_selesai)"></span>
        </p>
    </div>
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
                class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                <span class="mr-1 text-xs hidden md:block">Template</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
            </a>
            <a href="/dashboard/downloadDirektori"
                class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
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
                        class="relative z-0 text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
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
    <div class=" rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full" x-data="{
            columns: {
                no: true,
                proses: true,
                status: true,
                pcl: true,
                pml: true,
                @foreach ($sampel_header as $key => $item) sampel{{ $key }}: true, @endforeach
                @foreach ($prosess_header as $key => $item) proses{{ $key }}: true, @endforeach
            }
        }">
            @if ($idPage)
                <div class="sticky flex items-center justify-between top-0 z-30 bg-white dark:bg-gray-900 px-2"
                    x-data="{ openColumnFilter: false }">
                    <div class="text-sm text-gray-700 dark:text-gray-300 relative w-fit p-2">
                        <!-- Toggle Button -->
                        <div class="flex gap-x-2">
                            <button class="text-white p-2 rounded-lg flex items-center gap-x-2 bg-red-700"
                                @click="openDelete = true" :disabled="checkedColumns.length === 0"
                                :class="checkedColumns.length > 0 ? 'brigthness-100' : 'brightness-75 cursor-not-allowed'">
                                <x-icons.trash />
                                <span class="hidden md:block" x-text="'Hapus (' + checkedColumns.length + ')'"></span>
                            </button>
                            <button @click="openColumnFilter = !openColumnFilter"
                                class="flex items-center gap-2 cursor-pointer font-semibold text-white transition-all bg-slate-500 dark:bg-gray-800 rounded-lg p-2">
                                <!-- SVG Palu & Tang -->
                                <x-icons.maintenance />
                                <span class="text-xs">Pilih Kolom</span>
                            </button>
                            <button @click="tandai_semua = !tandai_semua"
                                :class="tandai_semua ? 'bg-green-600' : 'bg-slate-500 dark:bg-gray-800'"
                                class="flex items-center gap-2 cursor-pointer font-semibold text-white transition-all rounded-lg p-2">
                                <!-- SVG Palu & Tang -->
                                <template x-if="tandai_semua">
                                    <x-icons.pointer-out />
                                </template>
                                <template x-if="!tandai_semua">
                                    <x-icons.pointer />
                                </template>
                                <span class="text-xs">Tandai</span>
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
                    <button @click="getListKegiatan()"
                        class="flex items-center gap-2 p-2 text-sm font-medium text-green-500  hover:text-white transition rounded-lg bg-transparent border-2 border-green-500 hover:bg-green-500 w-fit">
                        <x-icons.copy />
                        <span class="text-xs">Salin sampel</span>

                    </button>
                </div>
                <div class="overflow-x-auto custom-scrollbar h-[80vh]">
                    <table class="min-w-full  custom-scrollbar overflow-y-hidden z-0" x-data="{ petugas: [...@js($pml), ...@js($pcl)], monitorings: @js($monitorings) }">
                        <!-- table header start -->
                        <thead class="sticky top-0  z-10 bg-gray-200 dark:bg-gray-800">
                            <!-- Baris Judul Kolom -->
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th x-show="columns.no"
                                    class="px-5 py-3 sm:px-6 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                    <span>No</span>
                                </th>

                                @foreach ($sampel_header as $itemSampel)
                                    <th x-show="columns.sampel{{ $loop->index }}" x-data="{
                                        width: 180
                                    }"
                                        :style="'width:' + width + 'px; min-width:' + width + 'px'"
                                        class="relative px-5 py-3 sm:px-6 text-center text-xs font-medium text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center justify-center">
                                            {{ $itemSampel }}
                                        </div>
                                        <div @mousedown="
                                            const startX = $event.clientX;
                                            const startWidth = width;

                                            const move = (e) => {
                                                width = Math.max(80, startWidth + (e.clientX - startX));
                                            }

                                            const up = () => {
                                                window.removeEventListener('mousemove', move);
                                                window.removeEventListener('mouseup', up);
                                            }

                                            window.addEventListener('mousemove', move);
                                            window.addEventListener('mouseup', up);
                                        "
                                            class="absolute top-0 right-0 h-full w-4 cursor-pointer select-none flex items-center justify-center border">
                                            <x-icons.resize />
                                        </div>
                                    </th>
                                @endforeach

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

                            <!-- Filter Row -->
                            <tr class="border-b border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-900">
                                <th class="px-5 py-2 sm:px-6" x-show="columns.no">
                                    <input type="checkbox" @change="checkedAll = !checkedAll"
                                        class="accent-brand-500 rounded focus:ring-0" />
                                </th>

                                @foreach ($sampel_header as $item)
                                    <th x-show="columns.sampel{{ $loop->index }}" class="px-5 py-2 sm:px-6">
                                        <input type="text"
                                            wire:model.live.debounce.250ms="filter.sampel.{{ $loop->index }}"
                                            class="w-full text-xs rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-white px-2 py-1 focus:ring-brand-500 focus:border-brand-500" />
                                    </th>
                                @endforeach

                                @foreach ($prosess_header as $item)
                                    <th x-show="columns.proses{{ $loop->index }}" class="px-5 py-2 sm:px-6 w-full">
                                    </th>
                                @endforeach

                                <th x-show="columns.status" class="px-5 py-2 sm:px-6 min-w-fit">
                                    <select wire:model.live.debounce.250ms="filter.status"
                                        class="w-fit text-xs rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-white px-2 py-1 focus:ring-brand-500 focus:border-brand-500">
                                        <option value="">Status</option>
                                        <option value="00">Belum</option>
                                        <option value="1">Progres</option>
                                        <option value="2">Selesai</option>
                                    </select>
                                </th>

                                <th x-show="columns.pcl" class="px-5 py-2 sm:px-6 min-w-fit">
                                    <div x-data="{
                                        search: '',
                                        showList: false,
                                        displayPetugas: '',
                                        pilih(p) {
                                            this.displayPetugas = p.nama;
                                            this.search = '';
                                            this.showList = false;
                                            $wire.set('filter.pcl', p.id, true);
                                        },
                                        get filteredPcl() {
                                            return petugas.filter(p => p.nama.toLowerCase().includes(this.search.toLowerCase()));
                                        }
                                    }" @click.away="showList = false" class="relative">

                                        <!-- Input (klik = show list) -->
                                        <input :value="displayPetugas !== '' ? displayPetugas : search"
                                            @focus="showList = true; search = ''"
                                            @input="
                                                search = $event.target.value;
                                                if (search === '') {
                                                    displayPetugas = '';
                                                    $wire.set('filter.pcl', '', true);
                                                }
                                            "
                                            placeholder="Filter petugas..."
                                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 max-w-max appearance-none rounded-lg border border-gray-300 bg-white px-2 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">

                                        <input type="hidden" wire:model.live='filter.pcl' />

                                        <!-- Dropdown -->
                                        <div x-show="showList" x-transition
                                            class="absolute z-50 mt-1 max-h-48 w-full overflow-y-auto rounded-lg border border-gray-200 bg-white shadow dark:border-gray-700 dark:bg-gray-900">

                                            <template x-for="p in filteredPcl" :key="p.id">
                                                <div @click="pilih(p)"
                                                    class="cursor-pointer px-3 py-2 text-sm hover:bg-blue-100 dark:hover:bg-blue-800 dark:text-white">
                                                    <span x-text="p.nama"></span>
                                                </div>
                                            </template>

                                            <div x-show="filteredPcl.length === 0"
                                                class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">
                                                Tidak ditemukan.
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th x-show="columns.pcl" class="px-5 py-2 sm:px-6">
                                    <div x-data="{
                                        search: '',
                                        showList: false,
                                        displayPetugas: '',
                                        pilih(p) {
                                            this.displayPetugas = p.nama;
                                            this.search = '';
                                            this.showList = false;
                                            $wire.set('filter.pml', p.id, true);
                                        },
                                        get filteredPcl() {
                                            return petugas.filter(p => p.nama.toLowerCase().includes(this.search.toLowerCase()));
                                        }
                                    }" @click.away="showList = false" class="relative">

                                        <!-- Input (klik = show list) -->
                                        <input :value="displayPetugas !== '' ? displayPetugas : search"
                                            @focus="showList = true; search = ''"
                                            @input="
                                                search = $event.target.value;
                                                if (search === '') {
                                                    displayPetugas = '';
                                                    $wire.set('filter.pml', '', true);
                                                }
                                            "
                                            placeholder="Filter petugas..."
                                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 max-w-max appearance-none rounded-lg border border-gray-300 bg-white px-2 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">

                                        <input type="hidden" wire:model.live='filter.pml' />

                                        <!-- Dropdown -->
                                        <div x-show="showList" x-transition
                                            class="absolute z-50 mt-1 max-h-48 w-full overflow-y-auto rounded-lg border border-gray-200 bg-white shadow dark:border-gray-700 dark:bg-gray-900">

                                            <template x-for="p in filteredPcl" :key="p.id">
                                                <div @click="pilih(p)"
                                                    class="cursor-pointer px-3 py-2 text-sm hover:bg-blue-100 dark:hover:bg-blue-800 dark:text-white">
                                                    <span x-text="p.nama"></span>
                                                </div>
                                            </template>

                                            <div x-show="filteredPcl.length === 0"
                                                class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">
                                                Tidak ditemukan.
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <!-- table header end -->

                        <!-- table body start -->
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @if ($monitorings)
                                @foreach ($monitorings as $row => $monitoring)
                                    <tr
                                        class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 ">
                                        <td x-show="columns.no" class="px-6 py-0.5">
                                            <div class="flex items-center">
                                                <div class="flex items-center gap-3">
                                                    <input type="checkbox" :checked="checkedAll"
                                                        @change="
                                                        $event.target.checked
                                                            ? pushDelete({{ $monitoring['id'] }})
                                                            : popDelete({{ $monitoring['id'] }})
                                                ">
                                                </div>
                                            </div>
                                        </td>
                                        @foreach ($allItem[$row]['sampel_body'] as $key => $itemSampelBody)
                                            <td x-show="columns.sampel{{ $key }}"
                                                class="px-0.5 py-0.5 whitespace-nowrap">
                                                <input
                                                    wire:model="allItem.{{ $row }}.sampel_body.{{ $key }}"
                                                    rows="1" x-data
                                                    class="w-full min-w-sm overflow-hidden
                                                        outline-none whitespace-pre-wrap break-words dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:focus:border-brand-500 rounded-lg border border-gray-300 bg-transparent px-2 py-1 text-smtext-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                            </td>
                                        @endforeach
                                        @foreach ($allItem[$row]['prosess'] as $key => $itemProsesBody)
                                            <td x-show="columns.proses{{ $key }}" class="px-0.5 py-0.5">
                                                <div x-data="{ checkboxToggle{{ $monitoring['id'] }}{{ $key }}: {{ $itemProsesBody === '1' ? 'true' : 'false' }} }"> <label
                                                        for="checkboxLabel{{ $monitoring['id'] }}{{ $key }}"
                                                        class="flex justify-center cursor-pointer select-none ">
                                                        <div class="relative"> <input
                                                                wire:model='allItem.{{ $row }}.prosess.{{ $key }}'
                                                                type="checkbox"
                                                                id="checkboxLabel{{ $monitoring['id'] }}{{ $key }}"
                                                                class="sr-only"
                                                                :checked='checkboxToggle{{ $monitoring['id'] }}{{ $key }}
                                                                    ||
                                                                    tandai_semua'
                                                                @change="checkboxToggle{{ $monitoring['id'] }}{{ $key }} = !checkboxToggle{{ $monitoring['id'] }}{{ $key }}" />
                                                            <div :class="checkboxToggle{{ $monitoring['id'] }}{{ $key }}
                                                                ||
                                                                tandai_semua ?
                                                                'border-brand-500 bg-brand-500' :
                                                                'bg-transparent border-gray-300 dark:border-gray-700'"
                                                                class="hover:border-brand-500 dark:hover:border-brand-500 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]">
                                                                <span
                                                                    :class="checkboxToggle{{ $monitoring['id'] }}{{ $key }}
                                                                        ||
                                                                        tandai_semua ?
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
                                        <td x-show="columns.status" class="px-0.5 py-0.5">
                                            <div class="flex items-center justify-center">
                                                <p
                                                    class="rounded-full px-2 py-0.5 text-xs font-medium {{ (int) $allItem[$row]['status'] === 0 ? 'bg-gray-50 text-gray-600' : ((int) $allItem[$row]['status'] === 1 ? 'bg-warning-50 text-orange-600' : 'bg-success-50 text-success-600') }} dark:bg-success-500/15 dark:text-success-500">
                                                    {{ (int) $allItem[$row]['status'] === 0 ? 'Belum Terlaksana' : ((int) $allItem[$row]['status'] === 1 ? 'On Progres' : 'Selesai') }}
                                                </p>
                                            </div>
                                        </td>
                                        <td x-show="columns.pcl" class="px-0.5"
                                            wire:key="pcl-{{ $monitoring['id'] }}">

                                            <div x-data="{
                                                search: '',
                                                showList: false,
                                                displayPetugas: '',
                                            
                                                pilih(p) {
                                                    this.displayPetugas = p.nama;
                                                    this.search = '';
                                                    this.showList = false;
                                            
                                                    $wire.allItem[{{ $row }}].pcl = p.id;
                                                },
                                            
                                                get filteredPcl() {
                                                    return petugas.filter(p =>
                                                        p.nama.toLowerCase().includes(this.search.toLowerCase())
                                                    );
                                                },
                                            
                                                init() {
                                                    const initialId = @js($this->allItem[$row]['pcl'] ?? null);
                                            
                                                    if (initialId) {
                                                        const found = petugas.find(p => p.id == initialId);
                                                        if (found) {
                                                            this.displayPetugas = found.nama;
                                                        }
                                                    }
                                                },
                                            }" x-init="init()"
                                                @click.away="showList = false" class="relative">

                                                <input
                                                    :value="displayPetugas !== '' ? displayPetugas : search"
                                                    @focus="showList = true; search = ''"
                                                    @input="search = $event.target.value"
                                                    placeholder="Cari petugas..."
                                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 max-w-max appearance-none rounded-lg border border-gray-300 bg-white px-2 pr-11 text-sm text-gray-800 placeholder:text-gray-400  focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                                <div x-show="showList" x-transition
                                                    class="absolute z-50 mt-1 max-h-48 w-full overflow-y-auto rounded-lg border border-gray-200 bg-white shadow dark:border-gray-700  dark:bg-gray-900">
                                                    <template x-for="p in filteredPcl" :key="p.id">
                                                        <div @click="pilih(p)"
                                                            class="cursor-pointer px-3 py-0.5 text-sm hover:bg-blue-100 dark:hover:bg-blue-800 dark:text-white">
                                                            <span x-text="p.nama"></span>
                                                        </div>
                                                    </template>

                                                    <div x-show="filteredPcl.length === 0"
                                                        class="px-3 py-0.5 text-sm text-gray-500 dark:text-gray-400">
                                                        Tidak ditemukan.
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td x-show="columns.pml" class="px-0.5"
                                            wire:key="pml-{{ $monitoring['id'] }}">
                                            <div x-data="{
                                                search: '',
                                                showList: false,
                                                displayPetugas: '',
                                                pilih(p) {
                                                    this.displayPetugas = p.nama;
                                                    this.search = '';
                                                    this.showList = false;
                                                    $wire.allItem[{{ $row }}].pml = p.id;
                                                },
                                                get filteredPml() {
                                                    return petugas.filter(p => p.nama.toLowerCase().includes(this.search.toLowerCase()));
                                                },
                                                init() {
                                                    const initialId = @js($this->allItem[$row]['pml'] ?? null);
                                            
                                                    if (initialId) {
                                                        const found = petugas.find(p => p.id == initialId);
                                                        if (found) {
                                                            this.displayPetugas = found.nama;
                                                        }
                                                    }
                                                },
                                            }" x-init="init();"
                                                @click.away="showList = false" class="relative">

                                                <!-- Input (klik = show list) -->
                                                <input
                                                    :value="displayPetugas !== '' ? displayPetugas : search"
                                                    @focus="showList = true; search = ''"
                                                    @input="search = $event.target.value"
                                                    placeholder="Cari petugas..."
                                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 appearance-none rounded-lg border border-gray-300 bg-white px-2 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                                <!-- Dropdown -->
                                                <div x-show="showList" x-transition
                                                    class="absolute z-50 mt-1 max-h-48 min-w-fit overflow-y-auto rounded-lg 
                                                    border border-gray-200 bg-white shadow dark:border-gray-700 
                                                    dark:bg-gray-900">
                                                    <template x-for="p in filteredPml" :key="p.id">
                                                        <div @click="pilih(p)"
                                                            class="cursor-pointer px-3 py-2 text-sm 
                                                            hover:bg-blue-100 dark:hover:bg-blue-800 
                                                            dark:text-white">
                                                            <span x-text="p.nama"></span>
                                                        </div>
                                                    </template>

                                                    <div x-show="filteredPml.length === 0"
                                                        class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">
                                                        Tidak ditemukan.
                                                    </div>
                                                </div>

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
                </div>

            @endif
        </div>

    </div>
    @if (Auth::user() && intVal(Auth::user()?->id_role) === 3)
        <button wire:click.prevent='updateProgres' id="saveButton"
            class=" px-3 py-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex gap-x-2 items-center">
            <span>Simpan</span>
            <div wire:loading wire:target='updateProgres'
                class="h-4 w-4 animate-spin rounded-full border-2 border-solid border-white border-t-transparent">
            </div>
        </button>
        @once
            <script>
                document.addEventListener('keydown', function(e) {
                    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
                        e.preventDefault();
                        document.getElementById('saveButton').click();
                    }
                });
            </script>
        @endonce
    @endif
    <div x-show="showList" @click="showList = false"
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
        <div @click.stop x-show="showList" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-52" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-52"
            class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-xl w-full max-w-lg max-h-[80vh] overflow-y-auto">

            <h2 class="text-lg font-semibold text-slate-700 dark:text-white mb-3 border-b pb-2">
                Pilih Kegiatan
            </h2>

            <template x-for="(list, index) in listKegiatan" :key="index">
                <div
                    class="flex items-center justify-between p-3 rounded-lg border mb-2 bg-white dark:bg-slate-900 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700 transition cursor-pointer">
                    <!-- Teks kegiatan -->
                    <div class="flex gap-1 items-center text-sm text-slate-700 dark:text-white">
                        <div x-text="list.alias"></div>
                        <span x-text="list.tahun"></span>
                        <template x-if="list.periode === 1">
                            <span>Bulan - </span>
                        </template>
                        <template x-if="list.periode === 2">
                            <span>Triwulan - </span>
                        </template>
                        <template x-if="list.periode === 3">
                            <span>Subround - </span>
                        </template>
                        <template x-if="list.periode === 4">
                            <span>Tahun - </span>
                        </template>
                        <span x-text="list.waktu"></span>
                    </div>

                    <!-- Tombol copy -->
                    <button
                        @click="copy(list.id_kegiatan, list.tahun, list.waktu, {{ $tahun }}, {{ $waktu }})"
                        class="text-blue-600 text-xs font-semibold ml-3 flex items-center gap-1 bg-transparent border border-blue-600 rounded-lg px-2 py-1 hover:bg-blue-600 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                        </svg>
                        <span class="flex gap-x-2 items-center">
                            Copy
                            <div x-show="loadingIdList === (list.id_kegiatan + '-' + list.tahun + '-' + list.waktu)"
                                class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-blue-600 border-t-transparent">
                            </div>
                        </span>
                    </button>
                </div>
            </template>

        </div>
    </div>

    <!-- Modal Delete Confirmation -->
    <div x-show="openDelete"
        class="space-y-6 fixed inset-0 flex items-center justify-center bg-black/50 z-50 overflow-scroll scrollbar-hide">
        <x-utility.delete-confirmator show="openDelete" title="Hapus sampel"
            description="Perhatian, anda akan menghapus sampel secara <b>Permanen</b>">
            <x-slot:action>
                <button @click="deleteSelected()"
                    class="w-full px-4 py-2 text-sm font-medium text-white rounded-lg 
                           bg-red-500 hover:bg-red-600 flex items-center justify-center gap-2">
                    Hapus
                    <div x-show="loadingIdList === 'delete'"
                        class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
                    </div>
                </button>
            </x-slot:action>
        </x-utility.delete-confirmator>
    </div>


    <!-- Modal Form -->
    <div x-show="openForm"
        class="space-y-6 fixed inset-0 flex items-center justify-center bg-black/50 z-50 overflow-scroll scrollbar-hide">
        @livewire('progres.modal-form', ['id' => $idPage])
    </div>
</div>
