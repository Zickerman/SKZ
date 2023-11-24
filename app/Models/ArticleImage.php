<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model
{
    protected $table = 'articles_images';
    protected $fillable = ['article_id', 'image_name', 'image_path', 'extension', 'priority'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

}
