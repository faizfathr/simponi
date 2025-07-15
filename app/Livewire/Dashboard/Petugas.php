<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Mitra;
class Petugas extends Component
{
    public function render()
    {
        return view('livewire.dashboard.petugas');
    }
}
