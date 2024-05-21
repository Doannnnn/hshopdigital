<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

#[Layout('components.admin.main')]
class Dashboard extends Component
{
    public function render()
    {
        Session::put('user', Auth::user());

        Session::flash('title', 'Dashboard');

        return view('livewire.admin.dashboard');
    }
}
