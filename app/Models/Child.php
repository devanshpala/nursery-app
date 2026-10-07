<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'nursery_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'address',
        'guardian_name',
        'guardian_contact',
    ];

    
}
