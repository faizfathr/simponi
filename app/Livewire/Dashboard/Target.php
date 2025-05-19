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
    public bool $showNotif = FALSE;
    public string $id_kegiatan, $periode ="", $action = 'Tambah', $ketWaktu ='', $message = '', $status = '';
    public $tanggal_mulai = null, $tanggal_selesai = null;
    public int $tahun, $waktu, $target=0;
    public bool $openForm = FALSE, $openWarningDelete = FALSE;
    public array $listBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    public array $ketPeriode = ['Bulan', 'Subround', 'Triwulan', 'Tahun'];

    public array $romawiFont = ["I", "II", "III", "IV"];

    public function render()
    {
        $listKegiatan = KegiatanSurvei::get();
        $listTarget = ListKegiatan::join('kegiatan_survei', 'id_kegiatan', 'kegiatan_survei.id')
            ->selectRaw('list_kegiatan.*, kegiatan_survei.periode as periode')
            ->orderBy('list_kegiatan.created_at', 'DESC')
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
        $surveiTarget = KegiatanSurvei::where('id', $this->id_kegiatan)->first();
        $this->periode = $surveiTarget->periode;
        if ($this->periode == 1) {
            $this->loopTask(12);
        } elseif ($this->periode == 2) {
            $this->loopTask(3);
        } elseif ($this->periode == 3) {
            $this->loopTask(4);
        } else {
            $this->loopTask(1);
        }
        $this->openForm = FALSE;
        $this->message = "Target berhasil ditambahkan";
        $this->status = "Berhasil";
        $this->showNotif =  TRUE;
    }

    private function loopTask($intervalTask)
    {
        $time = 1;
        while ($time <= $intervalTask) {
            ListKegiatan::create([
                'id_kegiatan' => $this->id_kegiatan,
                'tahun' => $this->tahun,
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
                'waktu' => $this->waktu,
                'target' => $this->target,
                'tanggal_mulai' => Carbon::make($this->tanggal_mulai),
                'tanggal_selesai' => Carbon::make($this->tanggal_selesai),
                'updated_at' => Carbon::now(),
            ]);
        if($isUpdated) $this->openForm = FALSE;
        $this->message = "Target berhasil diperbaharui";
        $this->status = "Berhasil";
        $this->showNotif =  TRUE;
    }

    public function confirmDelete($id)
    {
        $this->id = $id;
        $target = ListKegiatan::join('kegiatan_survei', 'id_kegiatan', 'kegiatan_survei.id')
            ->where('list_kegiatan.id', $id)
            ->first();
        $this->kegiatan = $target->joinKegiatan->kegiatan;
        $this->periode = $this->ketPeriode[$target->periode - 1];
        $this->ketWaktu = $target->periode == 1 
                        ? $this->listBulan[$target->waktu - 1] 
                        : ($target->periode < 4 
                            ? $this->romawiFont[$target->waktu - 1] 
                            : $target->tahun);
        $this->openWarningDelete = TRUE;
    }

    public function delete($id)
    {
        $isDeleted = ListKegiatan::where('id', $id)->delete();
        if($isDeleted) $this->openWarningDelete = FALSE;
        $this->message = "Target berhasil dihapus";
        $this->status = "Berhasil";
        $this->showNotif =  TRUE;
    }
}
