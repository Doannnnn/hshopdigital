<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService;
    }


    # Lấy tất cả danh mục
    public function getAllCategory()
    {
        try {
            $categories = $this->categoryService->findAll();

            return response()->json($categories, 200);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
