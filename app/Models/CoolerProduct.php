<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoolerProduct extends Model
{
    protected $table = 'cooler_products';

    protected $fillable = [
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
