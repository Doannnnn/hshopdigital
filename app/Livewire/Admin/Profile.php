<?php

namespace App\Livewire\Admin;

use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

#[Layout('components.admin.main')]
class Profile extends Component
{
    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $user_name;
    public $email;
    public $current_password;
    public $new_password;
    public $confirm_new_password;
    public $avatar;

    public function mount()
    {
        $this->first_name = session('user')->first_name;
        $this->last_name = session('user')->last_name;
        $this->email = session('user')->email;
        $this->user_name = session('user')->user_name;
    }

    public function render()
    {
        Session::flash('title', 'Thông tin tài khoản');

        return view('livewire.admin.profile');
    }

    public function rules()
    {
        $user = session('user');

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required|unique:users,user_name,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
        ];

        if (!empty($this->current_password)) {
            $rules += [
                'current_password' => 'required|current_password',
                'new_password' => 'required|min:6',
                'confirm_new_password' => 'required|same:new_password',
            ];
        }

        if (!empty($this->avatar)) {
            $rules += [
                'avatar' => 'image|max:800',
            ];
        }

        return $rules;
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
            'current_password.required' => 'Mật khẩu hiện tại không được để trống.',
            'current_password.current_password' => 'Mật khẩu hiện tại không chính xác.',
            'new_password.required' => 'Mật khẩu mới không được để trống.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'confirm_new_password.required' => 'Vui lòng xác nhận mật khẩu mới.',
            'confirm_new_password.same' => 'Xác nhận mật khẩu mới không khớp.',
            'avatar.image' => 'File ảnh không hợp lệ.',
            'avatar.max' => 'Kích thước file ảnh quá lớn. Hãy chọn file nhỏ hơn 1MB.',
        ];
    }

    public function updateProfile()
    {
        $this->validate();

        $user = session('user');

        if ($this->avatar) {
            $originalFilename = $this->avatar->getClientOriginalName();
            $avatarPath = $this->avatar->storeAs('avatars', $originalFilename, 'public');

            $avatar = 'storage/' . $avatarPath;
        } else {
            $avatar = $user->avatar;
        }

        $data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'user_name' => $this->user_name,
            'email' =>  $this->email,
            'avatar' => $avatar,
        ];

        if (!empty($this->new_password)) {
            $data['password'] = Hash::make($this->new_password);
        }

        try {
            $user->update($data);

            session(['user' => $user]);

            Session::flash('success', 'Cập nhật thành công.');

            redirect()->route('profile');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());

            return redirect()->back();
        }
    }
}
