<div>
<div x-init="setTimeout(() => loading = false, 500)">
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

    <!-- ➕ Tombol Tambah Data -->
    <button
      class="inline-flex items-center justify-center w-full md:w-auto px-4 py-2 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600 transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
        stroke-width="1.5" stroke="currentColor">
        <path strokeLinecap="round" strokeLinejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
      </svg>
      <span class=" md:inline ml-2">Tambah </span> 
      <span class="md:hidden ml-2">Kegiatan</span>
    </button>

  </div>
</div>

</div>
         <div class=" mx-auto p-2">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 auto-rows-auto">
        <!-- ✅ CARD UTAMA -->
      
        
        <!-- Duplicate the card as needed -->
    </div>
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