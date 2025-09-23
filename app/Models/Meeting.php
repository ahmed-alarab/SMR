<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Booking;
use App\Models\MeetingAttendee;
use App\Models\User;

class Meeting extends Model

{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'title',
        'agenda',
    ];
    public function booking() {
        return $this->belongsTo(Booking::class);
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'meeting_user', 'meeting_id', 'user_id')
            ->withTimestamps();
    }


}
