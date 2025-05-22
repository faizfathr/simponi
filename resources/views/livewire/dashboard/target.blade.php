<div x-data="{
    openForm: @entangle('openForm'),
    action: @entangle('action'),
    openWarningDelete: @entangle('openWarningDelete'),
    showNotif: @entangle('showNotif')
}">
    {{-- <div class=" w-[100%] inset-0 bg-slate-500 h-[100vh]"></div> --}}
    <div class="flex gap-x-2 items-center mb-3">
        <button
            class="inline-flex items-center gap-2 px-3 py-2.5 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600"
            wire:click='tambahForm'>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Kegiatan
            <div wire:loading wire:target='tambahForm'
                class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
            </div>
        </button>
        <div class="relative z-0">
            <span class="absolute top-1/2 left-4 -translate-y-1/2">
                <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"
                        fill="" />
                </svg>
            </span>
            <input type="text" placeholder="Cari kegiatan..." wire:model.live.debounce.250ms='qSearch'
                class="dark:bg-dark-900 shadow-theme-xs bg-white focus:border-brand-600 focus:ring-brand-500/10 dark:focus:border-brand-600 h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden xl:w-[430px] dark:border-gray-800 dark:bg-gray-900 dark:bg-white/[0.03] dark:text-white/90 dark:placeholder:text-white/30" />

            <button id="search-button"
                class="absolute top-1/2 right-2.5 inline-flex -translate-y-1/2 items-center gap-0.5 rounded-lg border border-gray-200 bg-gray-50 px-[7px] py-[4.5px] text-xs -tracking-[0.2px] text-gray-500 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400">
                <span> ⌘ </span>
                <span> K </span>
            </button>
        </div>
    </div>
    <div
        class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">

        <x-dashboard.notification showNotif="showNotif" message="{{ $message }}" status="{{ $status }}" />

        <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    List Kegiatan
                </h3>
            </div>

            <div class="flex items-center gap-3">
                <button
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                    <svg class="stroke-current fill-white dark:fill-gray-800" width="20" height="20"
                        viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.29004 5.90393H17.7067" stroke="" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M17.7075 14.0961H2.29085" stroke="" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M12.0826 3.33331C13.5024 3.33331 14.6534 4.48431 14.6534 5.90414C14.6534 7.32398 13.5024 8.47498 12.0826 8.47498C10.6627 8.47498 9.51172 7.32398 9.51172 5.90415C9.51172 4.48432 10.6627 3.33331 12.0826 3.33331Z"
                            fill="" stroke="" stroke-width="1.5" />
                        <path
                            d="M7.91745 11.525C6.49762 11.525 5.34662 12.676 5.34662 14.0959C5.34661 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0959C10.4883 12.676 9.33728 11.525 7.91745 11.525Z"
                            fill="" stroke="" stroke-width="1.5" />
                    </svg>

                    Filter
                </button>

                <button
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                    See all
                </button>
            </div>
        </div>

        <div class="w-full overflow-x-auto h-[60vh]">
            <table class="min-w-full">
                <!-- table header start -->
                <thead>
                    <tr class="border-gray-100 border-y dark:border-gray-800">
                        <th class="py-3">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Survei
                                </p>
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Tahun
                                </p>
                            </div>
                        </th class="py-3">
                        <th class="py-3">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Periode
                                </p>
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="flex items-center col-span-2">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Target
                                </p>
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="flex items-center col-span-2">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Status
                                </p>
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="flex items-center col-span-2">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Aksi
                                </p>
                            </div>
                        </th>
                    </tr>
                </thead>
                <!-- table header end -->

                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @if (!$listTarget->isEmpty())
                        @foreach ($listTarget as $item)
                            <tr>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <div class="flex items-center gap-3">
                                            <div>
                                                <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                                    {{ $item->joinKegiatan->kegiatan }}
                                                </p>
                                                <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                                    {{ $item->joinKegiatan->sektor == 1 ? 'Pertanian' : 'IPEK' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                            {{ $item->tahun }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                            {{ $item->periode == 1
                                                ? $this->listBulan[$item->waktu - 1]
                                                : ($item->periode == 2 || $item->periode == 3
                                                    ? $this->ketPeriode[$item->periode - 1] . ' ' . $this->romawiFont[$item->waktu - 1]
                                                    : 'Tahunan') }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                            {{ $item->target }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <p
                                            class="rounded-full {{ is_null($item->tanggal_mulai) ? 'bg-brand-50' : (now() < $item->tanggal_mulai ? 'bg-red-500 text-white' : (now() > $item->tanggal_selesai ? 'bg-success-50 text-success-600' : 'bg-yellow-400 text-yellow-100')) }} px-2 py-0.5 text-theme-xs font-medium  text-xs dark:bg-success-500/15 dark:text-success-500">
                                            {{ is_null($item->tanggal_mulai) ? 'Tanggal belum diatur' : (now() < $item->tanggal_mulai ? 'Kegiatan belum dimulai' : (now() > $item->tanggal_selesai ? 'Kegiatan selesai' : 'Sedang berjalan')) }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center gap-2">
                                        <button wire:click='edit({{ $item->id }}, "update")'
                                            class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-orange-400 shadow-theme-xs hover:bg-orange-600 mb-3">
                                            <svg wire:loading.remove wire:target='edit({{ $item->id }}, "update")'
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                            <div wire:loading wire:target='edit({{ $item->id }}, "update")'
                                                class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
                                            </div>
                                        </button>
                                        <button wire:click="confirmDelete({{ $item->id }})"
                                            class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-red-400 shadow-theme-xs hover:bg-red-600 mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-4" wire:loading.remove
                                                wire:target="confirmDelete({{ $item->id }})">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                            <div wire:loading wire:target="confirmDelete({{ $item->id }})"
                                                class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
                                            </div>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                Kegiatan tidak ditemukan
                            </td>
                        </tr>
                    @endif

                    <!-- table body end -->
                </tbody>
            </table>
        </div>
        @if (!$qSearch)
            <div class="my-2 mr-1">
                {{ $listTarget->links() }}
            </div>
        @endif
    </div>
    <!-- Modal Form -->
    <div x-show="openForm"
        class="space-y-6 fixed inset-0 flex items-center justify-center bg-black/50 z-50 overflow-scroll scrollbar-hide">
        <form wire:submit.prevent='submitForm' x-show="openForm"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start ="opacity-0 -translate-y-52" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-52"
            class="w-2/3 rounded-2xl border absolute top-5 border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
            @click.outside="openForm=!openForm">
            <div class="px-5 py-4 sm:px-5 sm:py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Kegiatan Termonitoring
                </h3>
            </div>
            <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                <!-- Elements Survei -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Kegiatan Survei
                    </label>
                    <div x-data="{ isOptionKegiatan: false }" class="relative z-20 bg-transparent">
                        <select wire:model='id_kegiatan'
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="isOptionKegiatan && 'text-gray-800 dark:text-white/90'"
                            @change="isOptionKegiatan = true">
                            <option class="text-gray-700 dark:bg-gray-900 dark:text-gray-400 hidden text-center">
                                --- Pilih Survei ---
                            </option>
                            @foreach ($listKegiatan as $item)
                                <option value="{{ $item->id }}"
                                    class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                    {{ $item->kegiatan }}
                                </option>
                            @endforeach
                        </select>
                        <span
                            class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke=""
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Elements Survei -->

                <!-- Elements -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Tahun
                    </label>
                    <input type="number" wire:model='tahun'
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                </div>

                <!-- Elements -->
                <div class="flex gap-4">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Tanggal Mulai Kegiatan
                        </label>
                        <input type="date" wire:model='tanggal_mulai'
                            class="w-full rounded-lg border border-gray-300 bg-white py-2.5 px-4 text-sm font-medium text-gray-700 shadow-theme-xs focus:outline-hidden focus:ring-0 focus-visible:outline-hidden dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                            placeholder="Select dates" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Tanggal Selesai Kegiatan
                        </label>
                        <input type="date" wire:model='tanggal_selesai'
                            class="w-full rounded-lg border border-gray-300 bg-white py-2.5 px-4 text-sm font-medium text-gray-700 shadow-theme-xs focus:outline-hidden focus:ring-0 focus-visible:outline-hidden dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                            placeholder="Select dates" />
                    </div>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Target Kegiatan
                    </label>
                    <input wire:model='target' type="number"
                        placeholder="target dapat diatur setelah kegiatan dibentuk"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                </div>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600 active:bg-brand-500/50">
                    {{ $this->action }} Kegiatan
                    <div wire:loading
                        class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
                    </div>
                </button>
                <button type="button" @click="openForm = false"
                    class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                    batal
                </button>
            </div>
        </form>
    </div>
    <!-- Modal Form -->

    <!-- Delete Confirmator -->
    <div x-show="openWarningDelete"
        class="space-y-6 fixed inset-0 flex items-center justify-center bg-black/50 z-50 overflow-scroll scrollbar-hide">
        <div x-show="openWarningDelete" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start ="opacity-0 -translate-y-52" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-52"
            @click.outside = "openWarningDelete = !openWarningDelete"
            class="rounded-xl border border-warning-500 bg-warning-50 p-4 dark:border-warning-500/30 dark:bg-warning-500/15">
            <div class="flex items-start gap-3">
                <div class="-mt-0.5 text-warning-500 dark:text-orange-400">
                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M3.6501 12.0001C3.6501 7.38852 7.38852 3.6501 12.0001 3.6501C16.6117 3.6501 20.3501 7.38852 20.3501 12.0001C20.3501 16.6117 16.6117 20.3501 12.0001 20.3501C7.38852 20.3501 3.6501 16.6117 3.6501 12.0001ZM12.0001 1.8501C6.39441 1.8501 1.8501 6.39441 1.8501 12.0001C1.8501 17.6058 6.39441 22.1501 12.0001 22.1501C17.6058 22.1501 22.1501 17.6058 22.1501 12.0001C22.1501 6.39441 17.6058 1.8501 12.0001 1.8501ZM10.9992 7.52517C10.9992 8.07746 11.4469 8.52517 11.9992 8.52517H12.0002C12.5525 8.52517 13.0002 8.07746 13.0002 7.52517C13.0002 6.97289 12.5525 6.52517 12.0002 6.52517H11.9992C11.4469 6.52517 10.9992 6.97289 10.9992 7.52517ZM12.0002 17.3715C11.586 17.3715 11.2502 17.0357 11.2502 16.6215V10.945C11.2502 10.5308 11.586 10.195 12.0002 10.195C12.4144 10.195 12.7502 10.5308 12.7502 10.945V16.6215C12.7502 17.0357 12.4144 17.3715 12.0002 17.3715Z"
                            fill="" />
                    </svg>
                </div>

                <div>
                    <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                        Perhatian, anda akan menghapus kegiatan secara <b>Permanen</b>
                    </h4>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        anda akan menghapus {{ $this->kegiatan ?? '' }} di {{ $this->periode ?? '' }}
                        {{ $this->ketWaktu ?? '' }} ?
                    </p>
                    <div class="flex gap-x-2 mt-2">
                        <button wire:click="delete('{{ $this->id }}')"
                            class="inline-flex items-center gap-2 px-4 py-1 text-sm font-medium text-white transition rounded-lg bg-red-500 shadow-theme-xs hover:bg-red-600 active:bg-red-500/50">
                            Hapus
                            <div wire:loading wire:target="delete('{{ $this->id }}')"
                                class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
                            </div>
                        </button>
                        <button @click="openWarningDelete = false" wire:prevent
                            class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-1 text-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                            batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Confirmator -->

</div>
