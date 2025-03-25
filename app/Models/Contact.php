<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // Allow mass assignment for the following fields
    protected $fillable = ['name', 'subject', 'email', 'phone_number', 'message'];
}
