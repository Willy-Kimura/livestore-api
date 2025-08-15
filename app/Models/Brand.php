<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable =
    [
        'name', 'country', 'homepage', 'description', 'logo'
    ];

    public function categories()
    {
        return $this->hasMany(BrandCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
