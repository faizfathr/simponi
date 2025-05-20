<div x-data="{ idMonitoring: @entangle('idMonitoring') }" id="id-monitoring">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 mb-3" wire:key="{{ $idMonitoring }}">
        @foreach ($contentsYearly as $content)
            <div class="rounded-2xl border border-gray-200 bg-gray-200 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="shadow-default rounded-2xl bg-white px-5 pb-11 pt-5 dark:bg-gray-900 sm:px-6 sm:pt-6">
                    <div class="flex justify-between">
                        <div>
                            <h3 class="text-center text-lg font-semibold text-gray-800 dark:text-white/90">
                                {{ $content->kegiatan }}
                            </h3>
                        </div>
                        <div x-data="{ openDropDown: false }" class="relative h-fit">
                            <button @click="openDropDown = !openDropDown"
                                :class="openDropDown ? 'text-gray-700 dark:text-white' :
                                    'text-gray-400 hover:text-gray-700 dark:hover:text-white'">
                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.2441 6C10.2441 5.0335 11.0276 4.25 11.9941 4.25H12.0041C12.9706 4.25 13.7541 5.0335 13.7541 6C13.7541 6.9665 12.9706 7.75 12.0041 7.75H11.9941C11.0276 7.75 10.2441 6.9665 10.2441 6ZM10.2441 18C10.2441 17.0335 11.0276 16.25 11.9941 16.25H12.0041C12.9706 16.25 13.7541 17.0335 13.7541 18C13.7541 18.9665 12.9706 19.75 12.0041 19.75H11.9941C11.0276 19.75 10.2441 18.9665 10.2441 18ZM11.9941 10.25C11.0276 10.25 10.2441 11.0335 10.2441 12C10.2441 12.9665 11.0276 13.75 11.9941 13.75H12.0041C12.9706 13.75 13.7541 12.9665 13.7541 12C13.7541 11.0335 12.9706 10.25 12.0041 10.25H11.9941Z"
                                        fill="" />
                                </svg>
                            </button>
                            <div x-show="openDropDown" @click.outside="openDropDown = false"
                                class="absolute right-0 top-full z-40 w-40 space-y-1 rounded-2xl border border-gray-200 bg-white p-2 shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark">
                                <button
                                    class="flex w-full rounded-lg px-3 py-2 text-left text-theme-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                    View More
                                </button>
                                <button
                                    class="flex w-full rounded-lg px-3 py-2 text-left text-theme-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="relative max-h-[195px]">
                        <div id="{{ $content->id_kegiatan }}" class="h-full"></div>
                    </div>
                    <div class="text-center">
                        <p class="mx-auto mt-10 w-full max-w-[380px] text-center text-sm text-gray-500 sm:text-base">
                            Pelaksanaan kegiatan berlangsung pada
                        </p>
                        <span class="font-bold">
                            {{ is_null($content->mulai) || is_null($content->selesai) ? 'Tanggal Belum diatur' : (date('m', strtotime($content->mulai)) === date('m', strtotime($content->selesai)) ? date('d', strtotime($content->mulai)) . date(' - d ', strtotime($content->selesai)) . $bulan[(int) date('m', strtotime($content->selesai))] . date(' Y', strtotime($content->selesai)) : date('d', strtotime($content->mulai)) . ' ' . $bulan[(int) date('m', strtotime($content->mulai))] . date(' - d ', strtotime($content->selesai)) . $bulan[(int) date('m', strtotime($content->selesai))] . date(' Y', strtotime($content->selesai))) }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-5 px-6 py-3.5 sm:gap-8 sm:py-5">
                    <div>
                        <p
                            class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm font-semibold">
                            Target
                        </p>
                        <p
                            class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                            {{ $content->target }}
                        </p>
                    </div>

                    <div class="h-7 w-px bg-gray-200 dark:bg-gray-800"></div>

                    <div>
                        <p
                            class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm font-semibold">
                            Realisasi
                        </p>
                        <p
                            class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                            {{ $content->realisasi }}
                        </p>
                    </div>

                    <div class="h-7 w-px bg-gray-200 dark:bg-gray-800"></div>
                </div>
            </div>
        @endforeach

    </div>
    <div class="grid gap-2">
        @foreach ($contentsNonYearly as $content)
            <div
                class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
                <div class="flex items-center justify-between text-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        {{ $content->kegiatan }}
                    </h3>

                    <div x-data="{ openDropDown: false }" class="relative h-fit">
                        <button @click="openDropDown = !openDropDown"
                            :class="openDropDown ? 'text-gray-700 dark:text-white' :
                                'text-gray-400 hover:text-gray-700 dark:hover:text-white'">
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.2441 6C10.2441 5.0335 11.0276 4.25 11.9941 4.25H12.0041C12.9706 4.25 13.7541 5.0335 13.7541 6C13.7541 6.9665 12.9706 7.75 12.0041 7.75H11.9941C11.0276 7.75 10.2441 6.9665 10.2441 6ZM10.2441 18C10.2441 17.0335 11.0276 16.25 11.9941 16.25H12.0041C12.9706 16.25 13.7541 17.0335 13.7541 18C13.7541 18.9665 12.9706 19.75 12.0041 19.75H11.9941C11.0276 19.75 10.2441 18.9665 10.2441 18ZM11.9941 10.25C11.0276 10.25 10.2441 11.0335 10.2441 12C10.2441 12.9665 11.0276 13.75 11.9941 13.75H12.0041C12.9706 13.75 13.7541 12.9665 13.7541 12C13.7541 11.0335 12.9706 10.25 12.0041 10.25H11.9941Z"
                                    fill="" />
                            </svg>
                        </button>
                        <div x-show="openDropDown" @click.outside="openDropDown = false"
                            class="absolute right-0 z-40 w-40 p-2 space-y-1 bg-white border border-gray-200 top-full rounded-2xl shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark h-20 overflow-y-scroll">
                            <button
                                class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                2024
                            </button>
                            <button
                                class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                2025
                            </button>
                        </div>
                    </div>
                </div>

                <div class="max-w-full overflow-x-auto custom-scrollbar">
                    <div class="-ml-5 min-w-[600px] pl-2 xl:min-w-full">
                        <div id="{{ $content->id }}" class="-ml-5 h-full min-w-[600px] pl-2 xl:min-w-full"></div>
                    </div>
                </div>
            </div>
        @endforeach
        <script>
            Livewire.on('updateSubmonitoring', () => {
                import('/js/halfDonutChart-progres.js').then((mod) => {
                    // Panggil fungsi utama dari modul jika ada
                    if (mod.default) {
                        mod.default(); // kalau pakai export default
                    } else if (mod.init) {
                        mod.init(); // kalau pakai export const init = () => {...}
                    }
                }).catch(error => {
                    console.error('Gagal load module:', error);
                });
            })
        </script>
        <script src="/js/barChart-progres.js"></script>
        <script src="/js/halfDonutChart-progres.js"></script>
    </div>
</div>
