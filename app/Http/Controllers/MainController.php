<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use App\Models\Article;
use Illuminate\Http\Request;

class MainController extends BaseController
{
    public function articles(Request $request)
    {
        $orderMapping = [
            'created_at_desc' => ['created_at', 'desc'],
            'created_at_asc' => ['created_at', 'asc'],
            'priority_desc' => ['priority', 'desc'],
            'priority_asc' => ['priority', 'asc'],
        ];

        $orderBy = $request->input('order_by', 'created_at_desc');

        if (!array_key_exists($orderBy, $orderMapping)) {
            $orderBy = 'created_at_desc';
        }

        list($orderByColumn, $orderDirection) = $orderMapping[$orderBy];

        $articles = Article::with('images')->orderBy($orderByColumn, $orderDirection)->paginate(16);

        $articles->each(function ($article) {
            $article->content = Str::limit($article->content, 80);

            $imagePathsString = $article->images->map(function ($image) {
                return asset('article_photos/' . $image->image_path . $image->image_name . '.' . $image->extension);
            })->implode(', ');

            $article->imagePathsString = $imagePathsString;
        });

        return view('frontend/main_page_info', compact('articles', 'orderBy'));
    }

    public function article($id)
    {
        $article = Article::find($id);

        $imagePathsString = $article->images->map(function ($image) {
            return asset('article_photos/'.$image->image_path.$image->image_name.'.'.$image->extension);
        })->implode(', ');

        $article->imagePathsString = $imagePathsString;

        return view('frontend/detail_article_page', compact('article'));
    }

    public function catalog()
    {
        $products = Product::with('category:id,name')->paginate(8);

        $products->each(function ($product) {
            $product->description = Str::limit($product->description, 80);

            $firstImage = $product->images->first();
            if ($firstImage) {
                $imagePath = asset('product_photos/' . $firstImage->image_path . $firstImage->image_name . '.' . $firstImage->extension);
                $product->image_path = $imagePath;
            }
        });

        return view('frontend/products', compact('products'));
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

    public function contacts()
    {
        return view('frontend/contacts');
    }

    public function about()
    {
        return view('frontend/about');
    }
}
