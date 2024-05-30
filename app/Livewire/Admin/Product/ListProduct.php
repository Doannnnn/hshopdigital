<?php

namespace App\Livewire\Admin\Product;

use App\Models\Category;
use App\Models\Image;
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

        // Gán dữ liệu sản phẩm modal
        $this->id = $product->id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->description = $product->description;
        $this->category = $product->category->id;
        $this->images = $product->images;
        $this->uploadedImages = [];

        $this->dispatch('openModal'); // mở modal
    }

    public function removeImage($index, $source)
    {
        // Xoá hình ảnh của sản phẩm
        if ($source === 'images') {
            if ($this->images->offsetExists($index)) {
                unset($this->images[$index]);
            }
        }

        // Xoá hình ảnh thêm mới
        if ($source === 'uploadedImages') {
            if (isset($this->uploadedImages[$index])) {
                unset($this->uploadedImages[$index]);
            }
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
            $product->update($data); // cập nhập sản phẩm

            if (count($this->images) != $product->images->count()) {
                // Kiểm tra hình ảnh bị xóa
                $existingImages = $product->images;
                $remainingImages = collect($this->images);

                // Tìm hình ảnh đã bị loại bỏ
                $removedImages = $existingImages->filter(function ($image) use ($remainingImages) {
                    return !$remainingImages->contains('id', $image->id);
                });

                // Xóa các hình ảnh bị loại bỏ khỏi cơ sở dữ liệu
                foreach ($removedImages as $removedImage) {
                    $removedImage->delete();
                }
            }

            if (!empty($this->uploadedImages)) {
                $imagesPaths = [];

                // Thêm hình ảnh mới vào public/storage/products
                foreach ($this->uploadedImages as $image) {
                    $originalFilename = $image->getClientOriginalName();
                    $imagePath = $image->storeAs('products', $originalFilename, 'public');
                    $imagesPaths[] = 'storage/' . $imagePath;
                }

                // Thêm đường dẫn hình ảnh mới vào database
                foreach ($imagesPaths as $path) {
                    Image::create([
                        'url' => $path,
                        'product_id' => $product->id,
                    ]);
                }
            }

            $this->dispatch('closeModal'); // đóng modal

            $this->dispatch('showToast', ['type' => 'success', 'message' => 'Cập nhật sản phẩm thành công!']);
        
        } catch (Exception $e) {

            $this->dispatch('showToast', ['type' => 'error', 'message' => $e->getMessage('Cập nhật sản phẩm thất bại!')]);
        }
    }

    public function deleteProduct($productId)
    {
        $product = Product::find($productId);

        if ($product) {
            try {
                $product->delete();

                $this->dispatch('showToast', ['type' => 'success', 'message' => 'Xoá sản phẩm thành công!']);
            } catch (Exception $e) {

                $this->dispatch('showToast', ['type' => 'error', 'message' => $e->getMessage('Xoá sản phẩm thất bại!')]);
            }
        } else {

            $this->dispatch('showToast', ['type' => 'error', 'message' => 'Không tìm thấy sản phẩm!']);
        }
    }
}
