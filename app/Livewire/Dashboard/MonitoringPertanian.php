<?php

namespace App\Livewire\Dashboard;

use App\Models\Subsektor;
use Livewire\Component;

class MonitoringPertanian extends Component
{
    public $itemMonitoring = 'STATISTIK PETERNAKAN, PERIKANAN, DAN KEHUTANAN';

    public function render()
    {
        $subsektor = Subsektor::where('id', '>', 2)->get();
        return view('livewire.dashboard.monitoring-pertanian', compact('subsektor'));
    }

    public function updateItem($item)
    {
        $this->itemMonitoring = $item;
    }


}
