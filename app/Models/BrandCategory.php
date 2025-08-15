<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class BrandCategory extends Model
{
    protected $fillable =
    [
        'brand_id', 'category_id'
    ];

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'id', 'category_id');
    }
}
