<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Article extends Model
{
    use AsSource;
    use Filterable;

    protected $fillable = ['title', 'content', 'priority'];

    protected $allowedSorts = ['title', 'created_at', 'updated_at'];

    public function images(){
        return $this->hasMany(ArticleImage::class);
    }
}
