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
    public $timestamps = true;

    protected $primaryKey = ['invoice_id', 'product_id']; // Composite primary key
    public $incrementing = false; // Composite keys are not auto-incrementing
    protected $keyType = 'string'; // Adjust based on your column types

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
