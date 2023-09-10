<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class MainController extends BaseController
{
    public function index()
    {
        return view('frontend/main_page_info');
    }

    public function catalog()
    {
        $products = Product::with('category:id,name')->get();

        $products->each(function ($product) {
            $product->description = Str::limit($product->description, 80);
        });

        return view('frontend/products', compact('products'));
    }

    public function contacts()
    {
        return view('frontend/contacts');
    }

    public function about()
    {
        return view('frontend/about');
    }
}
