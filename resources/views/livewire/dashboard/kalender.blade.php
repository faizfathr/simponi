<div x-init="initCalendar()" x-data="{ showModal: false, event: {} }" id="xDataModal">
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
                            return [{
                                    id: `${response.id}-start`,
                                    title: response.alias + ' (Mulai)',
                                    start: response.tanggal_mulai,
                                    extendedProps: {
                                        calendar: "Danger"
                                    }
                                },
                                {
                                    id: `${response.id}-end`,
                                    title: response.alias + ' (Selesai)',
                                    start: response.tanggal_selesai,
                                    extendedProps: {
                                        calendar: "Danger"
                                    }
                                }
                            ];
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
