<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'nursery_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'position',
    ];

}
