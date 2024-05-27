<?php

namespace App\Livewire\Admin\User;

use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.admin.main')]
class AddUser extends Component
{
    public $first_name;
    public $last_name;
    public $user_name;
    public $email;
    public $password;
    public $role;

    public function render()
    {
        Session::flash('title', 'Khách hàng');

        return view('livewire.admin.user.add-user', [
            'roles' => Role::all(),
            'directory' => 'Thêm mới',
        ]);
    }

    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|exists:roles,id',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Tên không được để trống.',
            'last_name.required' => 'Họ không được để trống.',
            'user_name.required' => 'Tên người dùng không được để trống.',
            'user_name.unique' => 'Tên tài khoản đã tồn tại.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Địa chỉ E-mail không hợp lệ.',
            'email.unique' => 'E-mail đã tồn tại.',
            'password.required' => 'Mật khẩu hiện tại không được để trống.',
            'password.min' => 'Mật khẩu ít nhất phải 6 ký tự.',
            'role.required' => 'Bắt buộc chọn role.',
            'role.exists' => 'Role không hợp lệ.',
        ];
    }

    public function addUser()
    {
        $this->validate();

        try {
            User::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'user_name' => $this->user_name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role_id' => $this->role,
            ]);

            Session::flash('success', 'Thêm mới thành công!');

            redirect()->route('user-list');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
        }
    }
}
