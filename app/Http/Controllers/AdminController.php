<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Meeting;

class AdminController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user(); // Logged-in user
        $rooms = Room::all(); // Fetch all rooms

        // Fetch bookings only for the logged-in user
        $bookings = \App\Models\Booking::where('user_id', $user->id)->get();

        $invitations = $user->invitedMeetings()->with('attendees')->get();
        // Fetch meetings safely
        $meetings = Meeting::whereHas('booking', function($query) use ($user) {
            $query->where('user_id', $user->id); // employee's bookings
        })->with('attendees', 'booking')->get();

        // Ensure meetings is always a collection

        // Fetch other users (for meeting invites)
        $users = User::where('id', '!=', $user->id)->get();

        // Check the user's role and return the correct profile
        if ($user->role === 'admin') {
            return view('adminProfile', compact('user', 'rooms', 'invitations'));
        } elseif ($user->role === 'employee') {
            return view('employeeProfile', compact('user', 'rooms', 'bookings', 'users', 'meetings', 'invitations'));
        } elseif ($user->role === 'guest') {
            return view('guestProfile', compact('user', 'rooms', 'bookings', 'invitations'));
        }

        return redirect('/dashboard')->with('error', 'Unauthorized access.');
    }




    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:6',
            'dob' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update basic info
        $user->name = $request->name;
        $user->email = $request->email;
        $user->dob = $request->dob;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Update profile picture
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && \Storage::disk('public')->exists($user->profile_picture)) {
                \Storage::disk('public')->delete($user->profile_picture);
            }

            $user->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
