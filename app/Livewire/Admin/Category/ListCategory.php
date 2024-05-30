<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('components.admin.main')]
class ListCategory extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id;
    public $product_category;
    public $category;
    public $category_type;

    public function mount()
    {
        $this->category_type = 'child';
    }

    public function render()
    {
        Session::flash('title', 'Danh mục');

        return view('livewire.admin.category.list-category', [
            'categories' => Category::whereNull('parent_id')->get(),
            'listCategory' => Category::whereNull('parent_id')->paginate(5),
            'product_categories' => Category::whereNotNull('parent_id')->paginate(5),
            'directory' => 'Danh sách',
        ]);
    }

    public function rules()
    {
        return [
            'product_category' => 'required',
            'category' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'product_category.required' => 'Danh mục sản phẩm không được để trống.',
            'category.required' => 'Danh mục không được để trống.',
        ];
    }

    public function updateSelectType()
    {
        $this->category_type = $this->category_type;
    }

    public function openEditModal($categoryId, $source)
    {
        $category = Category::findOrFail($categoryId);

        if ($source === 'product_category') {
            $this->id = $category->id;
            $this->product_category = $category->name;
            $this->category = $category->parent_id;
        }

        if ($source === 'category') {
            $this->id = $category->id;
            $this->category = $category->name;
        }

        $this->dispatch('openModal');
    }

    public function updateCategory()
    {
        $this->validate();

        $category = Category::findOrFail($this->id);

        $data = [
            'name' => $this->product_category,
            'parent_id' => $this->category,
        ];

        try {
            $category->update($data);

            $this->dispatch('closeModal');

            $this->dispatch('showToast', ['type' => 'success', 'message' => 'Cập nhập danh mục thành công!']);
        } catch (Exception $e) {

            $this->dispatch('showToast', ['type' => 'error', 'message' => $e->getMessage('Cập nhập danh mục thất bại!')]);
        }
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);

        if ($category) {
            try {
                $category->delete();

                $this->dispatch('showToast', ['type' => 'success', 'message' => 'Xoá danh mục thành công!']);
            } catch (Exception $e) {

                $this->dispatch('showToast', ['type' => 'error', 'message' => $e->getMessage('Xoá danh mục thất bại!')]);
            }
        } else {

            $this->dispatch('showToast', ['type' => 'error', 'message' => 'Không tìm thấy danh mục!']);
        }
    }
}
