<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageProduct extends Model
{
    protected $table = 'storage_products';

    protected $fillable = [
        'product_id',
        'connector_type',
        
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
