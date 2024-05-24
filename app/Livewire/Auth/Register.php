<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;

#[Layout('components.auth.main')]
class Register extends Component
{
    public $user_name;
    public $email;
    public $password;
    public $role_id = 3;

    public function render()
    {
        Session::flash('title', 'Đăng ký');

        return view('livewire.auth.register');
    }

    public function rules()
    {
        return [
            'user_name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return  [
            'user_name.required' => 'Tên đăng nhập không được để trống.',
            'user_name.unique' => 'Tên đăng nhập đã tồn tại.',
            'email.required' => 'E-mail không được để trống.',
            'email.email' => 'E-mail không hợp lệ.',
            'email.unique' => 'E-mail đã tồn tại.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu ít nhất phải 6 ký tự.',
        ];
    }

    public function register()
    {
        $this->validate();

        try {
            User::create([
                'user_name' => $this->user_name,
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
