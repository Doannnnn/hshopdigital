<?php

namespace App\Livewire\Admin\User;

use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('components.admin.main')]
class ListUser extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id;
    public $first_name;
    public $last_name;
    public $user_name;
    public $email;
    public $role;

    public function render()
    {
        Session::flash('title', 'Khách hàng');

        return view('livewire.admin.user.list-user', [
            'users' => User::whereRelation('role', 'name', '!=', 'Admin')->paginate(7),
            'roles' => Role::all(),
            'directory' => 'Danh sách',
        ]);
    }

    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ];
    }

    public function openEditModal($userId)
    {
        $user = User::findOrFail($userId);

        $this->id = $user->id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->user_name = $user->user_name;
        $this->email = $user->email;
        $this->role = $user->role_id;

        $this->dispatch('openModal');
    }

    public function updateUser()
    {
        $this->validate();

        $user = User::findOrFail($this->id);

        $data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'user_name' => $this->user_name,
            'email' =>  $this->email,
            'role_id' => $this->role,
        ];

        try {
            $user->update($data);

            $this->dispatch('closeModal');

            Session::flash('success', 'Cập nhập thành công!');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
        }
    }

    public function deleteUser($userId)
    {
        $user = User::find($userId);

        if ($user) {
            try {
                $user->delete();

                Session::flash('success', 'Xoá khách hàng thành công.');
            } catch (Exception $e) {
                Session::flash('error', $e->getMessage());
            }
        } else {
            Session::flash('error', 'Không tìm thấy khách hàng.');
        }
    }
}
