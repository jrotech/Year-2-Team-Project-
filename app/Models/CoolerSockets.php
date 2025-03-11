<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoolerSocket extends Model
{
    protected $table = 'cooler_sockets';

    protected $fillable = [
        'cooler_id',
        'socket_type'
    ];

    public function cooler()
    {
        return $this->belongsTo(CoolerProduct::class);
    }
}
