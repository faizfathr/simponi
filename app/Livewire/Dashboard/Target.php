<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\ListKegiatan;
use Livewire\WithPagination;
use App\Models\KegiatanSurvei;
use Illuminate\Validation\Rule;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Validator;

class Target extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $id, $kegiatan;
    public bool $showNotif = FALSE;
    public string $id_kegiatan, $periode = "", $action = 'Tambah', $ketWaktu = '', $message = '', $status = '', $qSearch = '', $querySearchKegiatan = '';
    public $tanggal_mulai = null, $tanggal_selesai = null;
    public int $tahun;
    public int $waktu, $target = 0, $perPage = 10;
    public bool $openForm = FALSE, $openWarningDelete = FALSE;
    public array $listBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    public array $ketPeriode = ['Bulan', 'Triwulan', 'Subround', 'Tahun'];

    public array $romawiFont = ["I", "II", "III", "IV"];

    public function mount()
    {
        $this->tahun = Carbon::now()->year;
    }

    public function render()
    {
        if($this->querySearchKegiatan) {
            $listKegiatan = KegiatanSurvei::
                whereLike('kegiatan','%'. $this->querySearchKegiatan . '%')
                ->get();
        } else {
            $listKegiatan = KegiatanSurvei::get();
        }
        if ($this->qSearch) {
            $listTarget = ListKegiatan::join('kegiatan_survei', 'id_kegiatan', 'kegiatan_survei.id')
                ->selectRaw('list_kegiatan.*, kegiatan_survei.kegiatan, kegiatan_survei.periode as periode')
                ->whereLike('kegiatan', '%' . $this->qSearch . '%')
                ->where('tahun', $this->tahun)
                ->orderBy('list_kegiatan.created_at', 'DESC')
                ->get();
        } else {
            $listTarget = ListKegiatan::join('kegiatan_survei', 'id_kegiatan', 'kegiatan_survei.id')
                ->selectRaw('list_kegiatan.*, kegiatan_survei.kegiatan, kegiatan_survei.periode as periode')
                ->orderBy('list_kegiatan.created_at', 'DESC')
                ->where('tahun', $this->tahun)
                ->paginate($this->perPage);
        }
        return view('livewire.dashboard.target', [
            'listTarget' => $listTarget,
            'listKegiatan' => $listKegiatan
        ]);
    }

    public function setIdKegiatan($id, $kegiatan)
    {
        $this->id_kegiatan = $id;
        $this->querySearchKegiatan = $kegiatan;
    }

    public function submitForm()
    {
        if ($this->action === 'Tambah') $this->insert();
        else $this->update();
    }

    public function tambahForm()
    {
        $this->reset();
        $this->tahun = Carbon::now()->year;
        $this->resetValidation();
        $this->openForm = true;
    }

    public function insert()
    {

        $validator = Validator::make([
            'tahun' => $this->tahun,
            'target' => $this->target,
            'id_kegiatan' => $this->id_kegiatan ?? 'NULL',
        ], [
            'tahun' => 'required|integer',
            'target' => 'required|integer|min:1',
            'id_kegiatan' => [
                'required',
                'exists:kegiatan_survei,id',
                Rule::unique('list_kegiatan', 'id_kegiatan')
                    ->where(fn($query) => $query->where('tahun', $this->tahun ?? 'NULL')),
            ],
        ], [
            'tahun.required' => 'Tahun harus diisi',
            'target.required' => 'Target harus diisi',
            'target.min' => 'Target harus lebih dari 0',
            'id_kegiatan.required' => 'Kegiatan harus dipilih',
            'id_kegiatan.exists' => 'Kegiatan tidak ditemukan',
            'id_kegiatan.unique' => 'Target untuk kegiatan ini sudah ada pada tahun yang sama',
        ]);

        $validator->validate();
        $surveiTarget = KegiatanSurvei::where('id', $this->id_kegiatan)->first();
        $this->periode = $surveiTarget->periode;
        if ($this->periode == 1) {
            $this->loopTask(12);
        } elseif ($this->periode == 2) {
            $this->loopTask(4);
        } elseif ($this->periode == 3) {
            $this->loopTask(3);
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
        $this->querySearchKegiatan = $target->joinKegiatan->kegiatan;
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
        $isUpdated = ListKegiatan::where('id', $this->id)
            ->update([
                'id_kegiatan' => $this->id_kegiatan,
                'tahun' => $this->tahun,
                'waktu' => $this->waktu,
                'target' => $this->target,
                'tanggal_mulai' => Carbon::make($this->tanggal_mulai),
                'tanggal_selesai' => Carbon::make($this->tanggal_selesai),
                'updated_at' => Carbon::now(),
            ]);
        if ($isUpdated) {
            $this->openForm = false;
            $this->message = "Target berhasil diperbaharui";
            $this->status = "Berhasil";
            $this->showNotif =  true;
        } else {
            $this->openForm = false;
            $this->message = "Target gagal diperbaharui";
            $this->status = "Gagal";
            $this->showNotif =  true;
        }
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
        if ($isDeleted) $this->openWarningDelete = FALSE;
        $this->message = "Target berhasil dihapus";
        $this->status = "Berhasil";
        $this->showNotif =  TRUE;
    }
}
