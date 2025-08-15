<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable =
    [
        'order_no', 'customer_id', 'opt_first_name', 'opt_middle_name', 'opt_last_name',
        'opt_phone', 'opt_email', 'subtotal', 'total', 'delivery_address',
        'delivery_location', 'delivery_instructions', 'payment_mode',
        'order_status', 'payment_status', 'fulfilment_status', 'return_status'
    ];
}
