<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerSession extends Model
{
    protected $fillable = ['customer_id', 'session_token', 'expires_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }


    
}
