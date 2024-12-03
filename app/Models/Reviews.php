<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Reviews extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['customer_id', 'product_id', 'review'];


    public function customer(){
        return $this->belongsTo(User::class);
    }

    public function reviews(){
        return $this->belongsTo(product::class);
    }

}
