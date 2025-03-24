<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CPUProduct extends Model
{
    protected $table = 'cpu_products';

    protected $fillable = [
        'product_id',
        'socket_type',
        'tdp',
        'integrated_graphics',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
