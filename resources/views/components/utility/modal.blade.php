<div x-data="{ open: false }">
    <div x-show="open"
        class="space-y-6 fixed inset-0 flex items-center justify-center bg-black/50 z-50 overflow-scroll scrollbar-hide">
        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start ="opacity-0 -translate-y-52" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-52"
            class=" md:w-2/3 rounded-2xl border absolute top-5 border-gray-200 dark:border-gray-800 dark:bg-slate-800 bg-white w-full max-w-lg shadow-lg p-6 space-y-4"
            @click.outside="open=!open">
            
            {{ $slot }}
    
        </div>
    </div>
</div>