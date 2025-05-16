<form wire:submit.prevent="" x-show="openForm" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start ="opacity-0 -translate-y-52" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-52"
    class="rounded-2xl border absolute top-5 border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
    @click.outside="openForm=!openForm">
    <div class="inline-flex gap-x-2 items-center py-4">
        <div class="px-2 py-2">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                Pelaksanaan Lapangan
            </h3>
        </div>
        <button wire:click.prevent="minRow"
            class=" px-3 py-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600 ">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
            </svg>
            <div wire:loading wire:target='minRow'
                class="absolute right-2 h-4 w-4 animate-spin rounded-full border-2 border-solid border-white border-t-transparent">
            </div>
        </button>
        <span>{{ $counterRow }}</span>
        <button wire:click.prevent="addRow"
            class=" px-3 py-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600 ">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <div wire:loading wire:target='addRow'
                class="absolute right-2 h-4 w-4 animate-spin rounded-full border-2 border-solid border-white border-t-transparent">
            </div>
        </button>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto custom-scrollbar h-[472px]">
            @if ($idPage)
                <table class="min-w-full custom-scrollbar h-auto overflow-y-auto">
                    <!-- table header start -->
                    <thead class="sticky top-0 z-10 bg-gray-200">
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        {{ $table->no }}
                                    </p>
                                </div>
                            </th>
                            @foreach ($this->sampel as $itemSampel)
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            {{ $itemSampel }}
                                        </p>
                                    </div>
                                </th>
                            @endforeach
                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        {{ $table->jadwal }}
                                    </p>
                                </div>
                            </th>
                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        {{ $table->pcl }}
                                    </p>
                                </div>
                            </th>
                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        {{ $table->pml }}
                                    </p>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <!-- table header end -->
                    <!-- table body start -->
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @if (!is_null($monitoring) || $counterRow > 0)
                            @for ($row = 1; $row <= $counterRow; $row++)
                                <tr>
                                    <td>
                                        <span class="font-medium input">{{ $row }}</span>
                                    </td>
                                    @foreach ($this->sampel as $key => $itemSampel)
                                        <td class="mx-1">
                                            <input wire:model='rows.{{ $row }}.sampel.{{ $key }}'
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                        </td>
                                    @endforeach
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                            {{ $table->tanggal_mulai->format('d') }} -
                                            {{ $table->tanggal_selesai->format('d M Y') }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-2">
                                        <div x-data="{ isOptionKegiatan: false }" class="relative z-20 bg-transparent">
                                            <select wire:model='rows.{{ $row }}.pcl'
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                                :class="isOptionKegiatan && 'text-gray-800 dark:text-white/90'"
                                                @change="isOptionKegiatan = true">
                                                <option
                                                    class="text-gray-700 dark:bg-gray-900 dark:text-gray-400 hidden text-center">
                                                    --- Petugas ---
                                                </option>
                                                @foreach ($pcl as $key => $item)
                                                    <option value="{{ $item->id }}"
                                                        class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                        {{ $item->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span
                                                class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                                <svg class="stroke-current" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"
                                                        stroke="" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 sm:px-2">
                                        <div x-data="{ isOptionKegiatan: false }" class="relative z-20 bg-transparent">
                                            <select wire:model='rows.{{ $row }}.pml'
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                                :class="isOptionKegiatan && 'text-gray-800 dark:text-white/90'"
                                                @change="isOptionKegiatan = true">
                                                <option
                                                    class="text-gray-700 dark:bg-gray-900 dark:text-gray-400 hidden text-center">
                                                    --- Pengawas ---
                                                </option>
                                                @foreach ($pml as $key => $item)
                                                    <option value="{{ $item->id }}"
                                                        class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                        {{ $item->nama }}
                                                    </span>
                                                @endforeach
                                            </select>
                                            <span
                                                class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                                <svg class="stroke-current" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"
                                                        stroke="" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        @else
                            <tr>
                                <td colspan="{{ 5 + count($sampel) + count($prosess) }}"
                                    class="text-center py-4 text-gray-500">
                                    belum ada data untuk dimonitoring
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            @endif
        </div>
        <button wire:click.prevent='save'
            class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
            <span>Simpan</span>
            <div wire:loading wire:target='save'
                class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
            </div>
        </button>
    </div>
</form>
