<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.admin.main')]
class AddCategory extends Component
{
    public $category;
    public $select_category;
    public $product_category;
    public $categories;
    public $selected_value;
    public $category_type;

    public function mount()
    {
        $this->categories = Category::whereNull('parent_id')->get();
        $this->select_category = $this->categories->first()->id ?? '';
        $this->selected_value = 'category';
    }

    public function render()
    {
        Session::flash('title', 'Danh mục');

        return view('livewire.admin.category.add-category', [
            'directory' => 'Thêm danh mục',
        ]);
    }

    public function rules()
    {
        $rules = [];

        if ($this->selected_value === 'category' || $this->selected_value === 'both') {
            $rules['category'] = 'required|unique:categories,name';
        }

        if ($this->selected_value === 'product_category' || $this->selected_value === 'both') {
            $rules['product_category'] = 'required|unique:categories,name';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'category.required' => 'Tên danh mục chính không được để trống.',
            'category.unique' => 'Tên danh mục chính đã tồn tại.',
            'product_category.required' => 'Tên danh mục phụ không được để trống.',
            'product_category.unique' => 'Tên danh mục phụ đã tồn tại.',
        ];
    }

    public function updateCategorySelect()
    {
        $this->selected_value = $this->category_type;
    }

    public function addCategory()
    {
        $this->validate();

        try {
            if ($this->selected_value === 'category') {
                Category::create([
                    'name' => $this->category,
                ]);

                $message = 'Thêm danh mục thành công!';
            }

            if ($this->selected_value === 'product_category') {
                $mainCategory = Category::firstOrCreate(['id' => $this->select_category]);
                Category::create([
                    'name' => $this->product_category,
                    'parent_id' => $mainCategory->id,
                ]);

                $message = 'Thêm danh mục sản phẩm thành công!';
            }

            if ($this->selected_value === 'both') {
                $mainCategory = Category::create([
                    'name' => $this->category,
                ]);

                Category::create([
                    'name' => $this->product_category,
                    'parent_id' => $mainCategory->id,
                ]);

                $message = 'Thêm 2 danh mục thành công!';
            }

            Session::flash('success', $message);

            return redirect()->route('category-list');
        } catch (\Exception $e) {

            $this->dispatch('showToast', ['type' => 'error', 'message' => $e->getMessage('Thêm danh mục thất bại!')]);
        }
    }
}
