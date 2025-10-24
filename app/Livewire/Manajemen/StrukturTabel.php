<?php

namespace App\Livewire\Manajemen;

use App\Models\StrukturTabelMonitoring;
use Livewire\Component;

class StrukturTabel extends Component
{
    public $id;
    public $strukturTabel= [];
    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $struktur = StrukturTabelMonitoring::join('kegiatan_survei', 'struktur_tabel_monitoring.id', '=', 'kegiatan_survei.id')
            ->where('struktur_tabel_monitoring.id', $this->id)
            ->select('struktur_tabel_monitoring.*', 'kegiatan_survei.kegiatan as kegiatan')
            ->first();
        return view('livewire.manajemen.struktur-tabel', compact('struktur'));
    }

    
    public function simpan()
    {
        $tabel = StrukturTabelMonitoring::find($this->id);
        if($tabel){
            StrukturTabelMonitoring::where('id', $this->id)->update([
                'ket_sampel' => $this->strukturTabel['ket_sampel'],
                'proses' => $this->strukturTabel['proses'],
            ]);
        } else {
            StrukturTabelMonitoring::create([
                'id' => $this->id,
                'ket_sampel' => $this->strukturTabel['ket_sampel'],
                'proses' => $this->strukturTabel['proses'],
                'status' => 'status',
                'pcl' => 'pcl',
                'pml' => 'pml',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
