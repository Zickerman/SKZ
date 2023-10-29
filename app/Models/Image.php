<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = ['image_path', 'product_id', 'image_name', 'priority'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
