<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'canteen_id',
        'courier_id',
        'status',
        'subtotal',
        'delivery_fee',
        'total',
        'delivery_address',
        'notes',
    ];
}
