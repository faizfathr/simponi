<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\Mitra;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ListKegiatan;
use Livewire\WithFileUploads;
use App\Models\MonitoringKegiatan;

class ProgresDetail extends Component
{
    use WithFileUploads; 
    public $file;

    public $idPage = null;
    public bool $openForm = FALSE;
    public $sampel_header, $prosess_header, $sampel_body, $prosess_body;
    public array $monitoring;
    public string $id_tabel;
    public int $tahun, $waktu;

    public function mount($id)
    {
        $this->idPage = $id;
    }

    public function render()
    {
        $event = ListKegiatan::join('kegiatan_survei', 'list_kegiatan.id_kegiatan', 'kegiatan_survei.id')
            ->join('struktur_tabel_monitoring', 'kegiatan_survei.id', 'struktur_tabel_monitoring.id')
            ->selectRaw('kegiatan_survei.id as id_progres, kegiatan_survei.*, list_kegiatan.*, struktur_tabel_monitoring.*, struktur_tabel_monitoring.id as id_tabel')
            ->where('list_kegiatan.id', $this->idPage)
            ->first();
        if ($this->idPage) {
            $this->id_tabel = $event->id_tabel;
            $this->tahun = $event->tahun;
            $this->waktu = $event->waktu;
            $monitorings = MonitoringKegiatan::where([
                ['id_tabel', '=', $event->id_tabel],
                ['tahun', '=', $event->tahun],
                ['waktu', '=', $event->waktu],
            ])->get();

            $this->sampel_header = explode(';', $event->ket_sampel);
            $this->prosess_header = explode(';', $event->proses);
            return view('livewire.dashboard.progres-detail', compact('event', 'monitorings'));
        } else {
            return view('livewire.dashboard.progres-detail', compact('event'));
        }
    }

    public function openModalForm()
    {
        $this->openForm = TRUE;
    }

    public function back()
    {
        return redirect()->route('dashboard');
    }

    public function updateProgres()
    {
        
        $baris = array_keys($this->monitoring);
        foreach ($baris as $b) {
            $datasets = MonitoringKegiatan::where([
                ['no_baris', '=', $b + 1],
                ['id_tabel', '=', $this->id_tabel],
            ])->first();
            
            $separated = explode(";", $datasets->proses);
            foreach ($this->monitoring[$b]['prosess'] as $key => $progres) {
                $separated[$key] = strval($progres ? 1 : 0);
            };
            if (count(explode(";",$datasets->proses))===0) {
                $status = 0;
            } else if(count(explode(";",$datasets->proses)) === array_sum($separated)) {
                $status = 2;
            } else {
                $status = 1;
            }
            $separated = implode(';',$separated);
            // menghitung status
            MonitoringKegiatan::where([
                ['id_tabel', '=', $this->id_tabel],
                ['no_baris', '=', $b + 1],
                ['tahun', '=', $this->tahun],
                ['waktu', '=', $this->waktu],
            ]
            )->update([
                'proses' => $separated,
                'status' => $status,
            ]);
        };
        $this->render();
    }

    #[On('close-modal')]
    public function closeModal($openModal)
    {
        $this->openForm = $openModal;
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx|max:2048',
        ]);

        $path = $this->file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        foreach($data as $indexRows => $rows) {
            if($indexRows < 2) continue;
            $monitoring = [];
            $arrSampel = [];
            $arrProses = [];
            $monitoring['no_baris'] = $rows[0];
            $lenData = collect($rows)->count();
            foreach($rows as $indexVal => $value) {
                if($indexVal >=1 && $value !== "" && $indexVal < $lenData-2) {
                    array_push($arrSampel, $value);
                } else if($data[0][$indexVal]!=="Jadwal" && $indexVal < $lenData-4) {
                    array_push($arrProses, 0);
                } else {
                    continue;
                }
            }
            $monitoring['id_tabel'] = $this->id_tabel;
            $monitoring['no_baris'] = $rows[0];
            $monitoring['tahun'] = $this->tahun;
            $monitoring['waktu'] = $this->waktu;
            $monitoring['ket_sampel'] = implode(';', $arrSampel);
            $monitoring['proses'] = implode(';', $arrProses);
            $monitoring['status'] = 0;
            $monitoring['pcl'] = $rows[$lenData-2];
            $monitoring['pml'] = $rows[$lenData-1];
            $monitoring['created_at'] = Carbon::now();
            $monitoring['updated_at'] = Carbon::now();
            MonitoringKegiatan::insert($monitoring);
        }
    }
}
