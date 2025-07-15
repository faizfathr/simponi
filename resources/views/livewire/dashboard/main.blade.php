<div class=" text-gray-800 font-sans min-h-screen p-4 sm:p-6" x-data="{ tahunKegiatan: 2025 }" x-init="$nextTick(() => {
    if (window.swiperInstance) {
        window.swiperInstance.destroy(true, true);
    }

    const swiperEl = document.querySelector('.swiperCardKegiatan');
    if (!swiperEl) return;

    window.swiperInstance = new Swiper('.swiperCardKegiatan', {
        loop: true,
        spaceBetween: 20,
        centeredSlides: true,
        grabCursor: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            320: { slidesPerView: 1 },
            640: { slidesPerView: 1.2 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 2.5 },
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
});
setTimeout(() => loading = false, 500)"
    x-watch="tahunKegiatan"
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
        }">
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

    <div class="bg-white dark:bg-gray-800 text-slate-900 rounded-xl -mt-4 flex flex-col gap-4 mb-6 p-6 shadow-lg ">

        <!-- Header: Logo Kiri, Teks Tengah, Logo Kanan -->
        <div class="flex items-center justify-between">
            <!-- Logo BPS -->
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/bps.png') }}" alt="Logo BPS Singkawang" class="h-8 md:h-16 w-auto">
                <div
                    class="flex flex-col font-bold font-[arial] text-xs md:text-sm text-slate-700 dark:text-white italic">
                    <span>Badan Pusat Statistik</span>
                    <span>Kota Singkawang</span>
                </div>
            </div>


            <!-- Logo SIMPONI -->
            <div class="flex flex-col items-center gap-2">
                <img src="{{ asset('/logo/logo.png') }}" alt="Logo SIMPONI" class="h-8 md:h-20 w-auto">
                <span class="text-xs md:text-lg text-slate-700 dark:text-white font-bold">SIMPONI</span>
            </div>
        </div>

        <!-- Subjudul dan Deskripsi -->
        <div class="text-center mt-2">
            <h1 class="text-2xl md:text-3xl font-bold text-slate-600 uppercase dark:text-white">
                Selamat datang di SIMPONI!
            </h1>
            <p class="text-sm md:text-xl mt-1 leading-relaxed text-gray-700 dark:text-white">
                <span class="font-bold text-brand-500">SI</span><span>stem </span>
                <span class="font-bold text-brand-500">M</span><span>onitoring </span>
                <span>Statistik </span>
                <span class="font-bold text-brand-500">P</span><span>r<span
                        class="font-bold text-brand-500">O</span>duksi </span>
                <span>Teri</span><span class="font-bold text-brand-500">N</span><span>tegras<span class="font-bold text-brand-500">I</span></span>
                
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Statistik Produksi -->
        <div class="bg-white dark:bg-gray-800 dark:border-slate-900 p-4 rounded-2xl shadow-md border border-brand-50">
            <h2 class="text-lg sm:text-xl font-semibold text-slate-700 dark:text-white mb-2">Kegiatan Statistik
                Pertanian
            </h2>
            <ul class="list-disc list-inside text-sm space-y-1 dark:text-slate-100">
                <li>Survei Kerangka Sampel Area (KSA)</li>
                <li>Laporan Pemotongan Ternak Bulanan (LPTB)</li>
                <li>Survei Tanaman Sayuran dan Buah - buah Semusim (SBS)</li>
                <li>Serta kegiatan lainnya yang dilakukan secara Rutin bulanan, triwulanan, subround, dan tahunan</li>
            </ul>
        </div>

        <!-- Statistik Pertanian dan IPEK -->
        <div class="dark:bg-gray-800 dark:border-slate-900 bg-white p-4 rounded-2xl shadow-md border border-brand-50">
            <h2 class="text-lg sm:text-xl font-semibold dark:text-white text-slate-700 mb-2">Kegiatan Statistik Industri
                Pengolahan, Energi, dan
                Konstruksi</h2>
            <ul class="list-disc list-inside text-sm space-y-1 dark:text-slate-100">
                <li>Survei Industri Kecil dan Mikro (IMK)</li>
                <li>Survei Air Bersih</li>
                <li>Updating Direktori Perusahaan Konstruksi</li>
                <li>Serta kegiatan lainnya yang dilakukan secara Rutin bulanan, triwulanan, dan tahunan</li>
            </ul>
        </div>
    </div>
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


    <!-- Anggota Tim -->
    <div class="dark:bg-gray-800 dark:border-slate-900 bg-white p-4 rounded-2xl shadow-md border border-brand-50 mb-6">
        <h2 class="text-lg sm:text-xl font-semibold dark:text-white text-slate-700 mb-4">Anggota Tim Statistik Produksi
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Anggota 1 -->
            <div class="dark:bg-gray-700 bg-brand-50 p-3 rounded-xl text-center">
                <img src="/img/anggota/elysa.png" alt="Foto"
                    class="object-top h-40 mx-auto rounded-full mb-2 object-cover">
                <p class="font-semibold text-sm dark:text-white">Elysa, SST</p>
                <p class="text-xs text-gray-600 dark:text-gray-100">Ketua Tim Statistik Produksi</p>
            </div>
            <!-- Anggota 2 -->
            <div class="dark:bg-gray-700 bg-brand-50 p-3 rounded-xl text-center">
                <img src="/img/anggota/maudy.png" alt="Foto"
                    class="object-top h-40 mx-auto rounded-full mb-2 object-cover">
                <p class="font-semibold text-sm dark:text-white">Maudy Sazty Nataya, A.Md.Stat.</p>
                <p class="text-xs text-gray-600 dark:text-gray-100">Statistisi Terampil</p>
            </div>
            <!-- Anggota 3 -->
            <div class="dark:bg-gray-700 bg-brand-50 p-3 rounded-xl text-center">
                <img src="/img/anggota/faiz.png" alt="Foto"
                    class="object-top h-40 mx-auto rounded-full mb-2 object-cover">
                <p class="font-semibold text-sm dark:text-white">Faiz Fathur Rahman, A.Md.Stat.</p>
                <p class="text-xs text-gray-600 dark:text-gray-100">Statistisi Terampil</p>
            </div>
            <!-- Anggota 4 -->
            <div class="dark:bg-gray-700 bg-brand-50 p-3 rounded-xl text-center">
                <img src="/img/anggota/harmanto.png" alt="Foto"
                    class="object-top h-40 mx-auto rounded-full mb-2 object-cover">
                <p class="font-semibold text-sm dark:text-white">Harmanto</p>
                <p class="text-xs text-gray-600 dark:text-gray-100">Statistisi Penyelia</p>
            </div>
        </div>
    </div>

    <!-- Dokumentasi Kegiatan -->
    <section class="dark:bg-gray-700 dark:border-slate-900 bg-white p-6 rounded-2xl shadow-lg border border-brand-50">
        <h2 class="dark:text-gray-100 text-xl font-semibold text-slate-700 mb-4">Dokumentasi Kegiatan</h2>

        <div class="swiper swiperCardKegiatan">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <img src="/img/kegiatan/kegiatan_1.jpeg" class="rounded-xl object-cover w-full h-72"
                        alt="Kegiatan 1" />
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <img src="/img/kegiatan/kegiatan_2.jpeg" class="rounded-xl object-cover w-full h-72"
                        alt="Kegiatan 2" />
                </div>
                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <img src="/img/kegiatan/kegiatan_3.jpeg" class="rounded-xl object-cover w-full h-72"
                        alt="Kegiatan 3" />
                </div>
                <div class="swiper-slide">
                    <img src="/img/kegiatan/kegiatan_4.jpeg" class="rounded-xl object-cover w-full h-72"
                        alt="Kegiatan 3" />
                </div>
                <div class="swiper-slide">
                    <img src="/img/kegiatan/kegiatan_5.jpeg" class="rounded-xl object-cover w-full h-72"
                        alt="Kegiatan 3" />
                </div>
                <!-- Tambahkan slide lainnya jika perlu -->
            </div>

            <!-- Navigasi panah -->
            <div class="swiper-button-next text-slate-600"></div>
            <div class="swiper-button-prev text-slate-600"></div>

            <!-- Navigasi bulatan bawah -->
            <div class="swiper-pagination mt-4"></div>
        </div>
    </section>
    <!-- Section: Download Buku Panduan -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 mb-6 border border-brand-50 dark:border-gray-800 mt-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-lg sm:text-xl font-semibold text-slate-700 dark:text-white">
                    Buku Panduan SIMPONI
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Unduh buku panduan penggunaan sistem SIMPONI untuk memahami fitur dan alur kerja.
                </p>
            </div>
            <a href="{{ route('download.guidebook')}}" download
                class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium rounded-lg shadow transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 16.5v-12m0 12l3.75-3.75M12 16.5l-3.75-3.75M3 20.25h18" />
                </svg>
                Download PDF
            </a>
        </div>
    </div>

    @once
        <script src="{{ asset('js/mainChart.js') }}"></script>
    @endonce
</div>
