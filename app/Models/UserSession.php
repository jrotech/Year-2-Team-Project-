<?php
/********************************
Developer: Laravel
University ID: 00000000
********************************/
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    use HasFactory;

    protected $table = 'user_sessions';

    protected $fillable = ['user_id', 'session'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
