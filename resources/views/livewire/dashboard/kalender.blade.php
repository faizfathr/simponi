<div x-init="initCalendar();
setTimeout(() => loading = false, 500)" x-data="{ showModal: false, event: {} }" id="xDataModal">
    <div id='calendar' class="bg-white dark:bg-gray-800 dark:text-slate-100 p-4 rounded-md"></div>
    <!-- Modal -->
    <div x-show="showModal" x-transition
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-md" @click.outside="showModal=false">
            <h2 class="text-xl font-semibold mb-2" x-text="event.title"></h2>
            <p><strong>Jadwal:</strong> <span x-text="event.jadwal"></span></p>
            <p><strong>Kategori:</strong> <span x-text="event.calendar"></span></p>
            <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded" @click="showModal = false">Tutup</button>
        </div>
    </div>

    @once
        <script>
            function initCalendar() {
                const newDate = new Date();
                const getDynamicMonth = () => {
                    const month = newDate.getMonth() + 1;
                    return month < 10 ? `0${month}` : `${month}`;
                };

                getColorById = (id) => {
                    const colors = [
                        '#A5D8FF', // soft blue
                        '#B2F2BB', // soft green
                        '#FFF3BF', // soft yellow
                        '#C5F6FA', // soft teal
                        '#D0BFFF' // soft purple
                    ];
                    return colors[id];
                }

                getDateDiffInDays = (start, end) => {
                    const startDate = new Date(start);
                    const endDate = new Date(end);
                    const diffTime = Math.abs(endDate - startDate);
                    return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                }
                fetch('/dashboard/listJadwal', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                    })
                    .then(responses => responses.json())
                    .then(responses => {
                        calendarEventsList = responses.map((response) => {
                            const color = getColorById(response.subSektor - 1);
                            const dateDiff = getDateDiffInDays(response.tanggal_mulai, response.tanggal_selesai);
                            if (dateDiff > 30) {
                                return [{
                                        id: `${response.id}-start`,
                                        title: response.alias + ' (Mulai)',
                                        start: response.tanggal_mulai,
                                        backgroundColor: color,
                                        borderColor: color,
                                        textColor: '#1f2937',
                                    },
                                    {
                                        id: `${response.id}-end`,
                                        title: response.alias + ' (Selesai)',
                                        start: response.tanggal_selesai,
                                        backgroundColor: color,
                                        borderColor: color,
                                        textColor: '#1f2937',
                                    }
                                ];
                            } else {
                                return [{
                                    id: `${response.id}`,
                                    title: response.alias,
                                    start: response.tanggal_mulai,
                                    end: response.tanggal_selesai,
                                    backgroundColor: color,
                                    borderColor: color,
                                    textColor: '#1f2937',
                                }];
                            }
                        }).flat(); // ratakan array dalam array
                        ;
                        const calendarEl = document.getElementById('calendar');
                        const calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            events: calendarEventsList,
                            eventClick: function(info) {
                                const props = info.event.extendedProps;
                                // Temukan elemen Alpine terluar
                                const alpineScope = document.querySelector('#xDataModal');
                                xData = Alpine.$data(alpineScope)
                                if (!xData.showModal) {
                                    xData.event = {
                                        title: info.event.title,
                                        jadwal: info.event.start.toLocaleString('id-ID', {
                                            year: 'numeric',
                                            month: 'long',
                                            day: 'numeric'
                                        }),
                                    };
                                    xData.showModal = true;
                                }
                            }
                        });
                        calendar.render();
                    });

            }
        </script>
    @endonce
</div>
