<?php
/********************************
Developer: Abdullah Alharbi
University ID: 230046409
: Invoices Model
 ********************************/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceOrder extends Model
{
    protected $table = 'invoice_order';
    public $timestamps = false;

    protected $fillable = [
        'invoice_id',
        'product_cost',
        'product_id',
        'quantity'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
