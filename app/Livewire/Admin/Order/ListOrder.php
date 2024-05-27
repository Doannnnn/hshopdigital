<?php

namespace App\Livewire\Admin\Order;

use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.admin.main')]
class ListOrder extends Component
{
    public function render()
    {
        Session::flash('title', 'Đơn hàng');

        return view('livewire.admin.order.list-order', [
            // 'users' => User::whereRelation('role', 'name', '!=', 'Admin')->paginate(7),
            'directory' => 'Danh sách',
        ]);
    }
}
