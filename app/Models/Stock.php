<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';

    protected $primaryKey = 'product_id'; // Set primary key to product_id

    protected $fillable = ['product_id', 'quantity'];

    public $incrementing = false; // If product_id is not auto-incremented

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}