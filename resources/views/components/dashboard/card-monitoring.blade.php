@aware([
    'query' => '',
])

@php
    $listBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    $ketPeriode = ['Bulan', 'Triwulan', 'Subround', 'Tahun'];
    $romawiFont = ["I", "II", "III", "IV"];
    $format = explode(',', $query);
@endphp

<div x-data="{ items: []}"
    x-effect="fetch('/resource/getDataResume', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({ query: '{{ $query }}' })
            })
            .then((response)=> response.json())
            .then((response)=> {
                items = response;
            })">
    <template x-if="items.length === 0">
        <div class="bg-orange-100/50 shadow-md rounded-2xl p-4 border-4 border-orange-500 animate-pulse">
            <div class="flex items-center justify-between mb-4">
                <div class="flex flex-col">
                    <span class="h-4 bg-gray-300 rounded w-24 mb-2"></span>
                    <span class="h-3 bg-gray-200 rounded w-16"></span>
                </div>
                <span class="h-6 bg-gray-300 rounded w-20"></span>
            </div>
            <div class="mb-3">
                <div class="h-8 bg-gray-300 rounded w-32 mb-2"></div>
                <span class="h-3 bg-gray-200 rounded w-24"></span>
                <div class="w-full bg-gray-200 h-4 rounded-full mt-2 animate-pulse"></div>
            </div>
            <div class="flex items-center w-[100%] gap-2 mt-4">
                <span class="h-4 bg-gray-300 rounded w-16"></span>
            </div>
        </div>
    </template>

    <template x-for="item in items" :key="item.id">
        <div
            :class="item.subsektor == 1 ? 'bg-primary border-primary' : item.subsektor == 2 ? 'bg-green-100/50 border-green-500' : item.subsektor == 3 ? 'bg-orange-100/50 border-orange-500' : item.subsektor == 4 ? 'bg-blue-100/50 border-blue-500' : 'bg-purple-100/50 border-purple-500'"
            class="shadow-md rounded-2xl p-4 border-4 hover:scale-95 transition-all duration-150 z-40">
            <div class="flex items-center justify-between mb-1">
                <div class="flex flex-col">
                    <span class="text-sm md:text-lg font-semibold text-gray-800 dark:text-gray-100 "
                        x-text="item.kegiatan"></span>
                    <span class="text-xs text-gray-800 dark:text-gray-100">
                        {{ $ketPeriode[$format[3]-1]}} {{ ($format[1] > 4 && $format[3]-1 !== 1) ? $listBulan[$format[1]-1] : $romawiFont[$format[3]] }} - ({{ $format[2] }})
                    </span>
                </div>
                <a href="{{ route('resume-detail', ['id' => $format[4], 'year' => $format[2], 'waktu'=>$format[1]]) }}"
                    wire:navigate
                    class="inline-flex items-center px-3 py-1.5 rounded-lg bg-brand-500 text-white text-xs font-medium hover:bg-brand-600 transition">
                    Lihat Detail
                </a>
            </div>
            <div class="mb-3">
                <h1 class="text-gray-700 dark:text-gray-100 font-semibold text-3xl"
                    x-text="(item.realisasi / item.target * 100).toFixed(1) + '%'"></h1>
                <span class="text-gray-700 dark:text-gray-100 font-medium text-xs"
                    x-text="'Realisasi: ' + item.realisasi + ' dari ' + item.target + ' target'"></span>
                <div class="w-full bg-gray-200 dark:bg-gray-600 h-4 rounded-full">
                    <div class="h-4 rounded-full transition-all duration-300 flex overflow-hidden">
                        <template x-if="(item.realisasi / item.target * 100) <= 30">
                            <div class="flex w-full">
                                <div class="bg-red-500 h-4 rounded-l-full"
                                    :style="'width: ' + (item.realisasi / item.target * 100) + '%'"></div>
                                <div class="bg-red-100 h-4 rounded-r-full"
                                    :style="'width: ' + (100 - (item.realisasi / item.target * 100)) + '%'"></div>
                            </div>
                        </template>
                        <template
                            x-if="(item.realisasi / item.target * 100) > 30 && (item.realisasi / item.target * 100) <= 60">
                            <div class="flex w-full">
                                <div class="bg-yellow-400 h-4 rounded-l-full"
                                    :style="'width: ' + (item.realisasi / item.target * 100) + '%'"></div>
                                <div class="bg-yellow-100 h-4 rounded-r-full"
                                    :style="'width: ' + (100 - (item.realisasi / item.target * 100)) + '%'"></div>
                            </div>
                        </template>
                        <template x-if="(item.realisasi / item.target * 100) > 60">
                            <div class="flex w-full">
                                <div class="bg-green-500 h-4 rounded-l-full"
                                    :style="'width: ' + (item.realisasi / item.target * 100) + '%'"></div>
                                <div class="bg-green-100 h-4 rounded-r-full"
                                    :style="'width: ' + (100 - (item.realisasi / item.target * 100)) + '%'"></div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="flex items-center w-[100%] gap-2 mt-4">
                <div>
                    <span class="inline-block px-3 py-1 rounded-md text-white text-[0.6rem] md:text-xs font-semibold bg-slate-500">
                        Belum Mulai: <span x-text="item.belumSelesai"></span>
                    </span>
                </div>
                <div>
                    <span class="inline-block px-3 py-1 rounded-md text-white text-[0.6rem] md:text-xs font-semibold bg-orange-500">
                        On Progres: <span x-text="item.onProgres">
                    </span>
                </div>
                <div>
                    <span class="inline-block px-3 py-1 rounded-md text-white text-[0.6rem] md:text-xs font-semibold bg-green-500">
                        Clean: <span x-text="item.realisasi">
                    </span>
                </div>
            </div>
        </div>
    </template>
</div>
