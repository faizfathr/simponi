<?php

namespace App\Livewire\WhatAppReminder;

use App\Services\FonteService;
use Livewire\Component;

class Test extends Component
{

    public $message = '';
    public $response;
    public $phone = '';

    public function render()
    {
        return view('livewire.what-app-reminder.test');
    }

    public function sendReminder(FonteService $fonte)
    {
        $this->response = $fonte->sendMessage($this->phone, $this->message);
    }
}
