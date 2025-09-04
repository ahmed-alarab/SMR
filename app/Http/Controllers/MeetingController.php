<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Meeting;
use App\Models\MeetingAttendee;
use App\Models\User;

class MeetingController extends Controller
{
    /**
     * Show the create meeting form
     */
    public function create(Booking $booking)
    {
        $users = User::all(); // All internal users
        return view('meetings.create', compact('booking', 'users'));
    }

    /**
     * Store a new meeting and attendees
     */
    public function store(Request $request, Booking $booking)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'agenda'       => 'nullable|string',
            'attendees'    => 'nullable|array',
            'attendees.*'  => 'email', // We'll store emails instead of IDs
        ]);

        // Create meeting
        $meeting = Meeting::create([
            'booking_id' => $booking->id,
            'title'      => $request->title,
            'agenda'     => $request->agenda,
        ]);

        // Add attendees if any
        if (!empty($request->attendees)) {
            foreach ($request->attendees as $email) {
                MeetingAttendee::create([
                    'meeting_id' => $meeting->id,
                    'user_email' => $email,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Meeting scheduled successfully!');
    }

    /**
     * Show all meetings for a booking
     */
    public function show(Booking $booking)
    {
        $meetings = $booking->meetings()->with('attendees')->get();
        return view('meetings.index', compact('booking', 'meetings'));
    }
}
