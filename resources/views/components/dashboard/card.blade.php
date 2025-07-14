  <div class="rounded-lg shadow-md overflow-scroll  bg-white max-w-sm mt-2">
            <div class="p-4">
                <h5 class="text-[#408bdb] font-bold text-xl">INI JUDUL KEGIATANNYA LAH YA</h5>
                <p class="text-gray-400 mt-1">
                    Lalu ini kategori kegiatannya
                </p>
                <p class="text-gray-400 mt-1 text-sm">
                    28 Juni 2045
                </p>
                <button onclick="openModal()"
                    class="inline-flex items-center justify-center mt-5 px-4 py-2 bg-blue-500 text-white rounded-lg w-1/2 text-sm hover:bg-blue-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                    Detail
                </button>
            </div>
        </div>

        <!-- ✅ MODAL OVERLAY -->
        <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden justify-center items-center pt-24 w-full px-5 md:px-0">
            <!-- ✅ MODAL CARD -->
            <div
                class="bg-white w-full max-w-lg rounded-xl shadow-xl p-6 relative animate-slide-down mx-auto">
                <!-- Tombol Tutup -->
                <button onclick="closeModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl font-bold">
                    &times;
                </button>
                <h2 class="text-xl font-bold text-[#326faf] mb-1">INI JUDUL KEGIATANNYA LAH YA</h2>
                <p class="text-gray-400 mt-1">
                    Lalu ini kategori kegiatannya
                </p>
                <p class="text-gray-400 mt-1 text-sm">
                    28 Juni 2045
                </p>
                <span class="bg-red-100 text-red-700 px-4 py-2 rounded-md text-sm mt-2 block text-center">
                    Belum terselesaikan
                </span>
                
                <table class="w-full mt-4 text-blue-700">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left px-4 py-2">KETERANGAN</th>
                            <th class="text-left px-4 py-2">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-2">Kegiatan survei</td>
                            <td class="px-4 py-2">Menanam Sawi</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-2">Jenis periode</td>
                            <td class="px-4 py-2">Tahunan</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    