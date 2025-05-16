<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\ListKegiatan;
use Livewire\WithPagination;
use App\Models\KegiatanSurvei;
use Livewire\WithoutUrlPagination;

class Target extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $id, $kegiatan;
    public string $id_kegiatan, $periode ="", $action = 'Tambah', $ketWaktu ='';
    public $tanggal_mulai = null, $tanggal_selesai = null;
    public int $tahun, $waktu, $target=0;
    public bool $openForm = FALSE, $openWarningDelete = FALSE;
    public array $listBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    public array $ketPeriode = ['Bulan', 'Subround', 'Triwulan', 'Tahun'];

    public array $romawiFont = ["I", "II", "III", "IV"];

    public function render()
    {
        $listKegiatan = KegiatanSurvei::get();
        $listTarget = ListKegiatan::orderBy('list_kegiatan.created_at', 'DESC')
            ->paginate(10);
        return view('livewire.dashboard.target', [
            'listTarget' => $listTarget,
            'listKegiatan' => $listKegiatan
        ]);
    }

    public function submitForm()
    {
        if($this->action === 'Tambah') $this->insert();
        else $this->update();
    }
    
    public function tambahForm()
    {
        $this->reset();
        $this->openForm = true;
    }

    public function insert()
    {
        if (intval($this->periode) == 1) {
            $this->loopTask(12);
        } elseif (intval($this->periode) == 2) {
            $this->loopTask(3);
        } elseif (intval($this->periode) == 3) {
            $this->loopTask(4);
        } else {
            $this->loopTask(1);
        }
        $this->openForm = FALSE;
    }

    private function loopTask($intervalTask)
    {
        $time = 1;
        while ($time <= $intervalTask) {
            ListKegiatan::create([
                'id_kegiatan' => $this->id_kegiatan,
                'tahun' => $this->tahun,
                'periode' => $this->periode,
                'waktu' => $time,
                'target' => $this->target,
                'tanggal_mulai' => Carbon::make($this->tanggal_mulai),
                'tanggal_selesai' => Carbon::make($this->tanggal_selesai),
                'created_at' => Carbon::now(),
                'udpated_at' => Carbon::now(),
            ]);
            $time++;
        }
    }

    public function edit($id, $action)
    {
        $target = ListKegiatan::where('id', $id)->first();
        $this->id = $target->id;
        $this->id_kegiatan = $target->id_kegiatan;
        $this->tahun = $target->tahun;
        $this->periode = $target->periode;
        $this->waktu = $target->waktu;
        $this->target = $target->target;
        $this->tanggal_mulai = $target->tanggal_mulai;
        $this->tanggal_selesai = $target->tanggal_selesai;
        $this->action = $action;
        $this->openForm = true;
    }

    public function update()
    {
        $isUpdated = ListKegiatan::
            where('id', $this->id)
            ->update([
                'id_kegiatan' => $this->id_kegiatan,
                'tahun' => $this->tahun,
                'periode' => $this->periode,
                'waktu' => $this->waktu,
                'target' => $this->target,
                'tanggal_mulai' => Carbon::make($this->tanggal_mulai),
                'tanggal_selesai' => Carbon::make($this->tanggal_selesai),
                'updated_at' => Carbon::now(),
            ]);
        if($isUpdated) $this->openForm = FALSE;
    }

    public function confirmDelete($id)
    {
        $this->id = $id;
        $target = ListKegiatan::where('id', $id)->first();
        $this->kegiatan = $target->joinKegiatan->kegiatan;
        $this->periode = $this->ketPeriode[$target->periode - 1];
        $this->ketWaktu = $target->periode == 1 
                        ? $this->listBulan[$target->waktu - 1] 
                        : ($target->periode < 4 
                            ? $this->romawiFont[$target->waktu - 1] 
                            : $target->tahun);
                            // dd($this->ketWaktu);
        $this->openWarningDelete = TRUE;
    }

    public function delete($id)
    {
        $isDeleted = ListKegiatan::where('id', $id)->delete();
        if($isDeleted) $this->openWarningDelete = FALSE;
    }
}
