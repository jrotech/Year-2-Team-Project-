<?php
/********************************
Developer:Robert Oros, Kai Lowe-Jones, Abdullah Alharbi
University ID: 230237144, 230234682, 230046409
********************************/
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

    // Relation with images
    public function images()
    {
        return $this->hasMany(Image::class, 'product_id');
    }

    // Relation with Stock
    public function stock()
    {
        return $this->hasOne(Stock::class, 'product_id');
    }

    // Many-to-many relation with Basket
    public function baskets()
    {
        return $this->belongsToMany(Basket::class, 'basket_product')
                    ->withPivot('quantity') // Include quantity from pivot table
                    ->withTimestamps();
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

    // Relation with Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    /**
     * Get the average rating for this product
     *
     */
    public function getAverageRatingAttribute()
    {
        // If there are no reviews, return null
        if ($this->reviews()->count() === 0) {
            return null;
        }

        return $this->reviews()->avg('rating');
    }

    /**
     * Get the total number of reviews for this product
     *
     */
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
}
