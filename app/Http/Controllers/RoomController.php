<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function create()
    {
        return view('createRoom'); // Blade view for creating a room
    }

    /**
     * Store a new room in the database
     */
    public function store(Request $request)
    {
        $request->validate([
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
        ]);

        Room::create([
            'capacity' => $request->capacity,
            'location' => $request->location,
        ]);

        return redirect()->route('admin.profile')->with('success', 'Room created successfully.');
    }

    /**
     * Show the form to edit an existing room
     */
    public function edit(Room $room)
    {
        return view('editRoom', compact('room')); // Blade view for editing
    }

    /**
     * Update an existing room in the database
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
        ]);

        $room->update([
            'capacity' => $request->capacity,
            'location' => $request->location,
        ]);

        return redirect()->route('admin.profile')->with('success', 'Room updated successfully.');
    }

    /**
     * Delete a room from the database
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('admin.profile')->with('success', 'Room deleted successfully.');
    }
}
