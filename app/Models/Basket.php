<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $table = 'basket';

    protected $fillable = ['invoice_number', 'product_cost', 'product_id', 'quantity', 'customer_id'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_number');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
