<?php
/********************************
Developer: Abdullah Alharbi, Robert Oros,
University ID: 230046409, 230237144
********************************/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceOrder extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'product_cost',
        'quantity',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
