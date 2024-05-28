<?php

namespace App\Livewire\Admin\Product;

use App\Models\Category;
use App\Models\Image;
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
    public $category;
    public $images = [];
    public $uploadedImages = [];

    public function render()
    {
        Session::flash('title', 'Sản phẩm');

        return view('livewire.admin.product.add-product', [
            'categories' => Category::whereNotNull('parent_id')->get(),
            'directory' => 'Thêm sản phẩm',
        ]);
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'images' => 'required',
            'category' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm không được để trống.',
            'price.required' => 'Giá sản phẩm không được để trống.',
            'description.required' => 'Mô tả sản phẩm không được để trống.',
            'images.required' => 'Chọn hình ảnh.',
            'category.required' => 'Chọn danh mục.',
        ];
    }

    public function updatedImages()
    {
        foreach ($this->images as $image) {
            $exists = false;
            foreach ($this->uploadedImages as $uploadedImage) {
                if ($image->getClientOriginalName() === $uploadedImage->getClientOriginalName()) {
                    $exists = true;
                    break;
                }
            }
            if (!$exists) {
                $this->uploadedImages[] = $image;
            }
        }
    }

    public function removeImage($index)
    {
        unset($this->uploadedImages[$index]);
        $this->uploadedImages = array_values($this->uploadedImages);
    }

    public function addProduct()
    {
        $this->validate();

        $imagesPaths = [];

        foreach ($this->uploadedImages as $image) {
            $originalFilename = $image->getClientOriginalName();
            $imagePath = $image->storeAs('products', $originalFilename, 'public');
            $imagesPaths[] = 'storage/' . $imagePath;
        }

        try {
            $product = Product::create([
                'name' => $this->name,
                'price' => $this->price,
                'description' => $this->description,
                'category_id' => $this->category,
            ]);

            foreach ($imagesPaths as $path) {
                Image::create([
                    'url' => $path,
                    'product_id' => $product->id,
                ]);
            }

            Session::flash('success', 'Thêm mới thành công!');
            return redirect()->route('product-list');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
        }
    }
}
