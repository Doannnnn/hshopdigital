<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\QueryException;

class CategoryService
{
    # Lấy tất cả danh mục
    public function findAll()
    {
        try {
            $categories = Category::all();

            return $categories;
        } catch (QueryException $e) {

            throw new \Exception("Error when retrieving category data: " . $e->getMessage(), 500);
        }
    }
}
