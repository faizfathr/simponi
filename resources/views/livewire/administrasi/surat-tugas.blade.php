<div x-data="{
    openModal: @entangle('openModal'),
    openDeleteModal: @entangle('openDeleteModal'),
    showNotif: @entangle('showNotif')
}" class="p-6 space-y-6 bg-slate-50" x-init="setTimeout(() => loading = false, 500)">
    <x-dashboard.notification showNotif="showNotif" message="{{ $pesan }}" status="{{ $statusNotif }}" />
    <!-- HEADER -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Surat Tugas</h1>

        <button @click="openModal = true" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">
            + Tambah Surat Tugas
        </button>
    </div>

    <!-- FILTER -->
    <div class="flex items-center gap-3">

        <label class="text-sm font-medium">Tahun</label>

        <select class="border rounded-lg px-3 py-2">
            <option>2026</option>
            <option>2025</option>
            <option>2024</option>
            <option>2023</option>
        </select>

    </div>


    <!-- TABEL -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-sm table table-zebra">

            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nomor Surat</th>
                    <th class="px-4 py-3 text-left">Kegiatan</th>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Jumlah Petugas</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($listSuratTugas as $key => $suratTugas)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $key + 1 }}</td>
                        <td class="px-4 py-3">{{ $suratTugas->nomor_surat }}</td>
                        <td class="px-4 py-3">{{ $suratTugas->kegiatan }}</td>
                        <td class="px-4 py-3">{{ $suratTugas->waktu_pelaksanaan }}</td>
                        <td class="px-4 py-3">{{ count(explode(',', $suratTugas->id_petugas)) }}</td>
                        <td class="px-4 py-3 text-center space-x-3">
                            <a wire:click="download({{ $suratTugas->id }})"
                                class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600 cursor-pointer">
                                <span class="mr-1 text-xs hidden md:block">Download</span>
                                <x-icons.download />
                                <x-utility.loader target='download({{ $suratTugas->id }})' />
                            </a>
                            <button wire:click='confirmDelete({{ $suratTugas->id }})'
                                class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-danger-500 shadow-theme-xs hover:bg-danger-600 cursor-pointer">
                                <span class="mr-1 text-xs hidden md:block">Hapus</span>
                                <x-icons.trash />
                                <x-utility.loader target='confirmDelete({{ $suratTugas->id }})' />
                            </button>
                        </td>
                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>


    <!-- MODAL -->
    <div x-show="openModal" x-data="{
        allPetugas: @js($petugas),
        listSuratTugas: @js($listSuratTugas->toArray()),
        selectedPetugas: @entangle('selectedPetugas'),
        selectedSuratSelipan: @entangle('selectedSuratSelipan'),
        openPetugasDropdown: false,
        searchPetugas: '',
        latestSurat: @js($noSuratTerakhir),
        tipe_surat: '',
        alfabet: @js($alfabet),
        get selectedPetugasNames() {
            return this.allPetugas
                .filter(p => this.selectedPetugas.includes(p.id))
                .map(p => p.nama)
                .join(', ')
        },
        get petugasFiltered() {
            if (this.searchPetugas === '') {
                return this.allPetugas;
            }
            return this.allPetugas.filter(petugas =>
                petugas.nama.toLowerCase().includes(this.searchPetugas.toLowerCase())
            );
        },
        zeroPaddedNoSurat(number, additional = 0) {
            if (this.tipe_surat !== '1') return String(parseInt(number) + additional).padStart(3, '0');
            console.log(number)
            return String(parseInt(number)).padStart(3, '0') + this.alfabet[additional - 1];
        },
        get noSuratAwal() {
            if(this.selectedSuratSelipan) return 'B-' + this.zeroPaddedNoSurat(this.selectedSuratSelipan.slice(2,5), 1) + '/61723/kp.650/' + new Date().getFullYear() 
            return 'B-' + this.zeroPaddedNoSurat(this.latestSurat, 1) + '/61723/kp.650/' + new Date().getFullYear()
    
        },
        get noSuratAkhir() {
            return 'B-' + this.zeroPaddedNoSurat(this.latestSurat, this.selectedPetugas.length) + '/61723/kp.650/' + new Date().getFullYear()
        },
        async simpanSurat() {
            @this.noSurat = this.noSuratAwal;
            await @this.simpanSurat();
            openModal = false;
        },
    }"
        class="space-y-6 top-0 fixed inset-0 flex items-center justify-center bg-black/50 z-50 overflow-scroll scrollbar-hide">
        <div x-show="openModal" @click.outside="openModal=false" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start ="opacity-0 -translate-y-52" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-52"
            class="w-full max-w-5xl bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b dark:border-gray-700">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-white">
                    Buat Surat Tugas
                </h2>

                <button @click="openModal=false"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-xl">
                    ✕
                </button>
            </div>

            <!-- BODY -->
            <div class="p-6 space-y-6 max-h-[80vh] overflow-y-auto">
                <!-- FORM -->
                <div class="space-y-4 grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2">
                    <div class="flex text-sm col-span-2">
                        <select x-model='tipe_surat' class="w-full border rounded-lg px-3 py-2">
                            <option value="">Pilih Nomor Surat</option>
                            <option value="0">Nomor Surat Biasa</option>
                            <option value="1">Nomor Surat Selip</option>
                        </select>
                    </div>
                    <div class="flex text-sm col-span-2" x-show="tipe_surat === '1'" x-transition>
                        <select x-model="selectedSuratSelipan" class="w-full border rounded-lg px-3 py-2">
                            <option value="">Pilih Nomor Surat Selip</option>

                            <template x-for="surat in listSuratTugas" :key="surat.id">
                                <option :value="surat.nomor_surat" x-text="surat.nomor_surat + ' - ' + surat.tujuan_tugas"></option>
                            </template>
                        </select>
                    </div>
                    <div class="flex text-sm col-span-2" x-transition
                        :class="selectedPetugas.length > 1 ? 'md:flex-row flex-col gap-4' : ''">
                        <div class="w-full" :class="selectedPetugas.length > 1 ? 'md:flex-1' : ''">
                            <label class="text-sm block mb-1">Nomor Surat Awal</label>
                            <input type="text"
                                class="w-full border rounded-lg px-3 py-2 bg-gray-100 dark:bg-gray-400 dark:text-white text-slate-600 text-sm font-semibold"
                                :value="noSuratAwal" readonly>
                        </div>
                        <div x-show="selectedPetugas.length > 1" x-transition class="flex-1">
                            <label class="text-sm block mb-1">Nomor Surat Akhir</label>
                            <input type="text"
                                class="w-full border rounded-lg px-3 py-2 bg-gray-100 dark:bg-gray-400 dark:text-white text-slate-600 text-sm font-semibold"
                                x-model="noSuratAkhir" readonly>
                        </div>
                    </div>
                    <div class="text-sm flex w-full gap-4 col-span-2">
                        <div class="w-full">
                            <label class="text-sm block mb-1">Nomor Surat Rujukan</label>
                            <input wire:model='noSuratRujukan' type="text"
                                class="w-full border rounded-lg px-3 py-2 bg-white dark:bg-gray-400 dark:text-white text-slate-600 text-sm font-semibold">
                        </div>
                        <div class="w-full">
                            <label class="text-sm block mb-1">Kepala Surat RUjukan</label>
                            <input wire:model='kepalaSuratRujukan' type="text"
                                class="w-full border rounded-lg px-3 py-2 bg-white dark:bg-gray-400 dark:text-white text-slate-600 text-sm font-semibold">
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label class="text-sm block mb-1">Perihal Rujukan</label>
                        <input wire:model='perihalRujukan' type="text"
                            class="w-full border rounded-lg px-3 py-2 bg-white dark:bg-gray-400 dark:text-white text-slate-600 text-sm font-semibold"
                            placeholder="Perihal rujukan...">
                    </div>
                    <div>
                        <label class="text-sm block mb-1">Tujuan Tugas</label>
                        <textarea wire:model='tujuanTugas' class="w-full border rounded-lg px-3 py-2 h-24" placeholder="Tujuan tugas"></textarea>
                    </div>
                    <div>
                        <label class="text-sm block mb-1">Kegiatan</label>
                        <textarea wire:model='kegiatan' class="w-full border rounded-lg px-3 py-2 h-24" placeholder="Kegiatan"></textarea>
                    </div>

                    <div>
                        <label class="text-sm block mb-1">Tanggal Surat</label>
                        <input wire:model='tanggalSurat' type="date" class="w-full border rounded-lg px-3 py-2">
                    </div>


                    <div>
                        <label class="text-sm block mb-1">Waktu pelaksanaan</label>
                        <div class="flex gap-4">
                            <input wire:model='tanggalMulai' type="date"
                                class="w-full border rounded-lg px-3 py-2">
                            <input wire:model='tanggalSelesai' type="date"
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                    </div>

                    <div>
                        <label class="text-sm block mb-1">Penandatangan</label>
                        <select wire:model='penandatangan' class="w-full border rounded-lg px-3 py-2">
                            <option value="">Pilih Penandatangan</option>
                            <option value="0">YANUAR LESTARIADI</option>
                            <option value="1">IRWAN AGUSTIAN</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm block mb-1">Tempat</label>
                        <input wire:model='tempat' type="text" class="w-full border rounded-lg px-3 py-2"
                            placeholder="Tempat pelaksanaan">
                    </div>
                    <div>
                        <label class="text-sm block mb-1">Pembebanan</label>
                        <input wire:model='pembebanan' type="text" class="w-full border rounded-lg px-3 py-2"
                            placeholder="Pembebanan anggaran">
                    </div>
                    <div>
                        <label class="text-sm block mb-1">Subtim</label>
                        <select wire:model='subtim' class="w-full border rounded-lg px-3 py-2">
                            <option value="">Pilih Tim</option>
                            <option value="0">Pertanian</option>
                            <option value="1">IPEK</option>
                        </select>
                    </div>

                    <div x-data="{ openPetugasDropdown: false }" @click.outside="openPetugasDropdown = false"
                        class="col-span-2 bg-white dark:bg-gray-800 w-full">

                        <label class="text-sm block mb-1">Petugas Lapangan</label>

                        <div class="w-full border rounded-lg px-3 py-2 flex flex-wrap gap-2 cursor-text"
                            @click="openPetugasDropdown = true">
                            <!-- Chips -->
                            <template x-for="id in selectedPetugas" :key="id">
                                <span
                                    class="bg-blue-100 text-blue-700 px-2 py-1 rounded-md text-xs flex items-center gap-1">
                                    <span x-text="allPetugas.find(p => p.id === id)?.nama"></span>

                                    <!-- tombol hapus -->
                                    <button @click.stop="selectedPetugas = selectedPetugas.filter(i => i !== id)"
                                        class="text-blue-500 hover:text-red-500">
                                        ✕
                                    </button>
                                </span>
                            </template>

                            <!-- placeholder -->
                            <span x-show="selectedPetugas.length === 0" class="text-gray-400 text-sm">
                                Pilih petugas lapangan
                            </span>
                        </div>

                        <div x-show="openPetugasDropdown" class="border rounded-lg mt-1 max-h-48 overflow-y-auto "
                            x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                            <input type="text" class="w-full border rounded-lg px-3 py-2"
                                placeholder="Cari petugas lapangan..." x-model="searchPetugas">

                            <template x-for="petugas in petugasFiltered" :key="petugas.id">
                                <div class="flex items-center gap-2 px-3 py-2 hover:bg-gray-100 cursor-pointer"
                                    @click="
                                    selectedPetugas.includes(petugas.id) 
                                    ? selectedPetugas = selectedPetugas.filter(id => id !== petugas.id) 
                                    : selectedPetugas.push(petugas.id)
                                ">
                                    <input type="checkbox" :checked="selectedPetugas.includes(petugas.id)"
                                        class="pointer-events-none">
                                    <span x-text="petugas.nama"></span>
                                </div>
                            </template>

                            <div x-show="petugasFiltered.length === 0" class="px-3 py-2 text-sm text-gray-500">
                                Petugas tidak ditemukan.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- FOOTER -->
            <div class="flex justify-end gap-3 px-6 py-4 border-t dark:border-gray-700">
                <button @click="openModal=false"
                    class="px-4 py-2 text-sm border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    Batal
                </button>

                <button @click="simpanSurat()"
                    class="px-4 py-2 text-sm bg-orange-500 text-white rounded-lg hover:bg-orange-600 flex items-center gap-2">
                    Simpan
                    <x-utility.loader target='simpanSurat' />
                </button>
            </div>

        </div>

    </div>

    <!-- Delete Confirmator -->
    <!-- OVERLAY -->
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
        x-show="openDeleteModal">

        <!-- MODAL -->
        <x-utility.delete-confirmator show="openDeleteModal" title="Hapus Surat Tugas?"
            description="Anda akan menghapus Surat Tugas <b>{{ $nomorSuratTarget }}</b>">
            <x-slot:action>

                <!-- DELETE -->
                <button wire:click='deleteSurat'
                    class="w-full px-4 py-2 text-sm font-medium text-white rounded-lg 
                           bg-red-500 hover:bg-red-600 flex items-center justify-center gap-2">
                    Hapus
                    <x-utility.loader target='deleteSurat' />
                </button>
            </x-slot:action>
        </x-utility.delete-confirmator>

    </div>
    <!-- Delete Confirmator -->

</div>
