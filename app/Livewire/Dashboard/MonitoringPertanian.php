<?php

namespace App\Livewire\Dashboard;

use App\Models\Subsektor;
use Livewire\Component;

class MonitoringPertanian extends Component
{
    public $idMonitoring = 3;

    public function render()
    {
        $subsektor = Subsektor::where('id', '>', 2)->get();
        return view('livewire.dashboard.monitoring-pertanian', compact('subsektor'));
    }

    public function updateItem($item)
    {
        $this->idMonitoring = $item;
        $this->dispatch('updateSubmonitoring', id:$item);
    }


}
