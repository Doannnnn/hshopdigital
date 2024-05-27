<?php

namespace App\Livewire\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Livewire\WithFileUploads;

#[Layout('components.admin.main')]
class AddProduct extends Component
{

    use WithFileUploads;

    public $name;
    public $price;
    public $description;
    public $image;
    public $category;

    public function render()
    {
        Session::flash('title', 'Sản phẩm');

        return view('livewire.admin.product.add-product', [
            'categories' => Category::all(),
            'directory' => 'Thêm mới',
        ]);
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image' => 'required',
            'category' => 'required|exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm không được để trống.',
            'price.required' => 'Giá sản phẩm không được để trống.',
            'description.required' => 'Mô tả sản phẩm không được để trống.',
            'image.required' => 'Hình ảnh không được để trống.',
            'category.required' => 'Danh mục không được để trống.',
        ];
    }

    public function addProduct()
    {
        $this->validate();

        if ($this->image) {
            $originalFilename = $this->image->getClientOriginalName();
            $imagePath = $this->image->storeAs('products', $originalFilename, 'public');

            $image = 'storage/' . $imagePath;
        }

        try {
            Product::create([
                'name' => $this->name,
                'price' => $this->price,
                'description' => $this->description,
                'image' => $image,
                'category_id' => $this->category,
            ]);

            Session::flash('success', 'Thêm mới thành công!');

            redirect()->route('product-list');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
        }
    }
}
