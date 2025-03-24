<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GPUProduct extends Model
{
    protected $table = 'gpu_products';

    protected $fillable = [
        'product_id',
        'tdp',
        
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
