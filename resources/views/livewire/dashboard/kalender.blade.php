<div x-init="initCalendar()" x-data="{ showModal: false, event: {} }" id="xDataModal">
    <div id='calendar' class="bg-white p-4 rounded-md"></div>
    <!-- Modal -->
    <div x-show="showModal" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-md" @click.outside="showModal=false">
            <h2 class="text-xl font-semibold mb-2" x-text="event.title"></h2>
            <p><strong>Mulai:</strong> <span x-text="event.start"></span></p>
            <p><strong>Selesai:</strong> <span x-text="event.end || '-'"></span></p>
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
                                title: response.kegiatan + ' (Mulai)',
                                start: response.tanggal_mulai,
                                extendedProps: {
                                    calendar: "Danger"
                                }
                            },
                            {
                                id: `${response.id}-end`,
                                title: response.kegiatan + ' (Selesai)',
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
                                    start: info.event.start.toLocaleString('id-ID', {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric'
                                    }),
                                    end: info.event.end ? info.event.end.toLocaleString() : '',
                                    calendar: props.calendar ?? '-'
                                };
                                xData.showModal = true;
                            }
                        }
                    });
                    calendar.render();
                });
            // const calendarEventsList = [{
            //         id: 1,
            //         title: "Event Conf.",
            //         start: `${newDate.getFullYear()}-${getDynamicMonth()}-01`,
            //         extendedProps: {
            //             calendar: "Danger"
            //         },
            //     },
            //     {
            //         id: 2,
            //         title: "Seminar #4",
            //         start: `${newDate.getFullYear()}-${getDynamicMonth()}-07`,
            //         end: `${newDate.getFullYear()}-${getDynamicMonth()}-10`,
            //         extendedProps: {
            //             calendar: "Success"
            //         },
            //     },
            //     {
            //         groupId: "999",
            //         id: 3,
            //         title: "Meeting #5",
            //         start: `${newDate.getFullYear()}-${getDynamicMonth()}-09T16:00:00`,
            //         extendedProps: {
            //             calendar: "Primary"
            //         },
            //     },
            //     {
            //         groupId: "999",
            //         id: 4,
            //         title: "Submission #1",
            //         start: `${newDate.getFullYear()}-${getDynamicMonth()}-16T16:00:00`,
            //         extendedProps: {
            //             calendar: "Warning"
            //         },
            //     },
            //     {
            //         id: 5,
            //         title: "Seminar #6",
            //         start: `${newDate.getFullYear()}-${getDynamicMonth()}-11`,
            //         end: `${newDate.getFullYear()}-${getDynamicMonth()}-13`,
            //         extendedProps: {
            //             calendar: "Danger"
            //         },
            //     },
            //     {
            //         id: 6,
            //         title: "Meeting 3",
            //         start: `${newDate.getFullYear()}-${getDynamicMonth()}-12T10:30:00`,
            //         end: `${newDate.getFullYear()}-${getDynamicMonth()}-12T12:30:00`,
            //         extendedProps: {
            //             calendar: "Success"
            //         },
            //     },
            //     {
            //         id: 7,
            //         title: "Meetup #",
            //         start: `${newDate.getFullYear()}-${getDynamicMonth()}-12T12:00:00`,
            //         extendedProps: {
            //             calendar: "Primary"
            //         },
            //     },
            //     {
            //         id: 8,
            //         title: "Submission",
            //         start: `${newDate.getFullYear()}-${getDynamicMonth()}-12T14:30:00`,
            //         extendedProps: {
            //             calendar: "Warning"
            //         },
            //     },
            //     {
            //         id: 9,
            //         title: "Attend event",
            //         start: `${newDate.getFullYear()}-${getDynamicMonth()}-13T07:00:00`,
            //         extendedProps: {
            //             calendar: "Success"
            //         },
            //     },
            //     {
            //         id: 10,
            //         title: "Project submission #2",
            //         start: `${newDate.getFullYear()}-${getDynamicMonth()}-28`,
            //         extendedProps: {
            //             calendar: "Primary"
            //         },
            //     },
            // ];

        }
    </script>
@endonce
</div>
