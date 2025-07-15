<div
  x-data="{
    openForm: $wire.entangle('openForm'),
    action: $wire.entangle('action'),
    openWarningDelete: $wire.entangle('openWarningDelete'),
    showNotif: $wire.entangle('showNotif'),
    showDetail: $wire.entangle('showDetail'),
  }"
  x-init="setTimeout(() => loading = false, 500)"
>

    <div >

        <!-- Container utama -->
          <x-dashboard.notification showNotif="showNotif" message="{{ $message }}" status="{{ $status }}" />

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
        <div class="w-full max-w-3xl mb-2">
            <div class="flex flex-col md:flex-row md:items-center gap-4">

                <!-- 🔍 Input Pencarian -->
          <!-- Ubah bagian ini -->
<div class="relative w-full md:w-2/3 max-w-lg">

                    <span class="absolute top-1/2 left-4 -translate-y-1/2">
                        <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z" />
                        </svg>
                    </span>

                    <!-- 💡 Tambahan: wire:model tetap tanpa ubah style -->
                    <input type="text" wire:model.live.debounce.500ms='search' placeholder="Cari kegiatan..."
                        class="h-11 w-full rounded-lg border border-gray-200 bg-white py-2.5 pr-20 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300" />

                    <!-- ⌘K badge -->
                    <div
                        class="absolute top-1/2 right-4 -translate-y-1/2 flex items-center gap-0.5 text-xs text-gray-500 bg-gray-50 border border-gray-200 px-[6px] py-[2px] rounded-md">
                        <span>⌘</span><span>K</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="overflow-x-scroll">
        <table class="table w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-6 text-left text-xs leading-4  text-gray-500 dark:text-gray-300 uppercase tracking-wider text-md font-bold">
                        Kegiatan Survei
                    </th>
                    <th
                        class="px-6 text-left text-xs leading-4  text-gray-500 dark:text-gray-300 uppercase tracking-wider font-bold text-md">
                        Alias
                    </th>
                    <th
                        class="px-6 text-left text-xs leading-4 font-bold text-md text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Jenis Periode
                    </th>
                    <th class="px-6"> <!-- ➕ Tombol Tambah Data -->
                        @if (Auth::user() && intVal(Auth::user()?->id_role) === 3)
                            <button
                                class="inline-flex items-center justify-center w-full md:w-auto px-4 py-2 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600 transition " wire:click="tambahForm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span class=" md:inline ml-2">Tambah </span>

                                <div wire:loading wire:target="tambahForm"
                                    class="h-3 w-3 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
                                </div>
                            </button>
                        @endif
                        <!-- Modal Tambah/Edit Kegiatan -->
                        <div x-show="openForm"
                            class="fixed pt-24 md:pt-0 inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4"
                            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            style="overflow-y: auto;">
                            <div @click.outside="openForm = !openForm"
                                class="bg-white rounded-2xl shadow-xl w-full max-w-3xl mt-20 md:my-16 p-6 md:p-8">
                                <h2 class="text-xl md:text-2xl font-semibold text-gray-800 mb-6">
                                    {{ $action === 'Edit' ? 'Edit Kegiatan' : 'Tambah Kegiatan' }}
                                </h2>

                        <form wire:submit.prevent="simpan" class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700"   @click.outside="openForm = false">

                                @foreach ([['label' => 'Nama Kegiatan', 'model' => 'kegiatan', 'type' => 'text'], ['label' => 'Alias', 'model' => 'alias', 'type' => 'text'], ['label' => 'Subsektor', 'model' => 'subsektor', 'type' => 'number']] as $field)
    <div class="flex flex-col">
        <label for="{{ $field['model'] }}" class="block font-medium mb-1 text-sm">
            {{ $field['label'] }}
        </label>
        <input
            type="{{ $field['type'] }}"
            wire:model="{{ $field['model'] }}"
            id="{{ $field['model'] }}"
            name="{{ $field['model'] }}"
            class="w-full rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-600/50 shadow-sm bg-white ring-1 ring-gray-200 p-2 text-sm" />
        @error($field['model'])
            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
        @enderror
    </div>
