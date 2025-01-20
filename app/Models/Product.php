<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'color',
        'size',
        'stock',
        'sku',
        'is_active',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'product_id');
    }

}
