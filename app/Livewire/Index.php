<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\On;

class Index extends Component
{
    public bool $showNotif = false;
    public string $message = '';
    public $idPage = null;

    public function mount($id = null)
    {
        $this->idPage = $id;
    }

    #[Layout('components.main-layout')]
    public function render()
    {
        return view('livewire.index', [
            'idPage' => $this->idPage,
        ]);
    }

    #[On('show-notif')]
    public function openNotif($action, $message)
    {
        logger($action);
        $this->showNotif = $action;
        $this->message = $message;
    }
}
