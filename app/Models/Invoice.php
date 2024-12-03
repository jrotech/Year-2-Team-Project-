<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'date',
        'customer_id',
        'invoice_number',
        'invoice_amount',
        'delivery_option',
        'status',
        'deleted',
    ];


    // Relation with Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relation with Delivery
    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'invoice_number');
    }

    // Relation with Payments
    public function payments()
    {
        return $this->hasMany(Payment::class, 'invoice_number');
    }

    // Relation with Basket
    public function basket()
    {
        return $this->hasMany(Basket::class, 'invoice_number');
    }

    // Relation with InvoiceOrder (if needed)
    public function invoiceOrders()
    {
        return $this->hasMany(InvoiceOrder::class, 'invoice_number');
    }
}
