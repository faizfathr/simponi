<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\KegiatanSurvei;
use App\Models\ListKegiatan;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ManajemenSurvei extends Component
{
    use WithPagination, WithoutUrlPagination;   
    public $perPage = 10;
    public $openForm = false;
    public $kegiatan = '';
    public $alias = '';
    public $id_kegiatan = '';
    public $periode = '';
    public $ketWaktu = '';
    public $infoMessage = '';
    public $status = '';
    public $target = 0;
    public $tahun = 2025;
    public $waktu = '';
    public $tanggal_mulai = null;
    public $tanggal_selesai = null;
    public $id = null;
    public $action = 'Tambah';
    public $search = '';
   public $selectedKegiatan = null;
public $showDetail = false;
 public $querySearchKegiatan = '';

    // fungsi lain seperti tambahForm, simpan, getRules...
public function updatingSearch()
{
    $this->resetPage();
}




public function lihatDetail($id)
{
    $this->selectedKegiatan = KegiatanSurvei::find($id);
    $this->showDetail = true;
}

   public function getRules()
{
    return [
        'kegiatan' => 'required|string|max:255',
        'alias' => 'required|string|max:255',

        'tahun' => 'required|integer|min:2000|max:' . now()->addYear()->year,
        'periode' => ['required', Rule::in(['1', '2', '3', '4'])],
        'waktu' => 'required|integer|min:1|max:12',
        'target' => 'required|integer|min:0',
        'tanggal_mulai' => 'nullable|date',
        'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
    ];
}

    public function tambahForm()
    {
        $this->openForm = true;
        $this->reset([
            'kegiatan', 'alias', 'id', 'action', 'tanggal_mulai',
            'tanggal_selesai', 'waktu', 'target', 'tahun',
            'periode', 'ketWaktu', 'id_kegiatan'
        ]);
    }
   public function simpan()
{
    $this->validate($this->getRules());

    if ($this->action === 'Edit' && $this->id) {
        $data = KegiatanSurvei::findOrFail($this->id);

        $data->update([
            'kegiatan' => $this->kegiatan,
            'alias' => $this->alias,
            'id_kegiatan' => $this->id_kegiatan,
            'tahun' => $this->tahun,
            'periode' => $this->periode,
            'waktu' => $this->waktu,
            'target' => $this->target,
            'tanggal_mulai' => $this->tanggal_mulai ? Carbon::parse($this->tanggal_mulai)->format('Y-m-d') : null,
            'tanggal_selesai' => $this->tanggal_selesai ? Carbon::parse($this->tanggal_selesai)->format('Y-m-d') : null,
        ]);

        session()->flash('success', 'Kegiatan berhasil diperbarui.');
    } else {
        // Create baru ke tabel ListKegiatan
        ListKegiatan::create([
            'kegiatan' => $this->kegiatan,
            'alias' => $this->alias,
            'id_kegiatan' => $this->id_kegiatan,
            'tahun' => $this->tahun,
            'periode' => $this->periode,
            'waktu' => $this->waktu,
            'target' => $this->target,
            'tanggal_mulai' => $this->tanggal_mulai ? Carbon::parse($this->tanggal_mulai)->format('Y-m-d') : null,
            'tanggal_selesai' => $this->tanggal_selesai ? Carbon::parse($this->tanggal_selesai)->format('Y-m-d') : null,
        ]);

        session()->flash('success', 'Kegiatan berhasil ditambahkan.');
    }
    $this->openForm = false;
    $this->resetForm();
}

    public function confirmDelete($id)
{
    $kegiatan = KegiatanSurvei::findOrFail($id);
    $kegiatan->delete();

    // Jika data yang dihapus sedang dilihat, reset detail
    if ($this->selectedKegiatan && $this->selectedKegiatan->id == $id) {
        $this->selectedKegiatan = null;
        $this->showDetail = false;
    }

    session()->flash('success', 'Kegiatan berhasil dihapus.');
}
  public function setIdKegiatan($id, $kegiatan)
    {
        $this->id_kegiatan = $id;
        $this->querySearchKegiatan = $kegiatan;
    }
public function editKegiatan($id)
{
    $data = KegiatanSurvei::findOrFail($id);

    $this->id = $data->id;
    $this->kegiatan = $data->kegiatan;
    $this->alias = $data->alias;
    $this->id_kegiatan = $data->id_kegiatan;
    $this->tahun = $data->tahun;
    $this->periode = $data->periode;
    $this->waktu = $data->waktu;
    $this->target = $data->target;
    $this->tanggal_mulai = $data->tanggal_mulai;
    $this->tanggal_selesai = $data->tanggal_selesai;

    $this->action = 'Edit';
    $this->showDetail = false;
    $this->openForm = true;
}
public function resetForm()
{
    $this->reset([
        'id', 'kegiatan', 'alias', 'id_kegiatan', 'tahun',
        'periode', 'waktu', 'target', 'tanggal_mulai',
        'tanggal_selesai', 'openForm', 'action'
    ]);

    $this->action = 'Tambah';
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
        $kegiatanSurvei = KegiatanSurvei::query()
            ->where('kegiatan', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.dashboard.manajemen-survei', [
            'kegiatanSurvei' => $kegiatanSurvei,
             'listKegiatan' => $listKegiatan
        ]);
    }
}


