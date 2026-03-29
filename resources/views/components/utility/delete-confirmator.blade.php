@aware([
    'show' => true,
    'title' => '',
    'description' => '',
])
<div x-transition:enter="transition ease-out duration-300" x-transition:enter-start ="opacity-0 -translate-y-52"
    x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-52"
    @click.outside="{{ $show }} = false" x-show="{{ $show }}"
    class="w-full max-w-md sm:max-w-lg bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-6 text-center">

    <!-- ICON -->
    <div class="mx-auto flex items-center justify-center w-16 h-16 rounded-full bg-red-100 dark:bg-red-500/20 mb-4">
        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
        </svg>
    </div>

    <!-- TITLE -->
    <h3 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-white mb-2">
        {{ $title ?? 'Hapus Data?' }}
    </h3>

    <!-- DESCRIPTION -->
    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
        {!! $description ?? 'Kegiatan Survei Lapangan' !!}


        <br>
        <span class="text-red-500 font-medium">
            Data ini tidak dapat dikembalikan!
        </span>
    </p>

    <!-- BUTTON -->
    <div class="flex flex-col sm:flex-row gap-3 mt-6">

        <!-- CANCEL -->
        <button @click="{{ $show }} = false"
            class="w-full px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-10 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700">
            Batal
        </button>
        
        {{ $action ?? '' }}

    </div>

</div>
