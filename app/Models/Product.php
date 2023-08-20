<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Product extends Model
{
    use AsSource;
    use Filterable;

    protected $fillable = ['category_id', 'name', 'description', 'price', 'available', 'amount'];

    protected $allowedSorts = [
        'name'
    ];

}
