<div x-data="{ openForm: @entangle('openForm'), idTabel: @entangle('id_tabel'), showNotif: @entangle('showNotif') }">
    <x-dashboard.notification showNotif="showNotif" message="{{ $message }}" status="{{ $status }}" />
    @if (Auth::user() && intVal(Auth::user()?->id_role) === 3)
        <div class="flex items-center gap-x-2 mb-2 w-full">
            <a href="#" @click.prevent="history.back()"
                class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
            </a>
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
            <a href="/dashboard/downloadDirektori"
                class="inline-flex items-center p-2 text-sm font-medium text-white transition rounded-lg bg-success-500 shadow-theme-xs hover:bg-success-600">
                <span class="mr-1 text-xs hidden md:block">Direktori</span>
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
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4">
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
                            type="submit">Upload
                            <div wire:loading wire:target='import'
                                class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent ml-2">
                            </div>
                        </button>
                    @endif
                </div>
            </form>
        </div>
    @endif
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto custom-scrollbar h-[80vh]">
            @if ($idPage)
                <table class="min-w-full custom-scrollbar h-auto overflow-y-auto">
                    <!-- table header start -->
                    <thead class="sticky top-0 z-10 bg-gray-200">
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-xs dark:text-gray-400">
                                        No
                                    </p>
                                </div>
                            </th>
                            @foreach ($this->sampel_header as $itemSampel)
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center justify-center">
                                        <p class="font-medium text-gray-500 text-xs dark:text-gray-400">
                                            {{ $itemSampel }}
                                        </p>
                                    </div>
                                </th>
                            @endforeach
                            <th class="px-5 py-3 sm:px-6 text-center">
                                <p class="font-medium text-gray-500 text-xs dark:text-gray-400">
                                    Jadwal
                                </p>
                            </th>
                            @foreach ($this->prosess_header as $itemProses)
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center justify-center w-[100%]">
                                        <p class="font-medium text-gray-500 text-xs dark:text-gray-400">
                                            {{ $itemProses }}
                                        </p>
                                    </div>
                                </th>
                            @endforeach
                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-xs dark:text-gray-400">
                                        {{ $event->status }}
                                    </p>
                                </div>
                            </th>
                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-xs dark:text-gray-400">
                                        {{ $event->pcl }}
                                    </p>
                                </div>
                            </th>
                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-xs dark:text-gray-400">
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
                                                <span class="font-medium text-gray-800 text-xs dark:text-white/90">
                                                    {{ $row + 1 }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    @foreach ($allItem[$row]['sampel_body'] as $key => $itemSampelBody)
                                        <td class="px-5 py-4 sm:px-6 whitespace-nowrap">
                                            <input
                                                wire:model='allItem.{{$row}}.sampel_body.{{ $key }}'
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-1 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                        </td>
                                    @endforeach
                                    <td class="px-5 py-4 sm:px-6 whitespace-nowrap">
                                        <p class="text-gray-500 text-xs dark:text-gray-400">
                                            {{ is_null($event->tanggal_mulai) || is_null($event->tanggal_selesai) ? 'Tanggal Belum diatur' : (date('m', strtotime($event->tanggal_mulai)) === date('m', strtotime($event->tanggal_selesai)) ? date('d', strtotime($event->tanggal_mulai)) . date(' - d ', strtotime($event->tanggal_selesai)) . $bulan[(int) date('m', strtotime($event->tanggal_selesai))] . date(' Y', strtotime($event->tanggal_selesai)) : date('d', strtotime($event->tanggal_mulai)) . ' ' . $bulan[(int) date('m', strtotime($event->tanggal_mulai))] . date(' - d ', strtotime($event->tanggal_selesai)) . $bulan[(int) date('m', strtotime($event->tanggal_selesai))] . date(' Y', strtotime($event->tanggal_selesai))) }}
                                        </p>
                                    </td>
                                    @foreach ($allItem[$row]['prosess'] as $key => $itemProsesBody)
                                        <td class="px-5 py-4 sm:px-6">
                                            <div x-data="{ checkboxToggle{{ $monitoring['id'] }}{{ $key }}: {{ $itemProsesBody === '1' ? 'true' : 'false' }} }">
                                                <label for="checkboxLabel{{ $monitoring['id'] }}{{ $key }}"
                                                    class="flex justify-center cursor-pointer select-none ">
                                                    <div class="relative">
                                                        <input
                                                            wire:model='allItem.{{$row}}.prosess.{{ $key }}'
                                                            type="checkbox"
                                                            id="checkboxLabel{{ $monitoring['id'] }}{{ $key }}"
                                                            class="sr-only"
                                                            :checked='checkboxToggle{{ $monitoring['id'] }}{{ $key }}'
                                                            @change="checkboxToggle{{ $monitoring['id'] }}{{ $key }} = !checkboxToggle{{ $monitoring['id'] }}{{ $key }}" />
                                                        <div :class="checkboxToggle{{ $monitoring['id'] }}{{ $key }} ?
                                                            'border-brand-500 bg-brand-500' :
                                                            'bg-transparent border-gray-300 dark:border-gray-700'"
                                                            class="hover:border-brand-500 dark:hover:border-brand-500 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]">
                                                            <span
                                                                :class="checkboxToggle{{ $monitoring['id'] }}{{ $key }}
                                                                    ?
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
                                                class="rounded-full px-2 py-0.5 text-xs font-medium {{ $allItem[$row]['status'] === 0 ? 'bg-gray-50 text-gray-600' : ($allItem[$row]['status'] === 1 ? 'bg-warning-50 text-orange-600' : 'bg-success-50 text-success-600') }} dark:bg-success-500/15 dark:text-success-500">
                                                {{ $allItem[$row]['status'] === 0 ? 'Belum Terlaksana' : ($allItem[$row]['status'] === 1 ? 'On Progres' : 'Selesai') }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <select wire:model='allItem.{{ $row }}.pcl'
                                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                            :class="isOptionKegiatan && 'text-gray-800 dark:text-white/90'"
                                            @change="isOptionKegiatan = true">
                                            <option
                                                class="text-gray-700 dark:bg-gray-900 dark:text-gray-400 hidden text-center">
                                                --- Petugas ---
                                            </option>
                                            @foreach ($pcl as $key => $p)
                                                <option value="{{ $p->id }}"
                                                    class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                    {{ $p->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <select wire:model='allItem.{{ $row }}.pml'
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                                :class="isOptionKegiatan && 'text-gray-800 dark:text-white/90'"
                                                @change="isOptionKegiatan = true">
                                                <option
                                                    class="text-gray-700 dark:bg-gray-900 dark:text-gray-400 hidden text-center">
                                                    --- Petugas ---
                                                </option>
                                                @foreach ($pml as $key => $p)
                                                    <option value="{{ $p->id }}"
                                                        class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                        {{ $p->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                    <span class="font-medium text-gray-500 text-xs dark:text-gray-400">Belum ada data
                                        untuk dimonitoring</span>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <button wire:click.prevent='updateProgres'
        class=" px-3 py-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex gap-x-2 items-center">
        <span>Simpan</span>
        <div wire:loading wire:target='updateProgres'
            class="h-4 w-4 animate-spin rounded-full border-2 border-solid border-white border-t-transparent">
        </div>
    </button>
    <div x-show="openForm"
        class="space-y-6 fixed inset-0 flex items-center justify-center bg-black/50 z-50 overflow-scroll scrollbar-hide">
        @livewire('progres.modal-form', ['id' => $idPage])
    </div>
</div>