@endforeach

                                    <!-- Periode -->
                                    <div class="flex flex-col">
                                        <label class="block font-medium mb-1 text-sm">Periode</label>
                                        <select wire:model="periode"
                                            class="w-full rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-600/50 shadow-sm bg-white ring-1 ring-gray-200 p-2 text-sm">
                                            <option value="">-- Pilih Periode --</option>
                                            @foreach (['Bulanan', 'Triwulan', 'Subround', 'Tahun'] as $i => $periode)
                                                <option value="{{ $i + 1 }}">{{ $periode }}</option>
                                            @endforeach
                                        </select>
                                        @error('periode')
                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- Subsektor -->
                                    <div class="flex flex-col">
                                        <label class="block font-medium mb-1 text-sm">Sektor</label>
                                        <select wire:model="sektor"
                                            class="w-full rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-600/50 shadow-sm bg-white ring-1 ring-gray-200 p-2 text-sm">
                                            <option value="">-- Pilih Sektor --</option>
                                            <option value="1">Pertanian</option>
                                            <option value="2">IPEK</option>
                                        </select>
                                        @error('periode')
                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </form>

                                <!-- Tombol aksi -->
                                <div class="flex justify-end mt-8 space-x-3">
                                    <button wire:click="simpan" type="submit" @click="openForm = false"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition shadow-sm">
                                        {{ $action === 'Edit' ? 'Update' : 'Simpan' }}
                                    </button>
                                    <button wire:click="$set('openForm', false)"
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-medium transition shadow-sm" @click="openForm = false">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800">
                @foreach ($kegiatanSurvei as $e)
                    <tr>
                        <td
                            class="px-6 whitespace-no-wrap border-b text-gray-700 border-gray-200 dark:border-gray-600 font-bold text-md">
                            {{ $e->kegiatan }}
                        </td>
                        <td
                            class="px-6 whitespace-no-wrap border-b  text-gray-700 border-gray-200 dark:border-gray-600">
                            {{ $e->alias }}
                        </td>
                        <td
                            class="px-6 whitespace-no-wrap border-b  text-gray-700 border-gray-200 dark:border-gray-600">
                            {{ $e->periode === 1 ? 'Bulanan' : ($e->periode === 2 ? 'Triwulan' : ($e->periode === 3 ? 'Subround' : 'Tahun')) }}
                        </td>
                        <td
                            class="px-6 whitespace-no-wrap border-b text-gray-700 border-gray-200 dark:border-gray-600">
                            <button wire:click="lihatDetail('{{ $e->id }}')"
                                class="inline-flex items-center justify-center px-2 py-0.5 border border-transparent rounded-full shadow-sm text-xs font-medium text-white bg-brand-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                                <p class="ml-1">Detail</p>
                            </button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($showDetail && $selectedKegiatan)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
            wire:click="$set('showDetail', false)"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <div class="bg-gray-100 rounded-2xl shadow-2xl w-full max-w-lg relative p-6 border border-gray-300">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100">
                    <div>
                        <h2 class="text-2xl font-semibold text-blue-800 mb-2">{{ $selectedKegiatan->kegiatan }}</h2>
                        <p class="text-sm text-gray-300 mb-4"><strong>ID:</strong> {{ $selectedKegiatan->id }}</p>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 gap-6 mt-4 h-96 overflow-y-auto">
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold mb-2 text-blue-800 border-b">Detail Kegiatan</h3>
                        <ul class="text-sm space-y-2 text-gray-600">
                            <li class="mb-2"><strong>Alias:</strong> {{ $selectedKegiatan->alias }}</li>
                            <li class="mb-2"><strong>Sektor:</strong>
                                {{ $selectedKegiatan->sektor === 1 ? 'Pertanian' : 'IPEK' }}</li>
                            <li class="mb-2"><strong>Subsektor:</strong> {{ $selectedKegiatan->subsektor }}</li>
                            <li class="mb-2"><strong>Periode:</strong>
                                {{ $selectedKegiatan->periode === 1 ? 'Bulanan' : ($selectedKegiatan->periode === 2 ? 'Triwulan' : ($selectedKegiatan->periode === 3 ? 'Subround' : 'Tahun')) }}
                            </li>
                            <li class="mb-2"><strong>Dibuat:</strong> {{ $selectedKegiatan->created_at }}</li>
                            <li class="mb-2"><strong>Diupdate:</strong> {{ $selectedKegiatan->updated_at }}</li>
                        </ul>
                        <div class="flex-row ">
                            <div class="flex gap-5 mt-4">
                                <button wire:click="editKegiatan('{{ $selectedKegiatan->id }}')"
                                    class="inline-flex items-center px-4 py-2 bg-orange-400 hover:bg-orange-500 text-white rounded-lg text-sm font-medium transition shadow-sm" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0L9 13zm-6 6h6" />
                                    </svg>
                                    Edit
                                </button>
                                <button wire:click="confirmDelete('{{ $selectedKegiatan->id }}')"
                                    class="inline-flex items-center px-4 py-2 bg-red-400 hover:bg-red-500 text-white rounded-lg text-sm font-medium transition shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </div>
                        <button wire:click="$set('showDetail', false)"
                            class="mt-6 px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white rounded-lg text-sm font-medium transition shadow-sm">
                            Keluar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
