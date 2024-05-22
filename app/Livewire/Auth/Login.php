<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Login extends Component
{
    public $email_userName;
    public $password;

    public function render()
    {
        Session::flash('title', 'Đăng nhập');

        return view('livewire.auth.login')->with('title', 'Đăng nhập');
    }

    public function login()
    {
        $this->validate([
            'email_userName' => 'required|max:255',
            'password' => 'required|min:6',
        ]);

        $isEmail = filter_var($this->email_userName, FILTER_VALIDATE_EMAIL);

        if ($isEmail) {
            $credentials = [
                'email' => $this->email_userName,
                'password' => $this->password,
            ];

            if (Auth::attempt($credentials)) {
                return redirect()->route('admin');
            } else {
                Session::flash('error', 'Email hoặc mật khẩu không chính xác.');
            }
        } else {
            $credentials = [
                'user_name' => $this->email_userName,
                'password' => $this->password,
            ];

            if (Auth::attempt($credentials)) {
                return redirect()->route('admin');
            } else {
                Session::flash('error', 'Tên người dùng hoặc mật khẩu không chính xác.');
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
