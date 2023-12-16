<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class ArticleController extends BaseController
{
    public function articles(Request $request)
    {
        $orderMapping = [
            'created_at_desc' => ['created_at', 'desc'],
            'created_at_asc' => ['created_at', 'asc'],
            'priority_desc' => ['priority', 'desc'],
            'priority_asc' => ['priority', 'asc'],
        ];

        $orderBy = $request->input('sortOrder', 'created_at_desc');

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
}
