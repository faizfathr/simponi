<div class="h-[85vh] flex flex-col items-center justify-center bg-white dark:bg-gray-900 text-center px-6" x-init="setTimeout(()=>loading=false, 500)">
    {{-- Ilustrasi SVG bawaan --}}
    <div class="w-72 sm:w-96 mb-8">
        <svg viewBox="0 0 1024 1024" class="w-full h-auto" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64z" fill="#F2F2F2"/>
            <path d="M384 320h256v64H384v-64zm-32 128h320v64H352v-64zm64 128h192v64H416v-64z" fill="#FFA500"/>
            <circle cx="512" cy="512" r="480" stroke="#FFA500" stroke-width="16" stroke-dasharray="40 40"/>
        </svg>
    </div>

    <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 dark:text-white mb-4">
        Halaman Sedang Dikembangkan
    </h1>

    <p class="text-gray-600 dark:text-gray-300 text-base sm:text-lg mb-6">
        Kami sedang bekerja untuk menyempurnakan fitur ini. Mohon ditunggu ya!
    </p>

    <a href="{{ route('home') }}" class="inline-block px-6 py-3 text-white bg-orange-500 hover:bg-orange-600 rounded-lg text-sm font-medium transition">
        Kembali ke Beranda
    </a>
</div>