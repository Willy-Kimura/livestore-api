<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;

class Category extends Model
{
    protected $fillable =
    [
        'name', 'description'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
