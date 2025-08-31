@extends('layouts.app')

@section('content')
    <div class="container mt-3"> <!-- Reduced top margin to remove whitespace -->

        <!-- Header + Logout -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Admin Dashboard</h2>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>

        <!-- Admin Info Card -->
        <div class="card shadow-sm border-0 mb-5 p-4">
            <h4 class="mb-3 text-primary">Admin Information</h4>
            <p><strong>Full Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
        </div>

        <!-- Rooms Management -->
        <div class="card shadow-sm border-0 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-success">Manage Rooms</h4>
                <a href="{{ route('rooms.create') }}" class="btn btn-primary">+ Add New Room</a>
            </div>

            <!-- Rooms Table -->
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Capacity</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($rooms as $room)
                    <tr>
                        <td>{{ $room->id }}</td>
                        <td>{{ $room->capacity }}</td>
                        <td>{{ $room->location }}</td>
                        <td>
                            <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this room?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No rooms available</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
