<div>
    <div class=" text-gray-800 font-sans min-h-screen p-4 sm:p-6" x-data="{ tahunKegiatan: 2025 }" x-effect="
       
   if (tahunKegiatan) {
    fetch('/resource/aggregatProgres', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
        },
        body: JSON.stringify({ tahun: tahunKegiatan })
    })
    .then(response => {
        if (!response.ok) throw new Error('HTTP error ' + response.status);
        return response.json();
    })
    .then(data => {
        mainChart('progresChart', data.data); // hanya ambil bagian 'data'
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });
} 
" x-init=" setTimeout(()=>loading=false, 500);
        new Swiper('.swiperCardKegiatan', {
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
        });
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

    <div class="bg-white dark:bg-gray-800 text-slate-900 rounded-xl -mt-4 flex flex-col gap-4 mb-6 p-6 shadow-lg ">

        <!-- Header: Logo Kiri, Teks Tengah, Logo Kanan -->
        <div class="flex items-center justify-between">
            <!-- Logo BPS -->
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/bps.webp') }}" alt="Logo BPS Singkawang" class="h-8 md:h-16 w-auto">
                <div
                    class="flex flex-col font-bold font-[arial] text-xs md:text-sm text-slate-700 dark:text-white italic">
                    <span>Badan Pusat Statistik</span>
                    <span>Kota Singkawang</span>
                </div>
            </div>


            <!-- Logo SIMPONI -->
            <div class="flex flex-col items-center gap-2">
                <img src="{{ asset('/logo/logo.webp') }}" alt="Logo SIMPONI" class="h-8 md:h-20 w-auto">
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
      <!-- Anggota Tim -->
    <div class="mt-6 dark:bg-gray-800 dark:border-slate-900 bg-white p-4 rounded-2xl shadow-md border border-brand-50 mb-6">
        <h2 class="text-lg sm:text-xl font-semibold dark:text-white text-slate-700 mb-4">Anggota Tim Statistik Produksi
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Anggota 1 -->
            <div class="dark:bg-gray-700 bg-brand-50 p-3 rounded-xl text-center">
                <img src="/img/anggota/elysa.webp" alt="Foto"
                    class="object-top h-40 mx-auto rounded-full mb-2 object-cover">
                <p class="font-semibold text-sm dark:text-white">Elysa, SST</p>
                <p class="text-xs text-gray-600 dark:text-gray-100">Ketua Tim Statistik Produksi</p>
            </div>
            <!-- Anggota 2 -->
            <div class="dark:bg-gray-700 bg-brand-50 p-3 rounded-xl text-center">
                <img src="/img/anggota/maudy.webp" alt="Foto"
                    class="object-top h-40 mx-auto rounded-full mb-2 object-cover">
                <p class="font-semibold text-sm dark:text-white">Maudy Sazty Nataya, A.Md.Stat.</p>
                <p class="text-xs text-gray-600 dark:text-gray-100">Statistisi Terampil</p>
            </div>
            <!-- Anggota 3 -->
            <div class="dark:bg-gray-700 bg-brand-50 p-3 rounded-xl text-center">
                <img src="/img/anggota/faiz.webp" alt="Foto"
                    class="object-top h-40 mx-auto rounded-full mb-2 object-cover">
                <p class="font-semibold text-sm dark:text-white">Faiz Fathur Rahman, A.Md.Stat.</p>
                <p class="text-xs text-gray-600 dark:text-gray-100">Statistisi Terampil</p>
            </div>
            <!-- Anggota 4 -->
            <div class="dark:bg-gray-700 bg-brand-50 p-3 rounded-xl text-center">
                <img src="/img/anggota/harmanto.webp" alt="Foto"
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
                    <img src="/img/kegiatan/kegiatan_1.webp" class="rounded-xl object-cover w-full h-72"
                        alt="Kegiatan 1" />
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <img src="/img/kegiatan/kegiatan_2.webp" class="rounded-xl object-cover w-full h-72"
                        alt="Kegiatan 2" />
                </div>
                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <img src="/img/kegiatan/kegiatan_3.webp" class="rounded-xl object-cover w-full h-72"
                        alt="Kegiatan 3" />
                </div>
                <div class="swiper-slide">
                    <img src="/img/kegiatan/kegiatan_4.webp" class="rounded-xl object-cover w-full h-72"
                        alt="Kegiatan 3" />
                </div>
                <div class="swiper-slide">
                    <img src="/img/kegiatan/kegiatan_5.webp" class="rounded-xl object-cover w-full h-72"
                        alt="Kegiatan 3" />
                </div>
                <!-- Tambahkan slide lainnya jika perlu -->
            </div>

            <!-- Navigasi panah -->
            <div class="swiper-button-next" style="color: #fff;"></div>
            <div class="swiper-button-prev" style="color: #fff;"></div>

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
        <script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.swiperCardKegiatan', {
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
        });
    });
</script>

    @endonce
    </div>
</div>
