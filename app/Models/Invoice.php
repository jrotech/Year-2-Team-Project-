<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'amount',
        'status',
        'paid_date',
        'due_date',
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function payments()
    {}

    public function products()
    {
        return $this->belongsToMany(Product::class, 'invoice_products', 'invoice_id', 'product_id')
        ->withPivot('quantity','price');
    }
}
