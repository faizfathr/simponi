<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Subsektor;

class MonitoringIpek extends Component
{
    public $idMonitoring = 1;

    public function render()
    {
        $subsektorIpek = Subsektor::where('id', '<', 3)->get();
        return view('livewire.dashboard.monitoring-ipek', compact('subsektorIpek'));
    }

    public function updateItem($item)
    {
        $this->idMonitoring = $item;
        $this->dispatch('updateSubmonitoring', id:$item);
    }
}
