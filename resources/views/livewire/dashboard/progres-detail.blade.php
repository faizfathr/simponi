<div x-data="{ openForm: @entangle('openForm'), idTabel: @entangle('id_tabel'), showNotif: @entangle('showNotif') }">
    <x-dashboard.notification showNotif="showNotif" message="{{ $message }}" status="{{ $status }}"/>
    <div class="flex items-center gap-x-2 mb-2 w-full">
        <button @click="localStorage.setItem('detail', JSON.stringify('false'))" wire:click='back'
            class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
            </svg>
        </button>
        <button wire:click.prevent="openModalForm"
            class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
            <span class="mr-1 text-xs hidden md:block">Tambah Manual</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <div wire:loading wire:target='openModalForm'
                class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
            </div>
        </button>
        <a href="/dashboard/downloadTemplate/{{ $id_tabel }}"
            class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-success-500 shadow-theme-xs hover:bg-success-600">
            <span class="mr-1 text-xs hidden md:block">Template</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
        </a>
        <form wire:submit.prevent='import'>
            <div class="flex gap-x-2 items-center">
                <div
                    class="relative z-0 text-white transition rounded-lg bg-success-500 shadow-theme-xs hover:bg-success-600">
                    <label for="template-input" class="text-xs flex gap-x-2 h-full p-2 cursor-pointer">Import
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                        </svg>
                    </label>
                    <input type="file" wire:model='file'
                        class="w-full h-full absolute top-0 left-0 opacity-0 cursor-pointer">
                </div>
                <div wire:loading wire:target='file'
                    class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-success-500 border-t-transparent">
                </div>
                @if ($file)
                    <span class="font-semibold text-gray-500 text-xs">{{ $file->getClientOriginalName() }}</span>
                    <button
                        class="inline-flex items-center p-2 text-xs font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600"
                        type="submit">Upload</button>
                @endif
            </div>
        </form>
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
                                        No
                                    </p>
                                </div>
                            </th>
                            @foreach ($this->sampel_header as $itemSampel)
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
                                        {{ $event->jadwal }}
                                    </p>
                                </div>
                            </th>
                            @foreach ($this->prosess_header as $itemProses)
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            {{ $itemProses }}
                                        </p>
                                    </div>
                                </th>
                            @endforeach
                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        {{ $event->status }}
                                    </p>
                                </div>
                            </th>
                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        {{ $event->pcl }}
                                    </p>
                                </div>
                            </th>
                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        {{ $event->pml }}
                                    </p>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <!-- table header end -->
                    <!-- table body start -->
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @if ($monitorings)
                            @foreach ($monitorings as $row => $monitoring)
                                <tr>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <div class="flex items-center gap-3">
                                                <div>
                                                    <span
                                                        class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                                        {{ $row + 1 }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    @foreach (explode(';', $monitoring->ket_sampel) as $key => $itemSampelBody)
                                        <td class="px-5 py-4 sm:px-6">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                                {{ $itemSampelBody }}
                                            </p>
                                        </td>
                                    @endforeach
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                            {{ is_null($event->tanggal_mulai) || is_null($event->tanggal_selesai) ? 'Tanggal Belum diatur' : (date('m', strtotime($event->tanggal_mulai)) === date('m', strtotime($event->tanggal_selesai)) ? date('d', strtotime($event->tanggal_mulai)) . date(' - d ', strtotime($event->tanggal_selesai)) . $bulan[(int) date('m', strtotime($event->tanggal_selesai))] . date(' Y', strtotime($event->tanggal_selesai)) : date('d', strtotime($event->tanggal_mulai)) . ' ' . $bulan[(int) date('m', strtotime($event->tanggal_mulai))] . date(' - d ', strtotime($event->tanggal_selesai)) . $bulan[(int) date('m', strtotime($event->tanggal_selesai))] . date(' Y', strtotime($event->tanggal_selesai))) }}
                                        </p>
                                    </td>
                                    @foreach (explode(';', $monitoring->proses) as $key => $itemProsesBody)
                                        <td class="px-5 py-4 sm:px-6">
                                            <div x-data="{ checkboxToggle{{ $monitoring->id }}{{ $key }}: {{ $itemProsesBody === '1' ? 'true' : 'false' }} }">
                                                <label for="checkboxLabel{{ $monitoring->id }}{{ $key }}"
                                                    class="flex justify-center cursor-pointer select-none ">
                                                    <div class="relative">
                                                        <input
                                                            wire:model='monitoring.{{ $monitoring->id }}.prosess.{{ $key }}'
                                                            type="checkbox"
                                                            id="checkboxLabel{{ $monitoring->id }}{{ $key }}"
                                                            class="sr-only"
                                                            :checked='checkboxToggle{{ $monitoring->id }}{{ $key }}'
                                                            @change="checkboxToggle{{ $monitoring->id }}{{ $key }} = !checkboxToggle{{ $monitoring->id }}{{ $key }}" />
                                                        <div :class="checkboxToggle{{ $monitoring->id }}{{ $key }} ?
                                                            'border-brand-500 bg-brand-500' :
                                                            'bg-transparent border-gray-300 dark:border-gray-700'"
                                                            class="hover:border-brand-500 dark:hover:border-brand-500 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]">
                                                            <span
                                                                :class="checkboxToggle{{ $monitoring->id }}{{ $key }} ?
                                                                    '' : 'opacity-0'">
                                                                <svg width="14" height="14"
                                                                    viewBox="0 0 14 14" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7"
                                                                        stroke="white" stroke-width="1.94437"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round" />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </td>
                                    @endforeach
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <p
                                                class="rounded-full px-2 py-0.5 text-xs font-medium {{ $monitoring->status === 0 ? 'bg-gray-50 text-gray-600' : ($monitoring->status === 1 ? 'bg-warning-50 text-orange-600' : 'bg-success-50 text-success-600') }} dark:bg-success-500/15 dark:text-success-500">
                                                {{ $monitoring->status === 0 ? 'Belum Terlaksana' : ($monitoring->status === 1 ? 'On Progres' : 'Selesai') }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                            {{ $monitoring->joinPcl?->nama ?? 'Unknown' }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                                {{ $monitoring->joinPml?->nama ?? 'Unknown' }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <span>Belum ada data untuk dimonitoring</span>
                        @endif

                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <button wire:click.prevent='updateProgres'
        class=" px-3 py-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600 ">
        <span>Simpan</span>
        <div wire:loading wire:target='updateProgres({{ $idPage }})'
            class="absolute right-2 h-4 w-4 animate-spin rounded-full border-2 border-solid border-white border-t-transparent">
        </div>
    </button>
    <div x-show="openForm"
        class="space-y-6 fixed inset-0 flex items-center justify-center bg-black/50 z-50 overflow-scroll scrollbar-hide">
        @livewire('progres.modal-form', ['id' => $idPage])
    </div>
</div>
