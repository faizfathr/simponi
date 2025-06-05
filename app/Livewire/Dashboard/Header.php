<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Header extends Component
{
    public function render()
    {
        return view('livewire.dashboard.header');
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        $this->dispatch('show-notif', action:true, message:'Logout berhasil');
        redirect()->route('home')->with('logout-valid', 'Anda telah berhasil logout');
    }
}
