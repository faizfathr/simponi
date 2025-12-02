<?php

namespace App\Livewire\Dashboard;

use App\Models\ListKegiatan;
use App\Models\Mitra;
use App\Models\MonitoringKegiatan;
use Livewire\Component;
class Main extends Component
{ 
public array $bulan = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];
public array $rekap = [

    // ==========================================
    // 1. STATISTIK PETERNAKAN
    // ==========================================
    [
        'judul'    => 'STATISTIK PETERNAKAN',
        'subjudul' => [
            [
                'nama'  => 'Pengumpulan Data Statistik Peternakan Objek Usaha :',
                'items' => [
                    [
                        'nama'     => 'a. RPH/TPH Bulan Desember 2024',
                        'children' => ['Pencacahan', 'Pemeriksaan', 'Pengiriman Dokumen']
                    ],
                    [
                        'nama'     => 'b. RPH/TPH',
                        'children' => ['Pencacahan', 'Pemeriksaan', 'Pengiriman Dokumen']
                    ],
                    [
                        'nama'     => 'c. Perusahaan Ternak Besar/Kecil (LTT)',
                        'children' => ['Pencacahan', 'Pemeriksaan', 'Pengiriman Dokumen']
                    ],
                    [
                        'nama'     => 'd. Perusahaan Ternak Unggas (LTU)',
                        'children' => ['Pencacahan', 'Pemeriksaan', 'Pengiriman Dokumen']
                    ],
                ],
            ],
        ],
    ],

    // ==========================================
    // 2. STATISTIK PERIKANAN
    // ==========================================
    [
        'judul'    => 'STATISTIK PERIKANAN',
        'subjudul' => [

            // SUBJUDUL 1
            [
                'nama'  => 'Pengumpulan Data Statistik Perikanan Objek Usaha :',
                'items' => [
                    [
                        'nama'     => 'a. Perusahaan Penangkapan Ikan (PP-TPI) TW 2024',
                        'children' => ['Pencacahan', 'Pemeriksaan', 'Pengiriman Dokumen']
                    ],
                    [
                        'nama'     => 'b. Perusahaan Penangkapan Ikan (PP-TPI)',
                        'children' => ['Pencacahan', 'Pemeriksaan', 'Pengiriman Dokumen']
                    ],
                    [
                        'nama'     => 'c. Laporan Tahunan Perusahaan Budidaya Ikan (LTB)',
                        'children' => ['Pencacahan', 'Pemeriksaan', 'Pengiriman Dokumen']
                    ],
                ],
            ],

            // SUBJUDUL 2
            [
                'nama'  => 'Publikasi Statistik Perikanan :',
                'items' => [
                    [
                        'nama'     => 'a. Statistik Pelabuhan Perikanan Kota Singkawang 2024',
                        'children' => [
                            'Melakukan Entri dan Tabulasi Data',
                            'Membuat Grafik/Gambar',
                            'Membuat Analisis',
                            'Membuat Desain Cover',
                            'Melakukan Penyusunan Publikasi'
                        ]
                    ],
                ],
            ],
        ],
    ],

    // ==========================================
    // 3. STATISTIK PANGAN
    // ==========================================
    [
        'judul'    => 'STATISTIK PANGAN',
        'subjudul' => [
            [
                'nama'  => 'Pengumpulan Data Statistik Pangan Objek Rumah Tangga :',
                'items' => [
                    [
                        'nama'     => 'a. Update Ruta Ubinan Palawija',
                        'children' => ['Pencacahan', 'Pemeriksaan', 'Entri Data']
                    ],
                    [
                        'nama'     => 'b. Ubinan Palawija',
                        'children' => ['Pencacahan', 'Pemeriksaan', 'Entri Data']
                    ],
                    [
                        'nama'     => 'c. Ubinan Padi',
                        'children' => ['Pencacahan', 'Pemeriksaan', 'Entri Data']
                    ],
                    [
                        'nama'     => 'd. SKGB',
                        'children' => ['Pengeringan', 'Penggilingan']
                    ],
                ],
            ],
            [
                'nama'  => 'Pengumpulan Data Statistik Tanaman Pangan Objek Non Rumah Tangga dan Non Usaha :',
                'items' => [
                    [
                        'nama'     => 'a. SP PALAWIJA Bulan Desember 2024',
                        'children' => ['Dokumen Masuk', 'Entri Data']
                    ],
                    [
                        'nama'     => 'b. SP PALAWIJA',
                        'children' => ['Dokumen Masuk', 'Entri Data']
                    ],
                    [
                        'nama'     => 'c. SP LAHAN Tahun 2024',
                        'children' => ['Dokumen Masuk', 'Entri Data']
                    ],
                    [
                        'nama'     => 'd. SP BENIH TP Tahun 2024',
                        'children' => ['Dokumen Masuk', 'Entri Data']
                    ],
                    [
                        'nama'     => 'e. SP ALSINTAN TP Tahun 2024',
                        'children' => ['Dokumen Masuk', 'Entri Data']
                    ],
                ],
            ],
        ],
    ],

    // ==========================================
    // 4. STATISTIK TANAMAN HORTIKULTURA
    // ==========================================
    [
        'judul'    => 'STATISTIK TANAMAN HORTIKULTURA',
        'subjudul' => [

            // SUBJUDUL 1
            [
                'nama'  => 'Pengumpulan Data Statistik Tanaman Hortikultura Objek Non Rumah Tangga dan Non Usaha :',
                'items' => [
                    ['nama' => 'a. SPH-SBS Bulan Desember 2024', 'children' => ['Dokumen Masuk', 'Entri Data']],
                    ['nama' => 'b. SPH-SBS',                       'children' => ['Dokumen Masuk', 'Entri Data']],
                    ['nama' => 'c. SPH-BST Triwulan IV 2024',      'children' => ['Dokumen Masuk', 'Entri Data']],
                    ['nama' => 'd. SPH-BST',                       'children' => ['Dokumen Masuk', 'Entri Data']],
                    ['nama' => 'e. SPH-TBF Triwulan IV 2024',      'children' => ['Dokumen Masuk', 'Entri Data']],
                    ['nama' => 'f. SPH-TBF',                       'children' => ['Dokumen Masuk', 'Entri Data']],
                    ['nama' => 'g. SPH-TH Triwulan IV 2024',       'children' => ['Dokumen Masuk', 'Entri Data']],
                    ['nama' => 'h. SPH-TH',                        'children' => ['Dokumen Masuk', 'Entri Data']],
                    ['nama' => 'i. Updating DPP',                  'children' => ['Pencacahan', 'Pemeriksaan', 'Entri Data']],
                    ['nama' => 'j. VN Horti',                      'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                ],
            ],

            // SUBJUDUL 2
            [
                'nama'  => 'Publikasi Statistik Tanaman Hortikultura :',
                'items' => [
                    [
                        'nama'     => 'a. Statistik Tanaman Sayuran dan Buah-Buahan Kota Singkawang 2024',
                        'children' => [
                            'Melakukan Entri dan Tabulasi Data',
                            'Membuat Grafik/Gambar',
                            'Membuat Analisis',
                            'Membuat Desain Cover',
                            'Melakukan Penyusunan Publikasi'
                        ]
                    ],
                ],
            ],
        ],
    ],

    // ==========================================
    // 5. STATISTIK TANAMAN PANGAN TERINTEGRASI
    // ==========================================
    [
        'judul'    => 'STATISTIK TANAMAN PANGAN TERINTEGRASI METODE KERANGKA SAMPEL AREA (KSA)',
        'subjudul' => [
            [
                'nama'  => 'Pengumpulan Data Statistik Tanaman Pangan Objek Non Rumah Tangga dan Non Usaha :',
                'items' => [
                    ['nama' => 'a. KSA Padi',   'children' => ['Pencacahan', 'Pemeriksaan']],
                    ['nama' => 'b. KSA Jagung', 'children' => ['Pencacahan', 'Pemeriksaan']],
                ],
            ],
        ],
    ],

    // ==========================================
    // 6. STATISTIK TANAMAN PERKEBUNAN
    // ==========================================
    [
        'judul'    => 'SURVEI PERKEBUNAN',
        'subjudul' => [
            [
                'nama'  => 'Pengumpulan Data Survei Komoditas Strategis Perkebunan',
                'items' => [
                    [
                        'nama'     => 'a. Listing KOMSTRAT',
                        'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']
                    ],
                    [
                        'nama'     => 'b. Pencacahan KOMSTRAT',
                        'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']
                    ],
                ],
            ],
        ],
    ],

    // ==========================================
    // 7. SURVEI KESEJAHTERAAN PETANI
    // ==========================================
    [
        'judul'    => 'SURVEI KESEJAHTERAAN PETANI',
        'subjudul' => [
            [
                'nama'  => 'Pengumpulan Data Survei Kesejahteraan Petani (SKP)',
                'items' => [
                    [
                        'nama'     => 'a. Pencacahan',
                        'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']
                    ],
                ],
            ],
        ],
    ],

    // ==========================================
    // 8. STATISTIK INDUSTRI
    // ==========================================
    [
        'judul'    => 'STATISTIK INDUSTRI',
        'subjudul' => [
            [
                'nama'  => 'Pengumpulan Data Statistik Industri Objek Usaha :',
                'items' => [
                    ['nama' => 'a. IMK Triwulanan (Listing)',        'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                    ['nama' => 'b. IMK Triwulanan IV 2024 (Pencacahan)', 'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                    ['nama' => 'c. IMK Triwulanan (Pencacahan)',     'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                    ['nama' => 'd. IMK Tahunan (Listing)',           'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                    ['nama' => 'e. IMK Tahunan (Pencacahan)',        'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                    ['nama' => 'f. Pemutakhiran DPA',                'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                    ['nama' => 'g. STPIM',                           'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                    ['nama' => 'h. IBS Triwulanan',                  'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                ],
            ],
        ],
    ],

    // ==========================================
    // 9. STATISTIK PERTAMBANGAN, ENERGI & KONSTRUKSI
    // ==========================================
    [
        'judul'    => 'SURVEI KESEJAHTERAAN PETANI',
        'subjudul' => [

            // PERTAMBANGAN & ENERGI
            [
                'nama'  => 'Pengumpulan Data Statistik Pertambangan dan Energi Objek Usaha :',
                'items' => [
                    ['nama' => 'a. Survei Penggalian-BH Triwulanan IV 2024',        'children' => ['Pencacahan', 'Pemeriksaan', 'Pengiriman Dokumen']],
                    ['nama' => 'b. Survei Usaha Galian Rumah Tangga (URT)',         'children' => ['Pencacahan', 'Pemeriksaan', 'Pengiriman Dokumen']],
                    ['nama' => 'c. Survei Captive Power',                           'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                    ['nama' => 'd. Survei Tahunan Perusahaan Air Bersih',           'children' => ['Pencacahan', 'Pemeriksaan', 'Pengiriman Dokumen']],
                    ['nama' => 'e. Survei Air Bersih Triwulanan IV 2024',           'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                    ['nama' => 'f. Survei Air Bersih Triwulanan',                   'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                    ['nama' => 'g. Updating Direktori Pertambangan Energi',         'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                ],
            ],

            // KONSTRUKSI
            [
                'nama'  => 'Pengumpulan Data Statistik Konstruksi Objek Usaha :',
                'items' => [
                    ['nama' => 'a. Pengutipan Direktori Perusahaan Konstruksi',          'children' => ['Pencacahan', 'Pemeriksaan', 'Entri Data']],
                    ['nama' => 'b. Updating Direktori Perusahaan Konstruksi (UDP)',      'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                    ['nama' => 'c. Survei Konstruksi Triwulanan IV 2024',               'children' => ['Pencacahan', 'Pemeriksaan', 'Pengiriman Dokumen']],
                    ['nama' => 'd. Survei Konstruksi Triwulanan',                       'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                    ['nama' => 'e. Survei Konstruksi Tahunan',                          'children' => ['Pencacahan', 'Submitted by PCL', 'Approved by PML']],
                ],
            ],
        ],
    ],

    // ==========================================
    // 10. KEGIATAN ADMINISTRASI
    // ==========================================
    [
        'judul'    => 'KEGIATAN ADMINISTRASI',
        'subjudul' => [

            // ADMIN PERTANIAN
            [
                'nama'  => 'ADMINISTRASI STATISTIK PERTANIAN',
                'items' => [
                    ['nama' => 'a. Pembuatan Surat Pengantar', 'children' => ['Surat Masuk', 'Surat Keluar']],
                    ['nama' => 'b. Pembuatan SPJ',             'children' => ['SPJ Kota', 'SPJ Provinsi']],
                    ['nama' => 'c. Pembuatan Surat Tugas',     'children' => ['Surat Tugas Lapangan']],
                    ['nama' => 'd. Pelatihan/Briefing/Sosialisasi', 'children' => ['Pelatihan Petugas KSA dan Ubinan', 'Pelatihan Petugas SKP']],
                ],
            ],

            // ADMIN PEK
            [
                'nama'  => 'ADMINISTRASI STATISTIK PEK',
                'items' => [
                    ['nama' => 'a. Pembuatan Surat Pengantar', 'children' => ['Surat Masuk', 'Surat Keluar']],
                    ['nama' => 'b. Pembuatan SPJ',             'children' => ['SPJ Kota', 'SPJ Provinsi']],
                    ['nama' => 'c. Pembuatan Surat Tugas',     'children' => ['Surat Tugas Lapangan']],
                    [
                        'nama'     => 'd. Pelatihan/Briefing/Sosialisasi',
                        'children' => [
                            'Pelatihan Petugas Survei Statistik Industri',
                            'Pelatihan Petugas Survei Konstruksi',
                            'Pelatihan Petugas Survei IMK Tahunan'
                        ]
                    ],
                ],
            ],

        ],
    ],

];


    public function render()
    {
        $mitra = collect([
            'pcl' => Mitra::where('status', 1)->count(),
            'pml' => Mitra::where('status', 0)->count(),
        ]);
        $kegiatan = ListKegiatan::where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->orWhereMonth('tanggal_mulai', now()->month)
            ->orWhereMonth('tanggal_selesai', now()->month)
            ->whereYear('tanggal_selesai', now()->year)
            ->get();
        $kegiatanBerjalan = MonitoringKegiatan::whereIn('status', [1, 2])
            ->selectRaw('
                    monitoring_kegiatan.id_tabel,
                    monitoring_kegiatan.tahun,
                    monitoring_kegiatan.waktu,
                    list_kegiatan.id_kegiatan as id_kegiatan,
                    list_kegiatan.target,
                    SUM(CASE WHEN monitoring_kegiatan.status = 2 THEN 1 ELSE 0 END) as realisasi
                ')
            ->join('list_kegiatan', function ($join) {
                $join->on('monitoring_kegiatan.id_tabel', '=', 'list_kegiatan.id_kegiatan')
                    ->on('monitoring_kegiatan.waktu', '=', 'list_kegiatan.waktu')
                    ->on('monitoring_kegiatan.tahun', '=', 'list_kegiatan.tahun');
            })
            ->groupBy('monitoring_kegiatan.id_tabel', 'monitoring_kegiatan.tahun', 'monitoring_kegiatan.waktu', 'list_kegiatan.target', 'list_kegiatan.id_kegiatan')
            ->get();

        return view('livewire.dashboard.main', compact('mitra', 'kegiatan', 'kegiatanBerjalan'));
    }
}
