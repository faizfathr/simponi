<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Mitra;

class Petugas extends Component
{
    public $search = '';
    public $openForm = false;
    public $status = '';
    public $message = '';
    public $showNotif = false;
    public $action= '';

    public function simpanData()
    {
        $generateId = bin2hex(hash('sha256', $this->kegiatan . now()->timestamp . uniqid(), true));

        Mitra::create([
            'id' => $generateId,
            'nama' => $this->nama,
            'no_rek' => $this->no_rek,
            'status' => $this->status,
        ]);

        $this->message = "Pegawai berhasil ditambahkan";
        $this->status = "success";

        $this->search = '';
        $this->openForm = false;
        $this->resetForm();
        $this->showNotif = true;
    }

    public function tambahForm()
    {
        $this->reset([
            'nama', 'no_rek', 'id', 'action', 'status'
        ]);
        $this->action = 'tambah';
        $this->openForm = true;
    }

    public function render()
    {
        $listPetugas = Mitra::where(function ($query) {
            $query->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%')
                ->orWhere('no_rek', 'like', '%' . $this->search . '%')
                ->orWhere('id', 'like', '%' . $this->search . '%');
        })->get();

        return view('livewire.dashboard.petugas', [
            'listPetugas' => $listPetugas
        ]);
    }
}

