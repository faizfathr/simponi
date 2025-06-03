<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\Mitra;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ListKegiatan;
use Livewire\WithFileUploads;
use App\Models\MonitoringKegiatan;
use Illuminate\Http\Request;

class ProgresDetail extends Component
{
    use WithFileUploads;
    public $file;

    public $idPage = null;
    public bool $openForm = FALSE, $showNotif = FALSE;
    public $sampel_header, $prosess_header, $sampel_body, $prosess_body;
    public array $monitoring, $allItem;
    public string $id_tabel,  $message = '', $status = '';
    public int $tahun, $waktu;

    public array $bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    public function mount($id)
    {
        $this->idPage = $id;
        $list_kegiatan = ListKegiatan::where('id', $id)->first();
        $this->monitoring = MonitoringKegiatan::where([
            ['id_tabel', '=', $list_kegiatan->id_kegiatan],
            ['tahun', '=', $list_kegiatan->tahun],
            ['waktu', '=', $list_kegiatan->waktu],
        ])->get()
            ->map(function ($item) {
                $item->sampel_body = explode(';', $item->ket_sampel);
                return $item;
            })->toArray();
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
                ['id_tabel', '=', $event->id_kegiatan],
                ['tahun', '=', $event->tahun],
                ['waktu', '=', $event->waktu],
            ])->get()
                ->map(function ($item) {
                    $item->sampel_body = explode(';', $item->ket_sampel);
                    $item->prosess = explode(';', $item->proses);
                    return $item;
                })->toArray();
            $pcl = Mitra::where('status', 1)->get();
            $pml = Mitra::where('status', 0)->get();
            $this->sampel_header = explode(';', $event->ket_sampel);
            $this->prosess_header = explode(';', $event->proses);
            $this->allItem = $monitorings;
            return view('livewire.dashboard.progres-detail', compact('event', 'monitorings', 'pcl', 'pml'));
        } else {
            return view('livewire.dashboard.progres-detail', compact('event'));
        }
    }

    public function openModalForm()
    {
        $this->openForm = TRUE;
    }

    public function updateProgres(Request $request)
    {
        foreach ($this->allItem as $key => &$data) {
            $data['ket_sampel'] = implode(';', $data['sampel_body']);

            $data['prosess'] = collect($data['prosess'])->map(function ($item) {
                return (int) $item;
            })->toArray();
            $data['proses'] = implode(';', $data['prosess']);
            if (array_sum(explode(";", $data['proses'])) === 0) {
                $data['status'] = 0;
            } else if (count(explode(";", $data['proses'])) === array_sum($data['prosess'])) {
                $data['status'] = 2;
            } else {
                $data['status'] = 1;
            }
            $updated[$key] = MonitoringKegiatan::where('id', $data['id'])
                ->update([
                    'ket_sampel' => $data['ket_sampel'],
                    'status' => $data['status'],
                    'proses' => $data['proses'],
                    'pcl' => $data['pcl'],
                    'pml' => $data['pml'],
                ]);
        }
        unset($data);
        if (array_sum($updated) > 0) {
            $this->message = 'Data berhasil disimpan';
            $this->status = 'Suksess';
            $this->showNotif = TRUE;
        } else {
            $this->message = 'Tidak ada data yg diupdate';
            $this->status = 'Gagal';
            $this->showNotif = TRUE;
        }
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
        if (($handle = fopen($path, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ";")) !== false) {
                $data[] = $row;
            }
            fclose($handle);
        }

        foreach ($data as $indexRows => $rows) {
            if ($indexRows < 2) continue;
            $monitoring = [];
            $arrSampel = [];
            $arrProses = [];
            $lenData = collect($rows)->count();

            foreach ($rows as $indexVal => $value) {
                if ($indexVal >= 0 && $value !== "" && $indexVal < $lenData - 2) {
                    array_push($arrSampel, $value);
                } else if ($data[0][$indexVal] !== "Sampel" && $indexVal < $lenData - 3) {
                    array_push($arrProses, 0);
                } else {
                    continue;
                }
            }
            $monitoring['id_tabel'] = $this->id_tabel;
            $monitoring['tahun'] = $this->tahun;
            $monitoring['waktu'] = $this->waktu;
            $monitoring['ket_sampel'] = implode(';', $arrSampel);
            $monitoring['proses'] = implode(';', $arrProses);
            $monitoring['status'] = 0;
            $monitoring['pcl'] = $rows[$lenData - 2];
            $monitoring['pml'] = $rows[$lenData - 1];
            $monitoring['created_at'] = Carbon::now();
            $monitoring['updated_at'] = Carbon::now();
            MonitoringKegiatan::insert($monitoring);
        }
        $this->message = 'Template berhasil diimport';
        $this->status = 'Berhasil';
        $this->showNotif = TRUE;
        $this->reset('file');
    }
}
