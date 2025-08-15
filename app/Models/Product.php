<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable =
    [
        'brand_id', 'category_id', 'sku', 'name', 'short_desc', 'long_desc', 'regular_price',
        'sale_price', 'status', 'attribute', 'unit', 'rating', 'allow_reviews', 'images',
        'tags', 'stock', 'low_stock', 'is_free'
    ];
}
