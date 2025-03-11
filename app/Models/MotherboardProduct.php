<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotherboardProduct extends Model
{
    protected $table = 'motherboard_products';

    protected $fillable = [
        'product_id',
        'socket_type',
        'ram_type',
        'sata_storage_connectors',
        'm2_storage_connectors',
        
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
