<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = ['customer_name', 'email', 'phone_number', 'email_confirmed', 'prev_balance', 'password'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'customer_id');
    }
}
