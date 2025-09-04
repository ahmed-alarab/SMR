@extends('layouts.app')

@section('content')
    <div class="container mt-3">

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
            <div class="d-flex align-items-center justify-content-between">
                <!-- Profile Picture -->
                <div class="me-4">
                    <img
                        src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.png') }}"
                        alt="Profile Picture"
                        class="rounded-circle"
                        width="120"
                        height="120"
                        style="object-fit: cover; border: 2px solid #007bff;"
                    >
                </div>

                <!-- Admin Information -->
                <div class="flex-grow-1">
                    <h4 class="mb-3 text-primary">Admin Information</h4>
                    <p><strong>Full Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                    @if($user->dob)
                        <p><strong>DOB:</strong> {{ $user->dob }}</p>
                    @endif
                    @if($user->phone)
                        <p><strong>Phone:</strong> {{ $user->phone }}</p>
                    @endif
                    @if($user->address)
                        <p><strong>Address:</strong> {{ $user->address }}</p>
                    @endif
                </div>

                <!-- Edit Profile Button -->
                <div>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        Edit Profile
                    </button>
                </div>
            </div>
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
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this room?')">
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

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.updateProfile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control">
                            @if($user->profile_picture)
                                <small class="text-muted">Current: {{ basename($user->profile_picture) }}</small>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="{{ $user->dob }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password <small class="text-muted">(optional)</small></label>
                            <input type="password" name="password" class="form-control" placeholder="Leave empty to keep current password">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
