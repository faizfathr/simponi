<?php

namespace App\Livewire\Monitoring;

use App\Models\KegiatanSurvei;
use App\Models\ListKegiatan;
use Livewire\Attributes\On;
use Livewire\Component;

class Submonitoring extends Component
{

    public $idMonitoring = 3;
    public array $bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    public function render()
    {
        $contentsYearly = ListKegiatan::leftJoin('kegiatan_survei', 'id_kegiatan', 'kegiatan_survei.id')
            ->leftJoin('monitoring_kegiatan', function($join){
                $join->on('id_kegiatan', '=', 'id_tabel')
                    ->where('status', 2);
            })
            ->selectRaw('list_kegiatan.id_kegiatan, kegiatan, subsektor, target, periode, list_kegiatan.tanggal_mulai as mulai, list_kegiatan.tanggal_selesai as selesai, Count(status) as realisasi')
            ->groupBy('list_kegiatan.id_kegiatan', 'kegiatan', 'target', 'subsektor', 'periode', 'mulai', 'selesai')
            ->where('subsektor', $this->idMonitoring)
            ->where('periode', 4)
            ->get();
        $contentsNonYearly = KegiatanSurvei::where([
            ['subsektor','=', $this->idMonitoring],
            ['periode', '<>', 4]
        ])->get();

        return view('livewire.monitoring.submonitoring', compact('contentsYearly', 'contentsNonYearly'));
    }

    #[On('updateSubmonitoring')]
    public function updateSubmonitoring($id)
    {
        $this->idMonitoring = $id;
    }
}
