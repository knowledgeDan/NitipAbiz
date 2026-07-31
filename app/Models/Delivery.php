<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'order_id',
        'courier_id',
        'status',
        'earnings',
        'picked_up_at',
        'delivered_at',
        'completed_at',
    ];
}
