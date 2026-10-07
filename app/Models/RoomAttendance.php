<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RoomAttendance extends Model
{
    use HasFactory;

    public $timestamps = false;   

    protected $fillable = [
        'room_id',
        'child_id',
        'staff_id',
        'check_in_time',
        'check_out_time',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

}
