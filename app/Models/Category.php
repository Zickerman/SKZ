<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Category extends Model
{
    use AsSource;
    use Filterable;

    protected $fillable = ['category_id', 'name', 'description', 'available'];

    protected $allowedSorts = [
        'name'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class)->with('categories');
    }
    public function products(){
        return $this->hasMany(Product::class);
    }

}
