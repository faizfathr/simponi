<div class=" text-gray-800 font-sans min-h-screen p-4 sm:p-6"
    x-data
    x-init="
        $nextTick(() => {
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
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Statistik Produksi -->
        <div class="bg-white dark:bg-gray-800 dark:border-slate-900 p-4 rounded-2xl shadow-md border border-brand-50">
            <h2 class="text-lg sm:text-xl font-semibold text-slate-700 dark:text-white mb-2">Kegiatan Statistik Pertanian</h2>
            <ul class="list-disc list-inside text-sm space-y-1 dark:text-slate-100">
                <li>Survei Kerangka Sampel Area (KSA)</li>
                <li>Laporan Pemotongan Ternak Bulanan (LPTB)</li>
                <li>Survei Tanaman Sayuran dan Buah - buah Semusim (SBS)</li>
                <li>Serta kegiatan lainnya yang dilakukan secara Rutin bulanan, triwulanan, subround, dan tahunan</li>
            </ul>
        </div>

        <!-- Statistik Pertanian dan IPEK -->
        <div class="dark:bg-gray-800 dark:border-slate-900 bg-white p-4 rounded-2xl shadow-md border border-brand-50">
            <h2 class="text-lg sm:text-xl font-semibold dark:text-white text-slate-700 mb-2">Kegiatan Statistik Industri Pengolahan, Energi, dan
                Konstruksi</h2>
            <ul class="list-disc list-inside text-sm space-y-1 dark:text-slate-100">
                <li>Survei Industri Kecil dan Mikra (IMK)</li>
                <li>Survei Air Bersih</li>
                <li>Updating Direktori Perusahaan Konstruksi</li>
                <li>Serta kegiatan lainnya yang dilakukan secara Rutin bulanan, triwulanan, dan tahunan</li>
            </ul>
        </div>
    </div>

    <!-- Anggota Tim -->
    <div class="dark:bg-gray-800 dark:border-slate-900 bg-white p-4 rounded-2xl shadow-md border border-brand-50 mb-6">
        <h2 class="text-lg sm:text-xl font-semibold dark:text-white text-slate-700 mb-4">Anggota Tim Statistik Produksi</h2>
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
</div>
