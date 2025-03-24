<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Review extends Model
{
    use HasFactory;
    // Define the table name if it's not automatically inferred
    protected $table = 'reviews';

    // Define the fillable or guarded attributes to protect mass assignment
    protected $fillable = [
        'product_id',
        'customer_id',
        'rating',
        'comment',
    ];

    // Define the relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Define the relationship with the Customer model
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}