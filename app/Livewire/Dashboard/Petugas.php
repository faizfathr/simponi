<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Mitra;
use Illuminate\Validation\Rule;

class Petugas extends Component
{
    public $nama;
    public $no_rek;
    public $id;
    public $statusDb;
    public $search = '';
    public $openForm = false;
    public $status = '';
    public $message = '';
    public $showNotif = false;
    public $action = '';
    public $openWarningDelete = false;
    public function getRules()
    {
        return [
            'nama' => 'required|string|max:255',
            'no_rek' => 'required|numeric|digits:8',
            'statusDb' => 'required|in:0,1',
        ];
    }

    public function simpanData()
    {
        $this->validate([
            'nama' => 'required|string|max:255|regex:/^[a-zA-Z ]+$/',
            'no_rek' => [
                'required',
                'numeric',
                'digits:8',
                Rule::unique('mitra', 'no_rek')->where(function ($query) {
                    return $query->where('status', $this->statusDb);
                }),
            ],
            'statusDb' => 'required|in:0,1',
        ], [
            'nama.required' => 'Nama harus diisi',
            'nama.string' => 'Nama harus berupa huruf',
            'nama.max' => 'Nama maksimal 255 karakter',
            'nama.regex' => 'Nama hanya boleh berisi huruf dan spasi',
            'no_rek.required' => 'No rekening harus diisi',
            'no_rek.numeric' => 'No rekening harus berupa angka',
            'no_rek.digits' => 'No rekening harus berupa 8 digit angka',
            'no_rek.unique' => 'No rekening sudah terdaftar',
            'statusDb.required' => 'Status harus diisi',
            'statusDb.in' => 'Status harus pegawai atau kemitraan',
        ]);
        if ($this->action == 'Edit') {
                logger('UPDATE DIPANGGIL');
            $petugas = Mitra::findOrFail($this->id);
            $petugas->update([
                'nama' => $this->nama,
                'no_rek' => $this->no_rek,
                'status' => $this->statusDb,
            ]);

                   $this->message = "Petugas berhasil diperbaharui";
            $this->status = "success";
    session()->flash('success', 'Petugas berhasil diperbarui.');
  
            return;
        } else{
        do {
            $count = Mitra::where('status', $this->statusDb)->count();
            $generateId = $this->statusDb == 1
                ? 61720000 + $count + 1
                : 340000 + $count + 1;
        } while (Mitra::find($generateId));

        Mitra::create([
            'id' => $generateId,
            'nama' => $this->nama,
            'no_rek' => $this->no_rek,
            'status' => $this->statusDb,
        ]);


        $this->message = "Pegawai berhasil ditambahkan";
        $this->status = 'success';
   
    }
    $this->search = '';  
     $this->openForm = false;
$this->resetForm();
$this->showNotif = true;
$this->showNotif = true;
$this->openForm = false;

$this->resetForm();

// kirim event ke browser
$this->dispatch('formClosed');
$this->dispatch('notifShowed', message: $this->message, status: $this->status);
    }

    public function tambahForm()
    {
        $this->reset([
            'nama',
            'no_rek',
            'id',
            'action',
            'statusDb'
        ]);
        $this->action = 'tambah';
        $this->openForm = true;
    }

    public function resetForm()
    {
        $this->reset([
            'nama',
            'no_rek',
            'id',
            'action',
            'statusDb'
        ]);
        $this->action = 'Tambah';
    }

    public function editPetugas($id)
    {
        $petugas = Mitra::findOrFail($id);
        $this->id = $petugas->id;
        $this->nama = $petugas->nama;
        $this->no_rek = $petugas->no_rek;
        $this->statusDb = $petugas->status;
        $this->action = 'Edit';
        $this->openForm = true;
    }
    public function deletePetugas($id){
        Mitra::findOrFail($id)->delete();

        $this->openWarningDelete = false;
        $this->message = 'Kegiatan berhasil dihapus.';
        $this->status = 'Berhasil';
        $this->showNotif = true;

        session()->flash('success', 'Data kegiatan berhasil dihapus');
    
    }
    public function confirmDelete($id){
        $this->id = $id;
        $data = Mitra::findOrFail($id);
        $this->nama = $data->nama;
        $this->no_rek = $data->no_rek;
                $this->statusDb = $data->status;
        $this->openWarningDelete = true;
    }
    public function render()
    {
        $listPetugas = $this->search
            ? Mitra::where(function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhere('no_rek', 'like', '%' . $this->search . '%')
                    ->orWhere('id', 'like', '%' . $this->search . '%');
            })->get()
            : Mitra::all();

        return view('livewire.dashboard.petugas', [
            'listPetugas' => $listPetugas
        ]);
    }
}
