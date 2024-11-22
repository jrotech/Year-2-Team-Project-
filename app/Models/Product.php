<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['name', 'description', 'price', 'stock',"quantity"];

    public function basketItems()
    {
        return $this->hasMany(BasketItem::class);
    }

}
