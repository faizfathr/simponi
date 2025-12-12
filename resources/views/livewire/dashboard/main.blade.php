<div class="text-gray-800 font-sans min-h-screen" x-data="{ tahunKegiatan: 2025 }" x-init="setTimeout(() => loading = false, 500)"
    x-effect="
        if(tahunKegiatan) {
            fetch('/resource/aggregatProgres', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({ tahun: tahunKegiatan })
            })
            .then((response)=> response.json())
            .then((response)=> {
                mainChart('progresChart', response)
            });
        }
    ">
    <style>
        .swiper-button-next,
        .swiper-button-prev {
            color: #475569;
            /* brand-500 */
            transition: transform 0.2s ease;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            transform: scale(1.1);
        }

        .swiper-slide img {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .swiper-slide img:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
    @if (session('login-valid'))
        <div x-data="{ showNotif: true }">
            <x-dashboard.notification showNotif="showNotif" message="Selamat datang {{ Auth::user()->nama }}"
                status="Login Berhasil" />
        </div>
    @endif
    @if (session('logout-valid'))
        <div x-data="{ showNotif: true }">
            <x-dashboard.notification showNotif="showNotif"
                message="Silahkan login kembali jika ingin menggunakan hak user" status="Logout Berhasil" />
        </div>
    @endif

    <div class="swiper swiperCardMonitoring">
        <div class="swiper-wrapper">
            @foreach ($kegiatan as $kegiatanItem)
                <div class="swiper-slide">
                    <x-dashboard.card-monitoring
                        query="{{ $kegiatanItem?->joinKegiatan->kegiatan }},{{ $kegiatanItem?->waktu }},{{ $kegiatanItem?->tahun }},{{ $kegiatanItem?->joinKegiatan->periode }},{{ $kegiatanItem?->id_kegiatan }}" />
                </div>
            @endforeach
        </div>
        <!-- Navigasi panah -->
        <div class="swiper-button-next" style="color: #fb923c;"></div>
        <div class="swiper-button-prev" style="color: #fb923c;"></div>

        <!-- Navigasi bulatan bawah -->
        <div class="swiper-pagination mt-6"></div>
    </div>
{{-- tabel monitoring --}}
<div class="bg-white dark:bg-gray-800 overflow-x-auto shadow-md rounded-2xl p-4 border border-gray-200 dark:border-gray-700 mt-4 h-[100vh] overflow-y-scroll">

    <table class="table w-full border-collapse">
        <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0 z-20">

        {{-- BARIS 1 HEADER --}}
        <tr>
            <th rowspan="2" class="px-10 py-2 text-left text-xs text-gray-600 dark:text-gray-300 font-bold uppercase tracking-wider border">
                Kegiatan Survei
            </th>

            <th rowspan="2" class="px-4 py-2 text-left text-xs text-gray-600 dark:text-gray-300 font-bold uppercase tracking-wider border">
                Periode
            </th>

            @foreach ($bulan as $b)
                <th colspan="2"
                    class="px-4 py-2 text-center text-xs text-gray-700 dark:text-gray-200 font-bold uppercase tracking-wider border bg-orange-100 dark:bg-orange-900">
                    {{ $b }}
                </th>
            @endforeach
        </tr>

        {{-- BARIS 2 HEADER --}}
        <tr>
            @foreach ($bulan as $b)
                <th class="px-2 py-1 text-center text-xs text-gray-600 dark:text-gray-300 font-semibold uppercase border w-8">T</th>
                <th class="px-2 py-1 text-center text-xs text-gray-600 dark:text-gray-300 font-semibold uppercase border w-8">R</th>
            @endforeach
        </tr>

        </thead>

        <tbody>

        @foreach ($subKegiatan as $kategori)

            {{-- JUDUL KATEGORI --}}
            <tr class="bg-orange-400 text-white">
                <td colspan="{{ 2 + (count($bulan) * 2) }}"
                    class="font-bold uppercase tracking-wider border px-3 py-2">
                    {{ $subKegiatanNama[$kategori-1] }}
                </td>
            </tr>

            {{-- LOOP SUBJUDUL YANG BANYAK --}}
            @foreach ($kegiatanSurvei as $sub)
                
                @if($sub->subsektor == $kategori)
                    {{-- SUBJUDUL --}}
                   
                    {{-- ITEM UTAMA --}}
                    <tr class="bg-gray-50 dark:bg-gray-700/40">
                        <td class="border px-3 py-2 font-semibold">
                            {{ $sub->kegiatan }}
                        </td>

                        <td class="border px-3 py-2 text-center">
                            {{ $sub->periode ?? '—' }}
                        </td>

                        @foreach ($bulan as $b)
                            <td class="border h-8"></td>
                            <td class="border h-8"></td>
                        @endforeach
                    </tr>
               

                    {{-- CHILD --}}
                    {{--
                    @foreach ($item['children'] as $child)
                        <tr>
                            <td class="border px-6 py-1">- {{ $child }}</td>

                            <td class="border text-center">—</td>

                            @foreach ($bulan as $b)
                                <td class="border h-7"></td>
                                <td class="border h-7"></td>
                            @endforeach
                        </tr>
                    @endforeach
                        --}}
                @endif
            @endforeach

        @endforeach

        </tbody>
    </table>

</div>
{{-- end tabel monitoring --}}

           <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6">
        <!-- Card 1: Kegiatan Bulan Ini -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-4 border border-gray-200 dark:border-gray-700">
            <div class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3 flex gap-x-2 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                </svg>
                <h2>Kegiatan Bulan Ini</h2>
            </div>
            <div class="max-h-[30vh] overflow-y-auto space-y-3 pr-2">
                @foreach ($kegiatan as $kegiatanItem)
                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-xl">
                        <p class="font-medium text-gray-700 dark:text-gray-100">
                            {{ $kegiatanItem?->joinKegiatan->kegiatan }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal mulai:
                            {{ \Carbon\Carbon::parse($kegiatanItem->tanggal_mulai)->translatedFormat('d F Y') }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Card 2: Progres Lapangan -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-4 border border-gray-200 dark:border-gray-700">
            <div class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3 flex gap-x-2 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                </svg>
                <h2>Progres Berjalan</h2>
            </div>
            <div class="max-h-[30vh] overflow-y-auto space-y-4 pr-2">
                @if ($kegiatanBerjalan)
                    @foreach ($kegiatanBerjalan as $kegiatanBerjalanItem)
                        @if (($kegiatanBerjalanItem->realisasi / $kegiatanBerjalanItem->target) * 100 < 100)
                            <div>
                                <div class="flex justify-between text-sm text-gray-700 dark:text-gray-100 mb-1">
                                    <span>{{ $kegiatanBerjalanItem->joinKegiatan?->kegiatan }}</span>
                                    <span>{{ number_format(((int) $kegiatanBerjalanItem->realisasi / $kegiatanBerjalanItem->target) * 100, 1) }}%
                                    </span>
                                </div>
                                @php
                                    $target = $kegiatanBerjalanItem->target ?: 1;
                                    $persentase = number_format(
                                        ((int) $kegiatanBerjalanItem->realisasi / $target) * 100,
                                        0,
                                    );
                                @endphp
                                <div class="w-full bg-gray-200 dark:bg-gray-600 h-3 rounded-full">
                                    <div class="{{ $persentase <= 30 ? 'bg-red-500' : ($persentase <= 60 ? 'bg-yellow-400' : 'bg-success-500') }} h-3 rounded-full"
                                        style="width: {{ $persentase }}%;">
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="text-gray-500 dark:text-gray-400 text-sm">
                        Tidak ada kegiatan yang sedang berjalan saat ini.
                    </div>
                @endif
            </div>
        </div>
    </div>


    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-4 mb-6">
        <div
            class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 flex gap-x-2 items-center justify-between">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                </svg>

                <span>Progres Bulanan</span>
            </div>
            <div class="flex items-center gap-2">
                <label for="tahun" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Tahun Kegiatan
                </label>
                <select id="tahun" x-model="tahunKegiatan"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 max-w-max appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">

                    @foreach (range(2023, 2028) as $thn)
                        <option value="{{ $thn }}" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                            {{ $thn }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div id="progresChart" class="w-full"></div>
    </div>

    @once
        <script src="{{ asset('js/mainChart.js') }}"></script>
        <script>
            document.addEventListener("livewire:navigated", () => {
                // Hancurkan instance Swiper lama
                if (window.swiperCardMonitoring && window.swiperCardMonitoring.destroy) {
                    window.swiperCardMonitoring.destroy(true, true);
                }

                // Re-inisialisasi Swiper
                window.swiperCardMonitoring = new Swiper('.swiperCardMonitoring', {
                    loop: true,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    slidesPerView: 1,
                    spaceBetween: 20,
                    breakpoints: {
                        768: {
                            slidesPerView: 2
                        },
                        1024: {
                            slidesPerView: 3
                        },
                    },
                    preventClicks: false,
                    preventClicksPropagation: false,
                    grabCursor: true,
                    simulateTouch: true,
                    touchStartPreventDefault: false,
                    allowTouchMove: true,
                });

                // Jika kamu juga pakai ApexCharts, re-render di sini
                if (typeof window.initApexCharts === 'function') {
                    window.initApexCharts();
                }
            });
        </script>
    @endonce
</div>
