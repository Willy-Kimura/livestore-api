<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable =
    [
        'code', 'description', 'amount', 'percentage', 'uses',
        'max_uses', 'is_fixed', 'starts_at', 'expires_at'
    ];
}
