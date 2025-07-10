<div>
<div x-init="setTimeout(() => loading = false, 500)"x-data="{
    openForm: @entangle('openForm'),
    action: @entangle('action'),
    openWarningDelete: @entangle('openWarningDelete'),
    showNotif: @entangle('showNotif')
}">
   <!-- Container utama -->
<div class="w-full max-w-3xl mb-2 px-4">
  <div class="flex flex-col md:flex-row md:items-center gap-4">

    <!-- 🔍 Input Pencarian -->
    <div class="relative w-full">
      <span class="absolute top-1/2 left-4 -translate-y-1/2">
        <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20"
          fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fillRule="evenodd" clipRule="evenodd"
            d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z" />
        </svg>
      </span>

      <input type="text" placeholder="Cari kegiatan..."
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
<div class="overflow-x-auto">
    <table class="table w-full">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs leading-4  text-gray-500 dark:text-gray-300 uppercase tracking-wider text-md font-bold">
                    Kegiatan Survei
                </th>
                <th class="px-6 py-3 text-left text-xs leading-4  text-gray-500 dark:text-gray-300 uppercase tracking-wider font-bold text-md">
                    Kategori
                </th>
                <th class="px-6 py-3 text-left text-xs leading-4 font-bold text-md text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Jenis Periode
                </th>
                <th class="px-6 py-3  text-xs leading-4 font-bold text-md text-gray-500 dark:text-gray-300 uppercase tracking-wider text-center">
                    Status
                </th>
                <th class="px-6 py-3">  <!-- ➕ Tombol Tambah Data -->
                      @if (Auth::user() && intVal(Auth::user()?->id_role) === 3)
    <button
      class="inline-flex items-center justify-center w-full md:w-auto px-4 py-2 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600 transition "wire:click='tambahForm'>
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
        stroke-width="1.5" stroke="currentColor">
        <path strokeLinecap="round" strokeLinejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
      </svg>
      <span class=" md:inline ml-2">Tambah </span> 
      <span class="md:hidden ml-2">Kegiatan</span>
         <div wire:loading wire:target='tambahForm'
                    class="h-3 w-3 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
                </div>
    </button>
  
  @endif
    
</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800">
            @foreach ($kegiatanSurvei as $e)
                  <tr>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-600 border-gray-200 dark:border-gray-600 font-bold text-md">
                    {{ $e->kegiatan }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-b  text-blue-600 border-gray-200 dark:border-gray-600">
                    {{ $e->alias }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-b  text-blue-600 border-gray-200 dark:border-gray-600">
                    {{ $e->created_at }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-red-800 bg-red-200 text-center text-md border-gray-200 dark:border-gray-600">
                    Belum diselesaikan
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-600 border-gray-200 dark:border-gray-600">
                    <button
                        class="inline-flex items-center justify-center px-2 py-1 border border-transparent rounded-full shadow-sm text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                        <p class="ml-1">Detail</p>
                    </button>
                </td>
            </tr>
            @endforeach
          
        </tbody>
    </table>
</div>

<!-- ✅ ANIMASI SLIDE DOWN -->
<style>
    @keyframes slideDown {
        0% {
            transform: translateY(-30px);
            opacity: 0;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }
    .animate-slide-down {
        animation: slideDown 0.3s ease-out;
    }
</style>

<!-- ✅ SCRIPT -->
<script>
    function openModal() {
        document.getElementById('modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }
</script>

    </div>
</div>

</div>