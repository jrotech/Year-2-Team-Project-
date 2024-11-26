<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'price', 'description', 'in_stock'];

    public function categories()
    {
        return $this->belongsToMany(Category::class,'product_categories', 'product_id', 'category_id');
    }
}
