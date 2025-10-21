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
    public $sektor = '';
    public $subsektor = '';
    public $tanggal_mulai = null;
    public $tanggal_selesai = null;
    public $id = null;
    public $action = 'Tambah';
    public $search = '';
    public $selectedKegiatan = null;
    public $showDetail = false;
    public $openWarningDelete = false;
    public $message = '';
    public $showNotif = false;

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
            'periode' => ['required', Rule::in(['1', '2', '3', '4'])],
            'sektor' => 'required|string|max:255',
            'subsektor' => 'required|string|max:255',
        ];
    }

    public function tambahForm()
    {
        $this->reset([
            'kegiatan', 'alias', 'id', 'action', 'tanggal_mulai',
            'tanggal_selesai', 'waktu', 'target', 'tahun',
            'periode', 'ketWaktu', 'id_kegiatan','sektor', 'subsektor'
        ]);

        $this->openForm = true;
    }

public function simpan()
{     
    $this->validate([
        'kegiatan' => 'required|string|max:255',
        'alias' => 'required|string|max:255',
        'periode' => ['required', Rule::in(['1', '2', '3', '4'])],
        'sektor' => 'required|string|max:255',
        'subsektor' => 'required|integer|max:255',
    ]);

       if ($this->id && $this->action === 'Edit') {
            logger('UPDATE DIPANGGIL');
            
        
           $data = KegiatanSurvei::findOrFail($this->id);
    $data->update([

        'kegiatan' => $this->kegiatan,
        'alias' => $this->alias,
        'periode' => $this->periode,
        'sektor' => $this->sektor,
        'subsektor' => $this->subsektor,
    ]);

            $this->message = "Kegiatan berhasil diperbaharui";
            $this->status = "success";
    session()->flash('success', 'Kegiatan berhasil diperbarui.');
} else {
            $generateId = bin2hex(hash('sha256', $this->kegiatan . now()->timestamp . uniqid(), true));

            KegiatanSurvei::create([
                'id' => $generateId,
                'kegiatan' => $this->kegiatan,
                'alias' => $this->alias,
                'periode' => $this->periode,
                'sektor' => $this->sektor,
                'subsektor' => $this->subsektor,
            ]);
            $this->message = "Kegiatan berhasil ditambahkan";
            $this->status = "success";
        }
        $this->search = '';  
     $this->openForm = false;
$this->resetForm();
$this->showNotif = true;


    }
   public function editKegiatan($id)
{
    $data = KegiatanSurvei::findOrFail($id);
      
   $this->id = $data->id;
    $this->kegiatan = $data->kegiatan ?? '';
    $this->alias = $data->alias ?? '';
    $this->periode = strval($data->periode); // CAST to string untuk sinkron dengan <select>
    $this->sektor = strval($data->sektor);   // Sama seperti di atas
    $this->subsektor = $data->subsektor ?? '';
    $this->action = 'Edit';
    $this->showDetail = false;
    $this->openForm = true;
}
  public function resetForm()
{
    $this->reset([
        'id', 'kegiatan', 'alias', 'periode', 
        'sektor', 'subsektor', 'action'
    ]);
    $this->action = 'Tambah';
}

    public function confirmDelete($id)
    {
        $this->id = $id;
        $data = KegiatanSurvei::findOrFail($id);
        $this->kegiatan = $data->kegiatan;
        $this->periode = $data->periode;
        $this->ketWaktu = '';

        $this->openWarningDelete = true;
    }

    public function delete($id)
    {
        KegiatanSurvei::findOrFail($id)->delete();

        if ($this->selectedKegiatan && $this->selectedKegiatan->id == $id) {
            $this->selectedKegiatan = null;
            $this->showDetail = false;
        }

        $this->openWarningDelete = false;
        $this->message = 'Kegiatan berhasil dihapus.';
        $this->status = 'Berhasil';
        $this->showNotif = true;

        session()->flash('success', 'Data kegiatan berhasil dihapus');
    }

    public function render()
    {
    
        $kegiatanSurvei = KegiatanSurvei::where('kegiatan', 'like', '%' . $this->search . '%')->get();

        return view('livewire.dashboard.manajemen-survei', [
            'kegiatanSurvei' => $kegiatanSurvei
        ]);
    }
}

