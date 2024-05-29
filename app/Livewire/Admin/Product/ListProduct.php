<?php

namespace App\Livewire\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('components.admin.main')]
class ListProduct extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads;

    public $id;
    public $name;
    public $price;
    public $description;
    public $category;
    public $images;
    public $uploadedImages;

    public function render()
    {
        Session::flash('title', 'Sản phẩm');

        return view('livewire.admin.product.list-product', [
            'products' => Product::paginate(5),
            'categories' => Category::whereNotNull('parent_id')->get(),
            'directory' => 'Danh sách',
        ]);
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'category' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm không được để trống.',
            'price.required' => 'Giá sản phẩm không được để trống.',
            'description.required' => 'Mô tả sản phẩm không được để trống.',
            'category.required' => 'Chọn danh mục sản phẩm.',
        ];
    }

    public function openEditModal($productId)
    {
        $product = Product::findOrFail($productId);

        $this->id = $product->id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->description = $product->description;
        $this->category = $product->category->id;
        $this->images = $product->images;

        $this->dispatch('openModal');
    }

    public function removeImage($index)
    {
        if ($this->images->offsetExists($index)) {
            unset($this->images[$index]);
        }
    }

    public function updateProduct()
    {
        $this->validate();

        $product = Product::findOrFail($this->id);

        $data = [
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'category_id' => $this->category,
        ];

        try {
            $product->update($data);

            if (empty($this->uploadedImages) && !empty($this->images)) {
                foreach ($this->images as $index => $image) {
                    if (!file_exists(public_path($image))) {
                        unset($this->images[$index]);
                    }
                }
            }

            $this->dispatch('closeModal');

            Session::flash('success', 'Cập nhập thành công!');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
        }
    }

    public function deleteProduct($productId)
    {
        $product = Product::find($productId);

        if ($product) {
            try {
                $product->delete();

                Session::flash('success', 'Xoá sản phẩm thành công.');
            } catch (Exception $e) {
                Session::flash('error', $e->getMessage());
            }
        } else {
            Session::flash('error', 'Không tìm thấy sản phẩm.');
        }
    }
}
