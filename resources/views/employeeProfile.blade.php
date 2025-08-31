@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <!-- Header + Logout -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Employee Dashboard</h2>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>

        <!-- Employee Info -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h4 class="mb-3 text-primary">My Information</h4>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
            </div>
        </div>

        <!-- Available Rooms -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h4 class="mb-3 text-success">Available Rooms</h4>
                @php
                    // Fetch rooms that are NOT booked
                    $availableRooms = $rooms->filter(function($room) {
                        return !$room->bookings->where('status', 'booked')->count();
                    });
                @endphp

                @if($availableRooms->isEmpty())
                    <p class="text-muted">No rooms available at the moment.</p>
                @else
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Room ID</th>
                            <th>Capacity</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($availableRooms as $room)
                            <tr>
                                <td>{{ $room->id }}</td>
                                <td>{{ $room->capacity }}</td>
                                <td>{{ $room->location }}</td>
                                <td>
                                    <form action="{{ route('employee.bookRoom', $room->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            Book Room
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- My Bookings -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h4 class="mb-3 text-info">My Bookings</h4>
                @if($bookings->isEmpty())
                    <p class="text-muted">You haven’t booked any rooms yet.</p>
                @else
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Booking ID</th>
                            <th>Room ID</th>
                            <th>Capacity</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>{{ $booking->room->id }}</td>
                                <td>{{ $booking->room->capacity }}</td>
                                <td>{{ $booking->room->location }}</td>
                                <td>
                                    @if($booking->status === 'booked')
                                        <span class="badge bg-success">Booked</span>
                                    @else
                                        <span class="badge bg-secondary">Canceled</span>
                                    @endif
                                </td>
                                <td>
                                    @if($booking->status === 'booked')
                                        <form action="{{ route('employee.cancelBooking', $booking->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Cancel Booking
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
