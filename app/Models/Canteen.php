<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Canteen extends Model
{
    protected $fillable = [
        'owner_id',
        'school_id',
        'name',
        'location',
        'description',
        'status',
    ];
}
