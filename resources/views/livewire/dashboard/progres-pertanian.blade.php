<div x-init="setTimeout(() => loading = false, 500)">
    <div class="relative z-0 mb-3">
        <span class="absolute top-1/2 left-4 -translate-y-1/2">
            <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"
                    fill="" />
            </svg>
        </span>
        <div class="relative">
            <span class="absolute top-1/2 left-4 -translate-y-1/2">
                <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"
                        fill="" />
                </svg>
            </span>
            <input type="text" placeholder="Cari progres kegiatan..." wire:model.live.debounce.250ms='qSearch'
                class="dark:bg-dark-900 shadow-theme-xs bg-white focus:border-brand-600 focus:ring-brand-500/10 dark:focus:border-brand-600 h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden xl:w-[430px] dark:border-gray-800 dark:bg-gray-900 dark:bg-white/[0.03] dark:text-white/90 dark:placeholder:text-white/30" />
    
            <button id="search-button"
                class="absolute top-1/2 right-2.5 inline-flex -translate-y-1/2 items-center gap-0.5 rounded-lg border border-gray-200 bg-gray-50 px-[7px] py-[4.5px] text-xs -tracking-[0.2px] text-gray-500 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400">
                <span> ⌘ </span>
                <span> K </span>
            </button>
        </div>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Kegiatan Statistik Pertanian
            </h3>

            <div x-data="{ openDropDown: false }" class="relative">
                <div class="flex flex-col md:flex-row gap-3 justify-start">
                    <div class="flex items-center gap-2">
                        <label for="tahun" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Menampilkan
                        </label>
                        <select wire:model.live='perPage'
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 max-w-max appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            @foreach ([5, 10, 25, 50, 100] as $pgn)
                                <option value="{{ $pgn }}"
                                    class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                    {{ $pgn }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="tahun" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Tahun Kegiatan
                        </label>
                        <select id="tahun" wire:model.live="tahun"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 max-w-max appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">

                            @foreach (range(2023, 2028) as $thn)
                                <option value="{{ $thn }}"
                                    class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                    {{ $thn }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex h-[60vh] flex-col">
            <div class="custom-scrollbar flex h-auto flex-col overflow-y-auto pr-3">
                <!-- Item  -->
                @if (!$data->isEmpty())
                    @foreach ($data as $index => $item)
                        <div
                            class="flex items-center justify-between border-b border-gray-200 pb-4 pt-4 first:pt-0 last:border-b-0 last:pb-0 dark:border-gray-800">
                            <div class="flex items-center gap-3 w-2/4">
                                <div>
                                    <h3 class="font-semibold text-gray-800 text-sm md:text-base dark:text-white/90">
                                        {{ $item->kegiatan }}
                                    </h3>
                                    <span class="block text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                        {{ $this->ketPeriode[$item->periode - 1] }}
                                        {{ $item->periode == 4 ? $item->tahun : ($item->periode == 1 ? $this->listBulan[$item->waktu - 1] : $this->romawiFont[$item->waktu - 1]) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-x-2 w-1/4 justify-center">
                                <div class="flex flex-col">
                                    <h4 class="text-right text-theme-sm font-medium text-gray-700 dark:text-gray-400">
                                        T: {{ $item->target }}
                                    </h4>
                                    <span class="text-theme-xs font-medium text-success-600 dark:text-success-500">
                                        R: {{ $item->realisasi }}
                                    </span>
                                </div>
                                <div class="hidden lg:flex w-full max-w-[140px] items-center gap-3 mx-auto">
                                    <div
                                        class="relative block h-2 w-full max-w-[100px] rounded-sm bg-gray-200 dark:bg-gray-800">
                                        <div style="width: {{ $item->target === 0 ? 0 : number_format(($item->realisasi / $item->target) * 100, 0) }}%"
                                            class="absolute left-0 top-0 flex h-full items-center justify-center rounded-sm {{ $item->target === 0 || ($item->realisasi / $item->target) * 100 <= 20 ? 'bg-red-500' : (($item->realisasi / $item->target) * 100 <= 70 ? 'bg-yellow-400' : 'bg-success-500') }} text-xs font-medium text-white">
                                        </div>
                                    </div>
                                    <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $item->target === 0 ? 0 : number_format(($item->realisasi / $item->target) * 100, 1) }}%
                                    </p>
                                </div>
                                {{-- <h3 class="text-sm font-semibold text-white rounded-full px-2 py-0.5 bg-brand-500">
                                    {{ $item->target === 0 ? 0 : number_format($item->realisasi/$item->target*100,1) }}%
                                </h3> --}}
                            </div>
                            <div class="flex items-center gap-x-2 justify-end ">
                                <a wire:navigate href="{{ route('detail-monitoring', $item->id) }}"
                                    class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                                    <span class="mr-1 text-xs hidden md:block">Detail</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4 text-gray-500 text-lg dark:text-gray-400">
                        Kegiatan tidak ditemukan
                    </div>
                @endif
            </div>
        </div>
        @if (!$qSearch)
            <div class="my-2 mr-1">
                {{ $data->links() }}
            </div>
        @endif
    </div>
</div>
