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
    public $name;

    public function render()
    {
        Session::flash('title', 'Danh mục');

        return view('livewire.admin.category.add-category', [
            'directory' => 'Thêm mới',
        ]);
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:categories',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique' => 'Tên danh mục đã tồn tại.',
        ];
    }

    public function addCategory()
    {
        $this->validate();

        try {
            Category::create([
                'name' => $this->name,
            ]);

            Session::flash('success', 'Thêm mới thành công!');

            redirect()->route('category-list');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
        }
    }
}
