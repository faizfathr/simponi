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
                
                'password' => 'required',
                   'username' => ['required', function ($attribute, $value, $fail) {
                if (!Auth::attempt(['username' => $value, 'password' => $this->password])) {
                    $user = Auth::user();
                    if (!$user) {
                        $fail('Username tidak dikenali.');
                    } else if ($user && $user->password != bcrypt($this->password)) {
                        $fail('Password salah, coba lagi.');
                    }
                }
            }]
            ],
            [
                'username.required' => 'Username wajib diisi.',
                'password.required' => 'Password wajib diisi.',
            ]
    
    );

        $authenticated = Auth::attempt(['username' => $this->username, 'password' => $this->password]);
        if($authenticated) {
            session()->regenerate();
            return redirect()->route('home')->with('login-valid', 'Selamat datang, ' . Auth::user()->name);
        }

        $this->addError('username', 'Username wajib diisi', );
        $this->addError('password', 'Password wajib diisi', );
        $this->username = '';
        $this->password = '';
    }
}
