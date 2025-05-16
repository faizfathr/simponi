<?php

namespace App\Livewire\Progres;

use Carbon\Carbon;
use App\Models\Mitra;
use Livewire\Component;
use App\Models\ListKegiatan;
use App\Models\MonitoringKegiatan;

class ModalForm extends Component
{
    public $idPage;
    public array $sampel, $prosess, $rows = [];
    public int $counterRow = 0, $tahun, $waktu, $status = 0;
    public string $id_tabel;

    public function mount($id)
    {
        $this->idPage = $id;
    }
    public function render()
    {
        $table = ListKegiatan::join('kegiatan_survei', 'list_kegiatan.id_kegiatan', 'kegiatan_survei.id')
            ->join('struktur_tabel_monitoring', 'kegiatan_survei.id', 'struktur_tabel_monitoring.id')
            ->selectRaw('list_kegiatan.id as id_kegiatan, struktur_tabel_monitoring.id as id_tabel, struktur_tabel_monitoring.*, kegiatan, sektor, tanggal_mulai, tanggal_selesai, waktu, tahun')
            ->where('list_kegiatan.id', $this->idPage)
            ->first();
        $monitoring = MonitoringKegiatan::find($this->idPage);
        $pcl = Mitra::where('status', 1)->get();
        $pml = Mitra::where('status', 0)->get();
        if ($table) {
            $table->tanggal_mulai = Carbon::parse($table->tanggal_mulai);
            $table->tanggal_selesai = Carbon::parse($table->tanggal_selesai);
            $this->sampel = explode(';', $table->ket_sampel);
            $this->prosess = explode(';', $table->proses);
            $this->tahun = $table->tahun;
            $this->waktu = $table->waktu;
            $this->status = 0;
            $this->id_tabel = $table->id_tabel;
        }
        return view('livewire.progres.modal-form', compact('table', 'monitoring', 'pcl', 'pml'));
    }

    public function addRow()
    {
        $this->counterRow++;
    }

    public function minRow()
    {
        if ($this->counterRow !== 0) $this->counterRow--;
    }

    public function save()
    {
        $totalAlurProses = collect($this->prosess)->count();
        $arrProses = [];
        dd($totalAlurProses);
        while($totalAlurProses > 0){
            array_push($arrProses, 0);
            $totalAlurProses--;
        }

        collect($this->rows)->map(function($row, $index) use($arrProses){
            MonitoringKegiatan::insert([
                'id_tabel' => $this->id_tabel,
                'no_baris' => $index,
                'tahun' => $this->tahun,
                'waktu' => $this->waktu,
                'ket_sampel' => implode(';', $row['sampel']),
                'proses' => implode(';', $arrProses),
                'pcl' => $row['pcl'],
                'pml' => $row['pml'],
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        });

        $this->dispatch('close-modal', openModal:false);
    }
}
