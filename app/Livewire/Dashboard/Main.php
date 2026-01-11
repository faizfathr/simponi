<?php

namespace App\Livewire\Dashboard;

use App\Models\Mitra;
use Livewire\Component;
use App\Models\ListKegiatan;
use App\Models\KegiatanSurvei;
use App\Models\MonitoringKegiatan;
use App\Models\Subsektor;

class Main extends Component
{
    public array $bulan = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    public array $ketPeriode = ['Bulan', 'Triwulan', 'Subround', 'Tahun'];

    public function render()
    {
        $mitra = collect([
            'pcl' => Mitra::where('status', 1)->count(),
            'pml' => Mitra::where('status', 0)->count(),
        ]);
        $kegiatan = ListKegiatan::whereYear('tanggal_mulai', now()->year)
            ->where(function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('tanggal_mulai', '<=', now())
                        ->where('tanggal_selesai', '>=', now());
                })
                    ->orWhereMonth('tanggal_mulai', now()->month)
                    ->orWhereMonth('tanggal_selesai', now()->month);
            })
            ->get();
        $kegiatanTahunIni = ListKegiatan::whereYear('tahun', now()->year)->get();
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
        $kegiatanSurvei = KegiatanSurvei::with(['targets' => function ($query) {
            $query->where('tahun', now()->year)
            ->with(['monitorings' => function ($monitoringQuery) {
                $monitoringQuery->selectRaw('
                        id_tabel,
                        waktu,
                        COUNT(*) as realisasi
                    ')
                    ->where('status', 2)
                    ->where('tahun', now()->year)
                    ->groupBy('id_tabel', 'waktu');
                }]);
            }])
            ->get();
        $subKegiatan = Subsektor::get();

        return view('livewire.dashboard.main', compact('mitra', 'kegiatan', 'kegiatanBerjalan', 'kegiatanSurvei', 'subKegiatan', 'kegiatanTahunIni'));
    }
}
