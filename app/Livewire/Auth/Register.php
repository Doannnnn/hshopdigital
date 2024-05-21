<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class Register extends Component
{
    public $username;
    public $email;
    public $password;
    public $role_id = 3;

    public function rules()
    {
        return [
            'username' => 'required|unique:users|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8',
        ];
    }

    public function render()
    {
        Session::flash('title', 'Đăng ký');

        return view('livewire.auth.register')->with(['title' => 'Đăng ký']);
    }

    public function register()
    {
        $this->validate();

        try {
            User::create([
                'username' => $this->username,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role_id' => $this->role_id,
            ]);

            Session::flash('success', 'Đăng ký thành công!');

            return redirect()->route('login');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());

            return redirect()->back();
        }
    }
}
