<div class="dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div x-data="kalender(
        '{{ \Carbon\Carbon::parse($survei->tanggal_mulai)->format('Y-m') }}',
        '{{ $survei->tanggal_mulai }}',
        '{{ $survei->tanggal_selesai }}'
    )" x-init="setTimeout(() => loading = false, 500);
    generateCalendar()" class="p-6 h-[90vh]">

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Left Box -->
            <div class="md:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border dark:border-gray-700">
                <div class="flex items-center justify-between">
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
                    <div class="flex flex-col items-center">
                        <div class="relative w-20 h-20">
                            <svg class="w-full h-full transform -rotate-90">
                                <circle cx="40" cy="40" r="35" stroke="#e5e7eb" stroke-width="10"
                                    fill="none" class="dark:stroke-gray-700" />
                                <circle cx="40" cy="40" r="35" stroke="#f97316" stroke-width="10"
                                    fill="none" stroke-dasharray="219.9" stroke-dashoffset="24"
                                    stroke-linecap="round" />
                            </svg>
                            <span
                                class="absolute inset-0 flex items-center justify-center font-bold text-xl text-gray-700 dark:text-gray-100">
                                89%
                            </span>
                        </div>
                        <p class="mt-1 text-sm font-semibold text-gray-600 dark:text-gray-300">TERCACAH</p>
                    </div>
                </div>

                <!-- Informasi Umum -->
                <div class="mt-6 grid grid-cols-3 gap-4 text-center border-t dark:border-gray-700 pt-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Blok Sensus</p>
                        <p class="font-semibold text-gray-800 dark:text-gray-100">89 Blok Sensus</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Ruta Hasil Listing</p>
                        <p class="font-semibold text-gray-800 dark:text-gray-100">890 Rumah Tangga</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total KBLI Tercatat</p>
                        <p class="font-semibold text-gray-800 dark:text-gray-100">120 KBLI</p>
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

        <!-- Progres Lapangan -->
        <div class="mt-8 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border dark:border-gray-700">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">PROGRES LAPANGAN</h3>
            <div class="space-y-4">
                @foreach ($resumePetugas as $petugas)
                    <div>
                        <div class="flex justify-between text-sm font-medium text-gray-800 dark:text-gray-100">
                            <span>{{ $petugas->joinPcl->nama }}
                                <span class="text-gray-500 dark:text-gray-400"> Singkawang Timur</span>
                            </span>
                            <span>{{ $petugas->selesai }}/{{ $petugas->total_target }}</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-1 flex overflow-hidden">
                            <div class="bg-gray-400 dark:bg-gray-500 h-2"
                                style="width: {{ ($petugas->belum_mulai / $petugas->total_target) * 100 }}%"></div>
                            <div class="bg-orange-500 h-2"
                                style="width: {{ ($petugas->on_progres / $petugas->total_target) * 100 }}%"></div>
                            <div class="bg-green-500 h-2"
                                style="width: {{ ($petugas->selesai / $petugas->total_target) * 100 }}%"></div>
                        </div>

                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                            <span>Belum Mulai: {{ $petugas->belum_mulai }}</span>
                            <span>On Progres: {{ $petugas->on_progres }}</span>
                            <span>Selesai: {{ $petugas->selesai }}</span>
                        </div>
                    </div>
                @endforeach
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
        @endonce
    </div>
</div>
