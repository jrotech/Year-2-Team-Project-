<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $table = 'baskets';

    protected $fillable = ['invoice_number', 'customer_id'];

    /**
     * Relationships
     */

    // Relation with Invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_number');
    }

    // Relation with Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Many-to-many relation with Product
    public function products()
    {
        return $this->belongsToMany(Product::class, 'basket_product')
                    ->withPivot('quantity') // Include quantity from pivot table
                    ->withTimestamps();
    }
}
