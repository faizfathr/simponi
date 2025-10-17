<?php

namespace App\Livewire\Dashboard;

use App\Models\ListKegiatan;
use App\Models\Mitra;
use App\Models\MonitoringKegiatan;
use Livewire\Component;
class Main extends Component
{

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
                    list_kegiatan.target,
                    SUM(CASE WHEN monitoring_kegiatan.status = 2 THEN 1 ELSE 0 END) as realisasi
                ')
            ->join('list_kegiatan', function ($join) {
                $join->on('monitoring_kegiatan.id_tabel', '=', 'list_kegiatan.id_kegiatan')
                    ->on('monitoring_kegiatan.waktu', '=', 'list_kegiatan.waktu')
                    ->on('monitoring_kegiatan.tahun', '=', 'list_kegiatan.tahun');
            })
            ->groupBy('monitoring_kegiatan.id_tabel', 'monitoring_kegiatan.tahun', 'monitoring_kegiatan.waktu', 'list_kegiatan.target')
            ->get();

        return view('livewire.dashboard.main', compact('mitra', 'kegiatan', 'kegiatanBerjalan'));
    }
}
