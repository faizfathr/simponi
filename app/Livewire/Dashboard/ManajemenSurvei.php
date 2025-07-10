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


class ManajemenSurvei extends Component
{
    use WithPagination, WithoutUrlPagination;
     public $showModal = false;
    public $nama;
    public $email;

    public function render()
    {
        return view('livewire.dashboard.manajemen-survei');
    }
}
