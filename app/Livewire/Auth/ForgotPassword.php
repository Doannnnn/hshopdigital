<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.auth.main')]
class ForgotPassword extends Component
{
    public function render()
    {
        Session::flash('title', 'Quên mật khẩu');

        return view('livewire.auth.forgot-password');
    }
}
