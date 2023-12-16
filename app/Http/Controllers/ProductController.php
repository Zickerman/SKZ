<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function catalog(Request $request)
    {
        $currentCategoryId = $request->input('categorySubcategory');
        $currentVolume = $request->input('volume');

        $categorySubcategory = $this->getCategorySubcategory($currentVolume);

        $volumes = $this->getVolumes($currentCategoryId);

        $orderBy = $this->getOrderBy($request);

        $productsQuery = $this->getOrderedProducts($currentCategoryId, $currentVolume, $orderBy);

        $products = $productsQuery->paginate(8);

        $products->each(function ($product) {
            $product->description = Str::limit($product->description, 80);

            $firstImage = $product->images->first();
            if ($firstImage) {
                $imagePath = asset('product_photos/'.$firstImage->image_path.$firstImage->image_name.'.'.$firstImage->extension);
                $product->image_path = $imagePath;
            }
        });

        return view('frontend/products', compact('products', 'orderBy', 'categorySubcategory', 'volumes', 'currentCategoryId', 'currentVolume'));
    }

    private function getCategorySubcategory($currentVolume)
    {
        $categorySubcategory = Category::whereHas('products', function ($query) use ($currentVolume) {
            if ($currentVolume && $currentVolume !== 'Все') {
                $query->where('volume', $currentVolume);
            }
        })->pluck('id', 'name');

        return collect(["Все" => 0])->merge($categorySubcategory);
    }

    private function getVolumes($currentCategoryId)
    {
        $volumesQuery = Product::when($currentCategoryId && $currentCategoryId !== 'Все', function ($query) use ($currentCategoryId) {
            $query->where('category_id', $currentCategoryId);
        })
            ->distinct()
            ->selectRaw('TRIM(TRAILING "0" FROM volume) as volume');

        $volumes = $volumesQuery->pluck('volume')->map(fn($volume) => floatval($volume));

        if ($volumes->count() > 1) {
            $volumes->prepend("Все", 0);
        }

        return $volumes;
    }

    private function getOrderBy($request)
    {
        $orderMapping = [
            'expensive' => ['price', 'desc'],
            'cheap' => ['price', 'asc'],
            'natural_order' => ['id', 'asc'],
        ];

        $orderBy = $request->input('sortOrder', 'natural_order');

        if (!array_key_exists($orderBy, $orderMapping)) {
            $orderBy = 'natural_order';
        }

        return $orderMapping[$orderBy];
    }

    private function getOrderedProducts($currentCategoryId, $currentVolume, $orderBy)
    {
        list($orderByColumn, $orderDirection) = $orderBy;

        $productsQuery = Product::with('category:id,name')->orderBy($orderByColumn, $orderDirection);

        if ($currentCategoryId) {
            $productsQuery->where('category_id', $currentCategoryId);
        }
        if ($currentVolume && $currentVolume !== 'Все') {
            $productsQuery->where('volume', $currentVolume);
        }
        return $productsQuery;
    }

    public function product($id)
    {
        $product = Product::find($id);

        $imagePathsString = $product->images->map(function ($image) {
            return asset('product_photos/'.$image->image_path.$image->image_name.'.'.$image->extension);
        })->implode(', ');

        $product->imagePathsString = $imagePathsString;

        return view('frontend/detail_product_page', compact('product'));
    }

}
