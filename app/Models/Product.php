<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'description',
        'in_stock',
        'deleted',
    ];

    /**
     * Relationships
     */

    // Relation with Stock
    public function stock()
    {
        return $this->hasOne(Stock::class, 'product_id');
    }

    // Relation with Basket
    public function baskets()
    {
        return $this->hasMany(Basket::class, 'product_id');
    }

    // Relation with Product Categories (many-to-many)
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'product_categories',
            'product_id',
            'category_id'
        );
    }
}
