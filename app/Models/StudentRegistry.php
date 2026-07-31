<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRegistry extends Model
{
    protected $table = 'student_registry';

    protected $fillable = [
        'school_id',
        'nis',
        'full_name',
        'status',
    ];
}
