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
        $users = User::all(); // All users for invite
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
            'attendees.*'  => 'exists:users,id', // store user IDs
        ]);

        // Create the meeting
        $meeting = Meeting::create([
            'booking_id' => $booking->id,
            'title'      => $request->title,
            'agenda'     => $request->agenda,
        ]);

        // Attach attendees if provided
        if (!empty($request->attendees)) {
            // This will attach user IDs to the pivot table 'meeting_attendees'
            $meeting->attendees()->sync($request->attendees);
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

    /**
     * Invite additional guests to a meeting
     */
    public function inviteGuests(Request $request, $meetingId)
    {
        $request->validate([
            'guests' => 'required|array',
            'guests.*' => 'exists:users,id'
        ]);

        $meeting = Meeting::findOrFail($meetingId);

        // Add new guests without removing existing
        $meeting->attendees()->syncWithoutDetaching($request->guests);

        return redirect()->back()->with('success', 'Guests invited successfully!');
    }

    /**
     * Delete a meeting
     */
    public function deleteMeeting($meetingId)
    {
        $meeting = Meeting::findOrFail($meetingId);

        // Remove all attendees first
        $meeting->attendees()->detach();

        // Delete the meeting
        $meeting->delete();

        return redirect()->back()->with('success', 'Meeting deleted successfully!');
    }

    public function invite(Request $request, Meeting $meeting)
    {
        $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id'
        ]);

        // Attach new users without detaching existing ones
        $meeting->attendees()->syncWithoutDetaching($request->users);

        return redirect()->back()->with('success', 'Users invited successfully!');
    }
}
