<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    protected $fillable = ['user_id', 'room_id', 'status'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
