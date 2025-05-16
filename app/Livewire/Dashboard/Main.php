<?php

namespace App\Livewire\Dashboard;

use App\Models\Mitra;
use Livewire\Component;

class Main extends Component
{
    public function render()
    {
        $mitra = collect([
            'pcl' => Mitra::where('status', 1)->count(),
            'pml' => Mitra::where('status', 0)->count(),
        ]);
        return view('livewire.dashboard.main', compact('mitra'));
    }
}
