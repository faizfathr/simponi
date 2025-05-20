<div class=" text-gray-800 font-sans min-h-screen p-4 sm:p-6">
    <style>
        .swiper-button-next,
        .swiper-button-prev {
            color: #475569 ;
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
    {{-- <div class="col-span-12 space-y-6 xl:col-span-7">
        <!-- Metric Group One -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6">
            <!-- Metric Item Start -->
            <x-dashboard.bubble-card title="Mitra" :mitra="$mitra"/> --}}
    <!-- Metric Item End -->

    {{-- <!-- Metric Item Start -->
            <div
                class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                    <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M11.665 3.75621C11.8762 3.65064 12.1247 3.65064 12.3358 3.75621L18.7807 6.97856L12.3358 10.2009C12.1247 10.3065 11.8762 10.3065 11.665 10.2009L5.22014 6.97856L11.665 3.75621ZM4.29297 8.19203V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0366V11.6513C11.1631 11.6205 11.0777 11.5843 10.9942 11.5426L4.29297 8.19203ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19202L13.0066 11.5426C12.9229 11.5844 12.8372 11.6208 12.75 11.6516V20.037ZM13.0066 2.41456C12.3732 2.09786 11.6277 2.09786 10.9942 2.41456L4.03676 5.89319C3.27449 6.27432 2.79297 7.05342 2.79297 7.90566V16.0946C2.79297 16.9469 3.27448 17.726 4.03676 18.1071L10.9942 21.5857L11.3296 20.9149L10.9942 21.5857C11.6277 21.9024 12.3732 21.9024 13.0066 21.5857L19.9641 18.1071C20.7264 17.726 21.2079 16.9469 21.2079 16.0946V7.90566C21.2079 7.05342 20.7264 6.27432 19.9641 5.89319L13.0066 2.41456Z"
                            fill="" />
                    </svg>
                </div>

                <div class="mt-5 flex items-end justify-between">
                    <div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Orders</span>
                        <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                            5,359
                        </h4>
                    </div>

                    <span
                        class="flex items-center gap-1 rounded-full bg-error-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500">
                        <svg class="fill-current" width="12" height="12" viewBox="0 0 12 12" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.31462 10.3761C5.45194 10.5293 5.65136 10.6257 5.87329 10.6257C5.8736 10.6257 5.8739 10.6257 5.87421 10.6257C6.0663 10.6259 6.25845 10.5527 6.40505 10.4062L9.40514 7.4082C9.69814 7.11541 9.69831 6.64054 9.40552 6.34754C9.11273 6.05454 8.63785 6.05438 8.34486 6.34717L6.62329 8.06753L6.62329 1.875C6.62329 1.46079 6.28751 1.125 5.87329 1.125C5.45908 1.125 5.12329 1.46079 5.12329 1.875L5.12329 8.06422L3.40516 6.34719C3.11218 6.05439 2.6373 6.05454 2.3445 6.34752C2.0517 6.64051 2.05185 7.11538 2.34484 7.40818L5.31462 10.3761Z"
                                fill="" />
                        </svg>

                        9.05%
                    </span>
                </div>
            </div>
            <!-- Metric Item End --> --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Statistik Produksi -->
        <div class="bg-white p-4 rounded-2xl shadow-md border border-brand-50">
            <h2 class="text-lg sm:text-xl font-semibold text-slate-700 mb-2">Kegiatan Statistik Produksi</h2>
            <p class="text-sm">
                Statistik Produksi mencakup kegiatan pengumpulan, pengolahan, dan analisis data produksi seperti
                kegiatan pertanian, perikanan, perkebunan, peternakan, industri besar dan sedang, produksi energi, serta konstruksi.
            </p>
        </div>

        <!-- Statistik Pertanian dan IPEK -->
        <div class="bg-white p-4 rounded-2xl shadow-md border border-brand-50">
            <h2 class="text-lg sm:text-xl font-semibold text-slate-700 mb-2">Statistik Pertanian & IPEK</h2>
            <ul class="list-disc list-inside text-sm space-y-1">
                <li>Survei Tanaman Pangan dan Hortikultura</li>
                <li>Survei Perkebunan, Peternakan, dan Perikanan</li>
                <li>Pendataan usaha skala kecil dan besar, Air Bersih, Perusahaan Konstruksi</li>
                <li>Serta kegiatan lainnya yang dilakukan secara Rutin bulanan, triwulanan, subround, dan tahunan</li>
            </ul>
        </div>
    </div>

    <!-- Anggota Tim -->
    <div class="bg-white p-4 rounded-2xl shadow-md border border-brand-50 mb-6">
        <h2 class="text-lg sm:text-xl font-semibold text-slate-700 mb-4">Anggota Tim</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Anggota 1 -->
            <div class="bg-brand-50 p-3 rounded-xl text-center">
                <img src="/img/anggota/faiz.png" alt="Foto"
                    class="object-top h-40 mx-auto rounded-full mb-2 object-cover">
                <p class="font-semibold text-sm">Elysa, SST</p>
                <p class="text-xs text-gray-600">Ketua Tim Produksi</p>
            </div>
            <!-- Anggota 2 -->
            <div class="bg-brand-50 p-3 rounded-xl text-center">
                <img src="/img/anggota/faiz.png" alt="Foto"
                    class="object-top h-40 mx-auto rounded-full mb-2 object-cover">
                <p class="font-semibold text-sm">Maudy Sazty Nataya, A.Md.Stat.</p>
                <p class="text-xs text-gray-600">Statistisi Terampil</p>
            </div>
            <!-- Anggota 3 -->
            <div class="bg-brand-50 p-3 rounded-xl text-center">
                <img src="/img/anggota/faiz.png" alt="Foto"
                    class="object-top h-40 mx-auto rounded-full mb-2 object-cover">
                <p class="font-semibold text-sm">Faiz Fathur Rahman, A.Md.Stat.</p>
                <p class="text-xs text-gray-600">Statistisi Terampil</p>
            </div>
            <!-- Anggota 4 -->
            <div class="bg-brand-50 p-3 rounded-xl text-center">
                <img src="/img/anggota/faiz.png" alt="Foto"
                    class="object-top h-40 mx-auto rounded-full mb-2 object-cover">
                <p class="font-semibold text-sm">Harmanto</p>
                <p class="text-xs text-gray-600">Statistisi Penyelia</p>
            </div>
        </div>
    </div>

    <!-- Dokumentasi Kegiatan -->
    <section class="bg-white p-6 rounded-2xl shadow-lg border border-brand-50">
        <h2 class="text-xl font-semibold text-slate-700 mb-4">Dokumentasi Kegiatan</h2>

        <div class="swiper swiperCardKegiatan">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <img src="/img/kegiatan/kegiatan_1.jpeg"
                        class="rounded-xl object-cover w-full h-72" alt="Kegiatan 1" />
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <img src="/img/kegiatan/kegiatan_2.jpeg"
                        class="rounded-xl object-cover w-full h-72" alt="Kegiatan 2" />
                </div>
                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <img src="/img/kegiatan/kegiatan_3.jpeg"
                        class="rounded-xl object-cover w-full h-72" alt="Kegiatan 3" />
                </div>
                <div class="swiper-slide">
                    <img src="/img/kegiatan/kegiatan_4.jpeg"
                        class="rounded-xl object-cover w-full h-72" alt="Kegiatan 3" />
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
    <script>
        const swiper = new Swiper(".swiperCardKegiatan", {
            loop: true,
            spaceBetween: 20,
            centeredSlides: true,
            grabCursor: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1.2,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 2.5,
                },
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    </script>
</div>
