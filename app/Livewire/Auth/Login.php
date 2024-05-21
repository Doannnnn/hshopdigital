<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Login extends Component
{
    public $email_username;
    public $password;

    public function rules()
    {
        return [
            'email_username' => 'required|max:255',
            'password' => 'required|min:8',
        ];
    }

    public function render()
    {
        Session::flash('title', 'Đăng nhập');

        return view('livewire.auth.login')->with('title', 'Đăng nhập');
    }

    public function login()
    {
        $isEmail = filter_var($this->email_username, FILTER_VALIDATE_EMAIL);

        if ($isEmail) {
            $credentials = [
                'email' => $this->email_username,
                'password' => $this->password,
            ];

            if (Auth::attempt($credentials)) {
                return redirect()->to('/');
            } else {
                Session::flash('error', 'Email hoặc mật khẩu không chính xác.');
            }
        } else {
            $credentials = [
                'username' => $this->email_username,
                'password' => $this->password,
            ];

            if (Auth::attempt($credentials)) {
                return redirect()->to('/');
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
