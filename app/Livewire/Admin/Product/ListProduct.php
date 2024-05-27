<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('components.admin.main')]
class ListProduct extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function render()
    {
        Session::flash('title', 'Sản phẩm');

        return view('livewire.admin.product.list-product', [
            'products' => Product::paginate(7),
            'directory' => 'Danh sách',
        ]);
    }
}
