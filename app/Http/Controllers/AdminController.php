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
        $user = Auth::user(); // Logged-in admin
        $rooms = Room::all(); // Fetch all rooms

        return view('adminProfile', compact('user', 'rooms'));
    }

}
