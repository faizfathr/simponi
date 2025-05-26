<?php

namespace App\Livewire\Dashboard;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Kalender extends Component
{
    #[Layout('livewire.index')]
    public function render()
    {
        return view('livewire.dashboard.kalender');
    }
}
