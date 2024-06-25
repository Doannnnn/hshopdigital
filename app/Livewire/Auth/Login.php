<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.auth.main')]
class Login extends Component
{
    public $user_name;
    public $password;

    public function render()
    {
        Session::flash('title', 'Đăng nhập');

        return view('livewire.auth.login')->with('title', 'Đăng nhập');
    }

    public function rules()
    {
        return [
            'user_name' => 'required',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return  [
            'user_name.required' => 'Tên đăng nhập không được để trống.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu ít nhất phải 6 ký tự.',
        ];
    }

    public function login()
    {
        $this->validate();

        $isEmail = filter_var($this->user_name, FILTER_VALIDATE_EMAIL);

        if ($isEmail) {
            $credentials = [
                'email' => $this->user_name,
                'password' => $this->password,
            ];

            if (Auth::attempt($credentials)) {
                return redirect()->route('admin');
            } else {

                $this->dispatch('showToast', ['type' => 'error', 'message' => 'E-mail hoặc mật khẩu không chính xác!']);
            }
        } else {
            $credentials = [
                'phone' => $this->user_name,
                'password' => $this->password,
            ];

            if (Auth::attempt($credentials)) {

                return redirect()->route('admin');
            } else {

                $this->dispatch('showToast', ['type' => 'error', 'message' => 'Số điện thoại hoặc mật khẩu không chính xác!']);
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
