<?php

namespace App\Livewire\Monitoring;

use App\Models\ListKegiatan;
use Livewire\Attributes\On;
use Livewire\Component;

class Submonitoring extends Component
{

    public $idMonitoring = 3;
    public array $bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    public function render()
    {
        $contents = ListKegiatan::leftJoin('kegiatan_survei', 'id_kegiatan', 'kegiatan_survei.id')
            ->leftJoin('monitoring_kegiatan', function($join){
                $join->on('id_kegiatan', '=', 'id_tabel')
                    ->where('status', 2);
            })
            ->selectRaw('list_kegiatan.id_kegiatan, kegiatan, subsektor, target, list_kegiatan.waktu as waktu, list_kegiatan.tanggal_mulai as mulai, list_kegiatan.tanggal_selesai as selesai, Count(status) as realisasi')
            ->groupBy('list_kegiatan.id_kegiatan', 'kegiatan', 'target', 'subsektor', 'waktu', 'mulai', 'selesai')
            ->where('subsektor', $this->idMonitoring)
            ->get();
        return view('livewire.monitoring.submonitoring', compact('contents'));
    }

    #[On('updateSubmonitoring')]
    public function updateSubmonitoring($id)
    {
        $this->idMonitoring = $id;
        $this->render();
    }
}
