<div x-data="{
    strukturTabel: @js($struktur) ?? [],
    newKetSampel: null,
    newKetProses: null,
    addBtn(target, fieldTarget) {
        if (target && target.trim() !== '') {
            if (this.strukturTabel[fieldTarget] && this.strukturTabel[fieldTarget].trim() !== '') {
                this.strukturTabel[fieldTarget] += ';' + target.trim();
            } else {
                this.strukturTabel[fieldTarget] = target.trim();
            }
            this.newKetSampel = null;
            this.newKetProses = null;
        }
    },
    removeSampel(item, fieldTarget) {
        let ketArray = this.strukturTabel[fieldTarget].split(';');
        ketArray = ketArray.filter(ket => ket !== item);
        this.strukturTabel[fieldTarget] = ketArray.join(';');
    },
    async simpan() {
        @this.strukturTabel = this.strukturTabel;
        await @this.simpan();
    },
}" x-init="setTimeout(() => loading = false, 500)">
    {{-- The Master doesn't talk, he acts. --}}
    <div class="bg-slate-100 min-h-screen text-gray-800 dark:bg-gray-900 dark:text-gray-100">
        <h1 class="text-3xl font-semibold mb-6 text-slate-600 dark:text-white">Manajemen Struktur Tabel Monitoring</h1>

        <!-- Daftar data utama -->
        <div class="space-y-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex flex-col lg:flex-row lg:justify-between text-start mb-2 lg:items-center items-start">
                    <h2 class="font-semibold text-lg">
                        Survei: <span x-text="strukturTabel.kegiatan"></span>
                    </h2>
                    <p class="text-sm text-gray-500" x-text="'ID #' + strukturTabel.id"></p>
                </div>


                <!-- Struktur Keterangan Sampel -->
                <div class="my-2">
                    <span class="font-medium my-1">Keterangan Sampel:</span>
                    <div class="flex lg:gap-x-4 gap-x-1">
                        <input x-model="newKetSampel" type="text" placeholder="Masukkan keterangan baru..."
                            class="w-full outline-none border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                            @keyup.enter="addBtn(newKetSampel, 'ket_sampel')" />
                        <button @click="addBtn(newKetSampel, 'ket_sampel')"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg shadow-sm text-sm flex items-center gap-2 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="size-5">
                                <path
                                    d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                            </svg>

                            <span class="lg:block hidden">
                                Sampel
                            </span>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-3 text-sm">
                        <template x-if="strukturTabel.ket_sampel">
                            <template x-for="item in strukturTabel.ket_sampel.split(';')" :key="item">
                                <div class="relative">
                                    <button @click="removeSampel(item, 'ket_sampel')"
                                        class="absolute top-0 -right-2 text-red-700">

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="size-5">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
                                                clip-rule="evenodd" />
                                        </svg>

                                    </button>

                                    <div class="mt-1 bg-gray-100 dark:bg-gray-700 rounded-lg px-2 py-1" x-text="item">
                                    </div>
                                </div>
                            </template>
                        </template>
                    </div>
                </div>

                <!-- Struktur Proses Monitoring -->
                <div class="my-8">
                    <span class="font-medium py-1">Proses Monitoring:</span>
                    <div class="flex lg:gap-x-4 gap-x-1">
                        <input x-model="newKetProses" type="text" placeholder="Masukkan proses baru..."
                            class="w-full outline-none border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                            @keyup.enter="addBtn(newKetProses, 'proses')" />
                        <button @click="addBtn(newKetProses, 'proses')"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg shadow-sm text-sm flex items-center gap-2 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="size-5">
                                <path
                                    d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                            </svg>

                            <span class="lg:block hidden">
                                Proses
                            </span>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-3 text-sm">
                        <template x-if="strukturTabel.proses">
                            <template x-for="item in strukturTabel.proses.split(';')" :key="item">
                                <div class="relative">
                                    <button @click="removeSampel(item, 'proses')"
                                        class="absolute top-0 -right-2 text-red-700">

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="size-5">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
                                                clip-rule="evenodd" />
                                        </svg>

                                    </button>

                                    <div class="mt-1 bg-gray-100 dark:bg-gray-700 rounded-lg px-2 py-1" x-text="item">
                                    </div>
                                </div>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan Perubahan -->
        <div class="mt-4 text-center">
            <button @click="simpan()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl shadow-md transition flex gap-2 items-center">
                Simpan Perubahan
                <div wire:loading wire:target="simpan"
                    class="h-5 w-5 animate-spin rounded-full border-4 border-solid border-white border-t-transparent">
                </div>
            </button>
        </div>
    </div>
    {{-- Care about people's approval and you will be their prisoner. --}}
</div>
