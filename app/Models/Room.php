<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'nursery_id',
        'name',
        'capacity',
    ];

    public function nursery()
    {
        return $this->belongsTo(Nursery::class);
    }

    public function roomAttendances()
    {
        return $this->hasMany(RoomAttendance::class);
    }
}
