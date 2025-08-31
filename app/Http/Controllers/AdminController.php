<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Room;

class AdminController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user(); // Logged-in user
        $rooms = Room::all(); // Fetch all rooms

        // Fetch bookings only for the logged-in user
        $bookings = \App\Models\Booking::where('user_id', $user->id)->get();

        // Check the user's role and return the correct profile
        if ($user->role === 'admin') {
            return view('adminProfile', compact('user', 'rooms'));
        } elseif ($user->role === 'employee') {
            return view('employeeProfile', compact('user', 'rooms', 'bookings'));
        } elseif ($user->role === 'guest') {
            return view('guestProfile', compact('user', 'rooms', 'bookings'));
        }

        return redirect('/dashboard')->with('error', 'Unauthorized access.');
    }
}
