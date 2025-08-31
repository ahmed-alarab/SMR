<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\Booking;

class BookController extends Controller
{
    public function bookRoom(Room $room)
    {
        // Check if room is already booked
        $existingBooking = Booking::where('room_id', $room->id)
            ->where('status', 'booked')
            ->first();

        if ($existingBooking) {
            return redirect()->back()->with('error', 'This room is already booked!');
        }

        // Book the room
        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'status' => 'booked',
        ]);

        return redirect()->back()->with('success', 'Room booked successfully!');
    }

    // Cancel a booking
    public function cancelBooking(Booking $booking)
    {
        // Check if user can cancel
        if ($booking->user_id != Auth::id() && Auth::user()->role != 'admin') {
            return redirect()->back()->with('error', 'You are not allowed to cancel this booking.');
        }

        $booking->status = 'canceled';
        $booking->save();

        return redirect()->back()->with('success', 'Booking canceled successfully!');
    }
}
