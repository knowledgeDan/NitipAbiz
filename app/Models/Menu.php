<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'canteen_id',
        'name',
        'category',
        'description',
        'price',
        'stock',
        'image',
        'status',
    ];
}
