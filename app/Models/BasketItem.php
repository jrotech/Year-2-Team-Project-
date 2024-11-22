<?php
/********************************
Developer: Abdullah Alharbi
University ID: 230046409
Function:
 ********************************/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BasketItem extends Model
{
    //
    protected $fillable = ['customer_id', 'product_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
