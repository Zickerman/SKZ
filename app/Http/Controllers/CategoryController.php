<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Routing\Controller as BaseController;

class CategoryController extends BaseController
{
    public function index()
    {
        $categories = Category::whereNull('category_id')
            ->with('childrenCategories')
            ->get();
        return $categories; // !!! заменить на view или ресурс !!!
    }
}
