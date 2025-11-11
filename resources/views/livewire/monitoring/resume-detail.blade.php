<div class="dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div x-data="kalender(
        '{{ \Carbon\Carbon::parse($survei->tanggal_mulai)->format('Y-m') }}',
        '{{ $survei->tanggal_mulai }}',
        '{{ $survei->tanggal_selesai }}'
    )" x-init="setTimeout(() => loading = false, 500);
    generateCalendar();
    fetch('/dashboard/dataByStatus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
            },
            body: JSON.stringify({
                tahun: '{{ $tahun }}',
                id: '{{ $id }}',
                waktu: '{{ $waktu }}'
            })
        })
        .then(response => response.json())
        .then(response => {
            donutChart('#chart', {
                belum_mulai: response[0].belum_mulai,
                on_progres: response[0].on_progres,
                selesai: response[0].selesai
            });
    
        });" class="p-6">
        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Left Box -->
            <div class="md:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border dark:border-gray-700">
                @if (Auth::user())
                    <a href="/detail-monitoring/{{ $idKegiatan->id }}" wire:navigate
                        class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-success-500 shadow-theme-xs hover:bg-success-600">Update
                        kegiatan</a>
                @endif
                <div class="flex items-center justify-between md:flex-row flex-col">
                    <div class="flex items-center gap-4">
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl">
                            <img src="https://cdn-icons-png.flaticon.com/512/906/906175.png" alt="Survey"
                                class="h-16 w-16">
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                {{ $survei->kegiatan }}
                            </h2>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Capaian kegiatan lapangan hingga saat
                                ini</p>
                        </div>
                    </div>

                    <!-- Progress Circle -->
                    <div id="chart" class="h-full"></div>
                </div>

                <!-- Informasi Umum -->
                <div class="mt-6 grid grid-cols-3 gap-4 text-center border-t dark:border-gray-700 pt-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Sampel</p>
                        <p class="font-semibold text-gray-800 dark:text-gray-100">{{ $survei->target }} Sampel</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Petugas Lapangan</p>
                        <p class="font-semibold text-gray-800 dark:text-gray-100">{{ $rekapPetugas->pcl }} PCL</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Pengawas Lapangan</p>
                        <p class="font-semibold text-gray-800 dark:text-gray-100">{{ $rekapPetugas->pml }} PML</p>
                    </div>
                </div>
            </div>

            <!-- Kalender -->
            <div class="bg-black dark:bg-gray-800 text-white rounded-2xl p-6 shadow-sm border dark:border-gray-700">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Jadwal Kegiatan</h3>
                    <div class="text-sm text-gray-300 dark:text-gray-400" x-text="monthName + ' ' + year"></div>
                </div>

                <div class="grid grid-cols-7 gap-2 text-center text-sm">
                    <template x-for="day in days">
                        <div x-text="day" class="font-semibold"></div>
                    </template>

                    <template x-for="blank in blanks">
                        <div class="opacity-30">&nbsp;</div>
                    </template>

                    <template x-for="date in dates" :key="date">
                        <div x-text="date" :class="getDateClass(date)"
                            class="cursor-default py-1 relative rounded-full hover:bg-orange-600 transition-colors duration-200">
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <div x-data="{
            open: 3,
            belum_mulai: (@js($listSampel[0] ?? ['Tidak ada sampel yang belum dimulai'])).map(item => item.split(';').join(' - ')),
            on_progres: (@js($listSampel[1] ?? ['Tidak ada sampel yang on progres'])).map(item => item.split(';').join(' - ')),
            selesai: (@js($listSampel[2] ?? null) ?? ['Tidak ada sampel yang sudah selesai']).map(item => item.split(';').join(' - '))
        }" class="space-y-4 my-4">
            <!-- Accordion: Belum Mulai -->
            <div class="border dark:border-gray-700 rounded-xl overflow-hidden">
                <button @click="open === 1 ? open = null : open = 1"
                    class="w-full flex justify-between items-center px-4 py-3 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 font-semibold">
                    <div class="flex gap-x-2 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path
                                d="M5.127 3.502 5.25 3.5h9.5c.041 0 .082 0 .123.002A2.251 2.251 0 0 0 12.75 2h-5.5a2.25 2.25 0 0 0-2.123 1.502ZM1 10.25A2.25 2.25 0 0 1 3.25 8h13.5A2.25 2.25 0 0 1 19 10.25v5.5A2.25 2.25 0 0 1 16.75 18H3.25A2.25 2.25 0 0 1 1 15.75v-5.5ZM3.25 6.5c-.04 0-.082 0-.123.002A2.25 2.25 0 0 1 5.25 5h9.5c.98 0 1.814.627 2.123 1.502a3.819 3.819 0 0 0-.123-.002H3.25Z" />
                        </svg>
                        <span>Belum Mulai</span>
                    </div>
                    <svg x-show="open !== 1" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <svg x-show="open === 1" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                </button>
                <div x-show="open === 1" x-collapse class="bg-white dark:bg-gray-900 px-4 py-3">
                    <ul class="space-y-2 text-gray-700 dark:text-gray-300 text-sm">
                        <template x-for="(item, index) in belum_mulai" :key="index">
                            <li class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <span x-text="item"></span>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <!-- Accordion: On Progres -->
            <div class="border dark:border-gray-700 rounded-xl overflow-hidden">
                <button @click="open === 2 ? open = null : open = 2"
                    class="w-full flex justify-between items-center px-4 py-3 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 font-semibold">
                    <div class="flex gap-x-2 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd"
                                d="M8.34 1.804A1 1 0 0 1 9.32 1h1.36a1 1 0 0 1 .98.804l.295 1.473c.497.144.971.342 1.416.587l1.25-.834a1 1 0 0 1 1.262.125l.962.962a1 1 0 0 1 .125 1.262l-.834 1.25c.245.445.443.919.587 1.416l1.473.294a1 1 0 0 1 .804.98v1.361a1 1 0 0 1-.804.98l-1.473.295a6.95 6.95 0 0 1-.587 1.416l.834 1.25a1 1 0 0 1-.125 1.262l-.962.962a1 1 0 0 1-1.262.125l-1.25-.834a6.953 6.953 0 0 1-1.416.587l-.294 1.473a1 1 0 0 1-.98.804H9.32a1 1 0 0 1-.98-.804l-.295-1.473a6.957 6.957 0 0 1-1.416-.587l-1.25.834a1 1 0 0 1-1.262-.125l-.962-.962a1 1 0 0 1-.125-1.262l.834-1.25a6.957 6.957 0 0 1-.587-1.416l-1.473-.294A1 1 0 0 1 1 10.68V9.32a1 1 0 0 1 .804-.98l1.473-.295c.144-.497.342-.971.587-1.416l-.834-1.25a1 1 0 0 1 .125-1.262l.962-.962A1 1 0 0 1 5.38 3.03l1.25.834a6.957 6.957 0 0 1 1.416-.587l.294-1.473ZM13 10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>On Progres</span>
                    </div>
                    <svg x-show="open !== 2" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <svg x-show="open === 2" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                </button>
                <div x-show="open === 2" x-collapse class="bg-white dark:bg-gray-900 px-4 py-3">
                    <ul class="space-y-2 text-gray-700 dark:text-gray-300 text-sm">
                        <template x-for="(item, index) in on_progres" :key="index">
                            <li class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <span x-text="item"></span>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <!-- Accordion: Selesai -->
            <div class="border dark:border-gray-700 rounded-xl overflow-hidden">
                <button @click="open === 3 ? open = null : open = 3"
                    class="w-full flex justify-between items-center px-4 py-3 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 font-semibold">
                    <div class="flex gap-x-2 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="size-5">
                            <path fill-rule="evenodd"
                                d="M16.403 12.652a3 3 0 0 0 0-5.304 3 3 0 0 0-3.75-3.751 3 3 0 0 0-5.305 0 3 3 0 0 0-3.751 3.75 3 3 0 0 0 0 5.305 3 3 0 0 0 3.75 3.751 3 3 0 0 0 5.305 0 3 3 0 0 0 3.751-3.75Zm-2.546-4.46a.75.75 0 0 0-1.214-.883l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Selesai</span>
                    </div>
                    <svg x-show="open !== 3" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <svg x-show="open === 3" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                </button>
                <div x-show="open === 3" x-collapse class="bg-white dark:bg-gray-900 px-4 py-3">
                    <ul class="space-y-2 text-gray-700 dark:text-gray-100 text-sm">
                        <template x-for="(item, index) in selesai" :key="index">
                            <li class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <span x-text="item"></span>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>


        <!-- Progres Lapangan -->
        <div class="mt-8 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border dark:border-gray-700">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">PROGRES LAPANGAN</h3>
            <div class="space-y-4">
                @if (!$resumePetugas[0]->pcl)
                    <span>Petugas Belum di Assign</span>
                @else
                    @foreach ($resumePetugas as $petugas)
                        <div
                            class="flex gap-x-2 md:gap-x-4 items-center bg-slate-400/10 rounded-lg p-4 dark:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-6">
                                <path fill-rule="evenodd"
                                    d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="flex flex-col justify-between text-gray-800 dark:text-gray-100 min-w-fit ">
                                <span class="text-sm font-semibold">{{ $petugas->joinPcl?->nama }}</span>
                                @if ($petugas->joinPcl)
                                    <span class="text-xs hidden md:block">Petugas belum di assign</span>
                                @else
                                    <span
                                        class="text-xs hidden md:block">{{ $petugas->joinPcl?->status === 1 ? 'Mitra Lapangan' : 'Pegawai Organik' }}</span>
                                @endif
                            </div>
                            <div class="w-full px-4">
                                <div
                                    class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 mt-1 flex overflow-hidden">
                                    <div class="bg-gray-400 dark:bg-gray-500 h-4 rounded-md"
                                        style="width: {{ ($petugas->belum_mulai / $petugas->total_target) * 100 }}%">
                                    </div>
                                    <div class="bg-orange-500 h-4 rounded-md"
                                        style="width: {{ ($petugas->on_progres / $petugas->total_target) * 100 }}%">
                                    </div>
                                    <div class="bg-green-500 h-4 rounded-md"
                                        style="width: {{ ($petugas->selesai / $petugas->total_target) * 100 }}%">
                                    </div>
                                </div>

                                <div
                                    class="md:flex hidden justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <span>Belum Mulai: {{ $petugas->belum_mulai }}</span>
                                    <span>On Progres: {{ $petugas->on_progres }}</span>
                                    <span>Selesai: {{ $petugas->selesai }}</span>
                                </div>
                            </div>
                            <span
                                class="text-lg font-semibold text-slate-700 dark:text-gray-100">{{ $petugas->selesai }}/{{ $petugas->total_target }}</span>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>
    @once
        <script>
            function kalender(startMonth, tanggalMulai, tanggalSelesai) {
                return {
                    days: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
                    monthName: '',
                    year: '',
                    month: '',
                    blanks: [],
                    dates: [],
                    today: new Date().getDate(),
                    currentMonth: new Date().getMonth(),
                    currentYear: new Date().getFullYear(),

                    startDate: (() => {
                        const [y, m, d] = tanggalMulai.split('-').map(Number);
                        return new Date(y, m - 1, d);
                    })(),
                    endDate: (() => {
                        const [y, m, d] = tanggalSelesai.split('-').map(Number);
                        return new Date(y, m - 1, d);
                    })(),

                    generateCalendar() {
                        const [y, m] = startMonth.split('-').map(Number);
                        const date = new Date(y, m - 1, 1);
                        this.month = m - 1;
                        this.year = y;

                        const monthNames = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                        this.monthName = monthNames[this.month];

                        const firstDay = date.getDay();
                        const lastDate = new Date(y, m, 0).getDate();

                        this.blanks = Array(firstDay).fill(0);
                        this.dates = Array.from({
                            length: lastDate
                        }, (_, i) => i + 1);
                    },

                    getDateClass(date) {
                        const thisDate = new Date(this.year, this.month, date);
                        if (thisDate >= this.startDate && thisDate <= this.endDate) {
                            return 'bg-orange-500 text-white';
                        }
                        return 'text-gray-300 dark:text-gray-500';
                    }
                };
            }
        </script>
        <script src="/js/donutChart-progres.js"></script>
    @endonce
</div>
