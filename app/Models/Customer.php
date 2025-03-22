<?php
/********************************
Developer:Kai Lowe-Jones
University ID: 230234682
********************************/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Customer extends Authenticatable
{
    use HasFactory;
    protected $fillable = ['customer_name', 'email', 'phone_number', 'email_confirmed', 'password','google_id'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'customer_id');
    }
}
