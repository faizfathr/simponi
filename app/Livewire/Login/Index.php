<?php

namespace App\Livewire\Login;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public string $username, $password;

    
    #[Layout('components.main-layout')]
    public function render()
    {
        return view('livewire.login.index');
    }

    public function login()
    {
        $this->validate(
            [
                'username' => 'required',
                'password' => 'required'
            ],
            [
                'username.required' => 'username wajib diisi',
                'password.required' => 'password wajib diisi',
            ]
    
    );

        $authenticated = Auth::attempt(['username' => $this->username, 'password' => $this->password]);
        if($authenticated) {
            session()->regenerate();
            return redirect()->route('home');
        }

        $this->addError('username', 'Username wajib diisi');
    }
}
