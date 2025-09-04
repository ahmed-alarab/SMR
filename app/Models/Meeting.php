<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Booking;
use App\Models\MeetingAttendee;

class Meeting extends Model

{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'title',
        'agenda',
        'attendees', // JSON column
    ];
    public function booking() {
        return $this->belongsTo(Booking::class);
    }

    public function attendees() {
        return $this->hasMany(MeetingAttendee::class, 'meeting_id');
    }
}
