    <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6"  x-init="setTimeout(() => loading = false, 500)">
    <div class="flex justify-between items-center mb-4">
        
        <h2 class="text-xl font-semibold text-slate-700 dark:text-gray-100">Petugas</h2>
        
        <div class="flex items-center gap-2">
            <input  wire:model.live.debounce.500ms='search' type="text" placeholder="Cari..." class="p-2 rounded-md bg-gray-100 text-gray-800 focus:ring-2 focus:ring-brand-500">
            <button class="bg-green-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-green-600 flex items-center gap-2" wire:click='tambahForm'>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah
            </button>
        </div>
    </div>
         {{-- <!-- Modal Tambah/Edit Petugas -->
    <div x-show="openForm"
        class="fixed pt-24 md:pt-0 inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        style="overflow-y: auto;">
        <div @click.outside="openForm = !openForm"
            class="bg-white rounded-2xl shadow-xl w-full max-w-3xl mt-20 md:my-16 p-6 md:p-8">
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800 mb-6">
                {{ $action === 'Edit' ? 'Edit Petugas' : 'Tambah Petugas' }}
            </h2>

            <form wire:submit.prevent="simpan" 
                class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">
                <input type="hidden" wire:model.lazy="action">
                <input type="hidden" wire:model="id">
                @foreach ([['label' => 'Nama', 'model' => 'nama', 'type' => 'text'], ['label' => 'No. Rekening', 'model' => 'no_rek', 'type' => 'text'], ['label' => 'Status', 'model' => 'status', 'type' => 'text']] as $field)
                <div class="flex flex-col">
                    <label for="{{ $field['model'] }}" class="block font-medium mb-1 text-sm">
                        {{ $field['label'] }}
                    </label>
                    <input
                        type="{{ $field['type'] }}"
                        wire:model="{{ $field['model'] }}">
                </div>
                @endforeach --}}
                      
    <table class="w-full text-left text-gray-800 dark:text-gray-300 overflow-scroll">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="py-3 px-4">ID Petugas</th>
                <th class="py-3 px-4">Nama</th>
                <th class="py-3 px-4">No. Rekening</th>
                <th class="py-3 px-4">Status</th>
                <th class="py-3 px-4">Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listPetugas as $item)
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="py-2 px-4">{{ $item->id }}</td>
                <td class="py-2 px-4">{{ $item->nama }}</td>
                <td class="py-2 px-4">{{ $item->no_rek }}</td>
                <td class="py-2 px-4">{{ $item->status === 0 ? 'Pegawai' : 'Kemitraan'}}</td>
                <td class="py-2 px-4">-</td>
            </tr>
             @endforeach
          
        </tbody>
    </table>
</div>

