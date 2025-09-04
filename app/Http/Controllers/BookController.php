<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    // Book a room for a specific date and time slot
    public function bookRoom(Request $request, Room $room)
    {
        // Validate input
        $request->validate([
            'booking_date' => 'required|date',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
        ]);

        $bookingDate = $request->booking_date;
        $startTime   = $request->start_time;
        $endTime     = $request->end_time;

        // Check for conflicting bookings for the same room, date, and overlapping time
        $conflict = Booking::where('room_id', $room->id)
            ->where('booking_date', $bookingDate)
            ->where('status', 'booked')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();

        if ($conflict) {
            return redirect()->back()->with('error', 'This room is already booked for the selected time slot!');
        }

        // Create booking
        Booking::create([
            'user_id'      => Auth::id(),
            'room_id'      => $room->id,
            'booking_date' => $bookingDate,
            'start_time'   => $startTime,
            'end_time'     => $endTime,
            'status'       => 'booked',
        ]);

        return redirect()->back()->with('success', "Room booked successfully for $bookingDate from $startTime to $endTime!");
    }

    // Cancel a booking
    public function cancelBooking(Booking $booking)
    {
        if ($booking->user_id != Auth::id() && Auth::user()->role != 'admin') {
            return redirect()->back()->with('error', 'You are not allowed to cancel this booking.');
        }

        $booking->status = 'canceled';
        $booking->save();

        return redirect()->back()->with('success', 'Booking canceled successfully!');
    }

    // Get available rooms excluding booked ones
    public function getAvailableRooms(Request $request)
    {
        $date      = $request->booking_date ?? now()->toDateString();
        $startTime = $request->start_time ?? '00:00';
        $endTime   = $request->end_time ?? '23:59';

        // Get rooms that are NOT booked for the selected date and time
        $availableRooms = Room::whereDoesntHave('bookings', function ($query) use ($date, $startTime, $endTime) {
            $query->where('booking_date', $date)
                ->where('status', 'booked')
                ->where(function ($q) use ($startTime, $endTime) {
                    $q->whereBetween('start_time', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function ($q2) use ($startTime, $endTime) {
                            $q2->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);
                        });
                });
        })->get();

        return response()->json($availableRooms);
    }

    public function rescheduleBooking(Request $request, Booking $booking)
    {
        // Check authorization
        if ($booking->user_id != Auth::id() && Auth::user()->role != 'admin') {
            return redirect()->back()->with('error', 'You are not allowed to reschedule this booking.');
        }

        // Validate input
        $request->validate([
            'booking_date' => 'required|date',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
        ]);

        $bookingDate = $request->booking_date;

        // Append seconds to ensure MySQL time format
        $startTime = $request->start_time . ':00';
        $endTime = $request->end_time . ':00';

        // Check for conflicting bookings (excluding current booking)
        $conflict = Booking::where('room_id', $booking->room_id)
            ->where('booking_date', $bookingDate)
            ->where('status', 'booked')
            ->where('id', '!=', $booking->id)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();

        if ($conflict) {
            return redirect()->back()->with('error', 'This room is already booked for the selected time slot!');
        }

        // Update booking
        $booking->update([
            'booking_date' => $bookingDate,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        return redirect()->back()->with('success', 'Booking rescheduled successfully!');
    }



}
