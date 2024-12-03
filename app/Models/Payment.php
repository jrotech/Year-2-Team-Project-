<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = ['date', 'invoice_number', 'customer_id', 'transaction_id', 'deleted'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_number');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
