<?php
/********************************
Developer: Abdullah Alharbi
University ID: 230046409
: Invoices Model
 ********************************/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'date',
        'customer_id',
        'invoice_number',
        'invoice_amount',
        'delivery_option',
        'status'
    ];

    protected $dates = ['date', 'deleted_at'];

    public function orderItems()
    {
        return $this->hasMany(InvoiceOrder::class, 'invoice_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class); // or User::class depending on your setup
    }
}
