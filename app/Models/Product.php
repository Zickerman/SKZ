<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Product extends Model
{
    use AsSource;
    use Filterable;
    use Attachable;

    protected $fillable = ['category_id', 'name', 'description', 'price', 'available', 'amount', 'volume'];

    protected $allowedSorts = [
        'name'
    ];

    public function category(){
        return $this->BelongsTo(Category::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

}
