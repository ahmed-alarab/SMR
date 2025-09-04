<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MeetingAttendee extends Model
{
    use HasFactory;

    protected $table = 'meeting_attendees';

    protected $fillable = [
        'meeting_id',
        'user_email',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}
