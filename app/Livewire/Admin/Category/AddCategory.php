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
    public $main_category;
    public $main_category_select;
    public $sub_category;
    public $mainCategories;
    public $selected_value;
    public $category_select;

    public function mount()
    {
        $this->mainCategories = Category::whereNull('parent_id')->get();
        $this->main_category_select = $this->mainCategories->first()->id ?? '';
        $this->selected_value = 'main_category';
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

        if ($this->selected_value === 'main_category' || $this->selected_value === 'both') {
            $rules['main_category'] = 'required|unique:categories,name';
        }

        if ($this->selected_value === 'sub_category' || $this->selected_value === 'both') {
            $rules['sub_category'] = 'required|unique:categories,name';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'main_category.required' => 'Tên danh mục chính không được để trống.',
            'main_category.unique' => 'Tên danh mục chính đã tồn tại.',
            'sub_category.required' => 'Tên danh mục phụ không được để trống.',
            'sub_category.unique' => 'Tên danh mục phụ đã tồn tại.',
        ];
    }

    public function updateCategorySelect()
    {
        $this->selected_value = $this->category_select;
    }

    public function addCategory()
    {
        $this->validate();

        try {
            if ($this->selected_value === 'main_category') {
                Category::create([
                    'name' => $this->main_category,
                ]);

                $message = 'Thêm danh mục chính thành công';
            }

            if ($this->selected_value === 'sub_category') {
                $mainCategory = Category::firstOrCreate(['id' => $this->main_category_select]);
                Category::create([
                    'name' => $this->sub_category,
                    'parent_id' => $mainCategory->id,
                ]);

                $message = 'Thêm danh mục phụ thành công';
            }

            if ($this->selected_value === 'both') {
                $mainCategory = Category::create([
                    'name' => $this->main_category,
                ]);

                Category::create([
                    'name' => $this->sub_category,
                    'parent_id' => $mainCategory->id,
                ]);

                $message = 'Thêm 2 danh mục thành công';
            }

            session::flash('success', $message);

            return redirect()->route('category-list');
        } catch (\Exception $e) {
            session::flash('error', $e->getMessage());
        }
    }
}
