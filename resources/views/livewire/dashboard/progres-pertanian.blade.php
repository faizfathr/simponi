<div>
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Kegiatan Statistik Pertanian
            </h3>

            <div x-data="{ openDropDown: false }" class="relative">
                <button 
                    @click="openDropDown = !openDropDown"
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

        <div class="flex h-[372px] flex-col">
            <div class="custom-scrollbar flex h-auto flex-col overflow-y-auto pr-3">
                <!-- Item  -->
                @foreach ($data as $index => $item)
                    <div
                        class="flex items-center justify-between border-b border-gray-200 pb-4 pt-4 first:pt-0 last:border-b-0 last:pb-0 dark:border-gray-800">
                        <div class="flex items-center gap-3 w-2/4">
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-white/90">
                                    {{ $item->kegiatan }}
                                </h3>
                                <span class="block text-theme-xs text-gray-500 dark:text-gray-400">
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
                                  class="relative block h-2 w-full max-w-[100px] rounded-sm bg-gray-200 dark:bg-gray-800"
                                >
                                  <div
                                    style="width: {{ $item->target === 0 ? 0 : number_format($item->realisasi/$item->target*100,0) }}%"
                                    class="absolute left-0 top-0 flex h-full items-center justify-center rounded-sm {{ $item->target === 0 || $item->realisasi/$item->target*100 <= 20 ? 'bg-red-500' : ($item->realisasi/$item->target*100 <= 70 ? 'bg-yellow-400' : 'bg-success-500') }} text-xs font-medium text-white"
                                  ></div>
                                </div>
                                <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                                  {{ $item->target === 0 ? 0 : number_format($item->realisasi/$item->target*100,1) }}%
                                </p>
                              </div>
                            {{-- <h3 class="text-sm font-semibold text-white rounded-full px-2 py-0.5 bg-brand-500">
                                {{ $item->target === 0 ? 0 : number_format($item->realisasi/$item->target*100,1) }}%
                            </h3> --}}
                        </div>
                        <div class="flex items-center gap-x-2 justify-end ">
                            <button 
                                wire:click="pageDetail({{ $item->id }})"
                                @click="localStorage.setItem('detail', JSON.stringify('true'))"
                                class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                                <span class="mr-1 text-xs hidden md:block">Detail</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                                <div wire:loading wire:target="pageDetail({{ $item->id }})"
                                    class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
                                </div>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
