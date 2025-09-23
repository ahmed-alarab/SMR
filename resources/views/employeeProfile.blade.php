@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <!-- Header + Logout -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Employee Dashboard</h2>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>

        <!-- Employee Info -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex align-items-center">
                <div class="me-4">
                    <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.png') }}"
                         alt="Profile Picture"
                         class="rounded-circle"
                         width="120"
                         height="120"
                         style="object-fit: cover; border: 2px solid #007bff;">
                </div>
                <div class="flex-grow-1">
                    <h4 class="mb-3 text-primary">My Information</h4>
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                    @if($user->dob)
                        <p><strong>DOB:</strong> {{ \Carbon\Carbon::parse($user->dob)->format('d M Y') }}</p>
                    @endif
                    @if($user->phone)
                        <p><strong>Phone:</strong> {{ $user->phone }}</p>
                    @endif
                    @if($user->address)
                        <p><strong>Address:</strong> {{ $user->address }}</p>
                    @endif
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>

        <!-- Available Rooms -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h4 class="mb-3 text-success">Available Rooms</h4>
                @if($rooms->isEmpty())
                    <p class="text-muted">No rooms available at the moment.</p>
                @else
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Room ID</th>
                            <th>Capacity</th>
                            <th>Location</th>
                            <th>Book</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rooms as $room)
                            <tr>
                                <td>{{ $room->id }}</td>
                                <td>{{ $room->capacity }}</td>
                                <td>{{ $room->location }}</td>
                                <td>
                                    @if($room->bookings->where('status', 'booked')->where('booking_date', now()->toDateString())->isNotEmpty())
                                        <span class="badge bg-secondary">Unavailable Today</span>
                                    @else
                                        <form action="{{ route('employee.bookRoom', $room->id) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            <input type="date" name="booking_date" class="form-control form-control-sm me-2" required>
                                            <input type="time" name="start_time" class="form-control form-control-sm me-2" required>
                                            <input type="time" name="end_time" class="form-control form-control-sm me-2" required>
                                            <button type="submit" class="btn btn-success btn-sm">Book</button>
                                        </form>
                                    @endif
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
                    <p class="text-muted">You haven't booked any rooms yet.</p>
                @else
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Booking ID</th>
                            <th>Room</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>{{ $booking->room->location }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</td>
                                <td>
                                    @if($booking->status === 'booked')
                                        <span class="badge bg-success">Booked</span>
                                    @else
                                        <span class="badge bg-secondary">Canceled</span>
                                    @endif
                                </td>
                                <td>
                                    @if($booking->status === 'booked')
                                        <div class="d-flex gap-1">
                                            <!-- Cancel Booking -->
                                            <form action="{{ route('employee.cancelBooking', $booking->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                            </form>

                                            <!-- Reschedule Booking -->
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#rescheduleModal{{ $booking->id }}">
                                                Reschedule
                                            </button>

                                            <!-- Schedule Meeting -->
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#scheduleMeetingModal{{ $booking->id }}">
                                                Schedule Meeting
                                            </button>
                                        </div>

                                        <!-- Reschedule Modal -->
                                        <div class="modal fade" id="rescheduleModal{{ $booking->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-warning">
                                                        <h5 class="modal-title">Reschedule Booking #{{ $booking->id }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('employee.rescheduleBooking', $booking->id) }}" method="POST">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label>New Date</label>
                                                                <input type="date" name="booking_date" class="form-control" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>New Start Time</label>
                                                                <input type="time" name="start_time" class="form-control" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>New End Time</label>
                                                                <input type="time" name="end_time" class="form-control" required>
                                                            </div>
                                                            <div class="text-end">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-warning">Reschedule</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Schedule Meeting Modal -->
                                        <div class="modal fade" id="scheduleMeetingModal{{ $booking->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">Schedule Meeting for Booking #{{ $booking->id }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('employee.scheduleMeeting', $booking->id) }}" method="POST">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label>Meeting Title</label>
                                                                <input type="text" name="title" class="form-control" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Agenda</label>
                                                                <textarea name="agenda" class="form-control" rows="3"></textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Invite Guests</label>
                                                                <select id="guestSelect{{ $booking->id }}" class="form-select mb-2" multiple>
                                                                    @foreach($users->where('role','guest') as $guest)
                                                                        <option value="{{ $guest->id }}">{{ $guest->name }} ({{ $guest->email }})</option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden" name="attendees[]" id="attendeesInput{{ $booking->id }}">
                                                            </div>
                                                            <div class="text-end">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Create Meeting</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                let select = document.getElementById('guestSelect{{ $booking->id }}');
                                                let hiddenInput = document.getElementById('attendeesInput{{ $booking->id }}');
                                                select.addEventListener('change', function() {
                                                    let selected = Array.from(select.selectedOptions).map(opt => opt.value);
                                                    hiddenInput.value = selected.join(',');
                                                });
                                            });
                                        </script>
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

        <!-- Scheduled Meetings -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h4 class="mb-3 text-warning">Scheduled Meetings</h4>
                @if($meetings->isEmpty())
                    <p class="text-muted">No meetings scheduled yet.</p>
                @else
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Meeting ID</th>
                            <th>Booking ID</th>
                            <th>Title</th>
                            <th>Agenda</th>
                            <th>Attendees</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($meetings as $meeting)
                            <tr>
                                <td>{{ $meeting->id }}</td>
                                <td>{{ $meeting->booking_id }}</td>
                                <td>{{ $meeting->title }}</td>
                                <td>{{ $meeting->agenda ?? 'N/A' }}</td>
                                <td>
                                    @if($meeting->attendees && count($meeting->attendees) > 0)
                                        @foreach($meeting->attendees as $attendee)
                                            <span class="badge bg-info me-1">{{ $attendee->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No attendees</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <!-- Delete Meeting -->
                                        <form action="{{ route('meetings.delete', $meeting->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>

                                        <!-- Invite More Users Dropdown -->
                                        <div class="dropdown">
                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Invite More
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#inviteUsersModal{{ $meeting->id }}">
                                                        Invite More Users
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Invite Users Modal -->
                                    <div class="modal fade" id="inviteUsersModal{{ $meeting->id }}" tabindex="-1" aria-labelledby="inviteUsersModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="inviteUsersModalLabel">Invite Users to Meeting #{{ $meeting->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="inviteForm{{ $meeting->id }}" action="{{ route('meetings.invite', $meeting->id) }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="userSelect{{ $meeting->id }}" class="form-label">Select Users to Invite</label>
                                                            <select class="form-select" id="userSelect{{ $meeting->id }}" name="users[]" multiple size="5">
                                                                @foreach($users as $potentialUser)
                                                                    @if($meeting->attendees && !$meeting->attendees->contains('id', $potentialUser->id) && $potentialUser->id != Auth::id())                                                                        <option value="{{ $potentialUser->id }}">{{ $potentialUser->name }} ({{ $potentialUser->email }})</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-text">Hold Ctrl/Cmd to select multiple users</div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-primary" onclick="confirmInvite({{ $meeting->id }})">Send Invitations</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <!-- Confirmation Modal (for inviting users) -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Invitation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to invite the selected users to this meeting?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmInviteBtn">Yes, Invite Them</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to handle the invitation confirmation
        function confirmInvite(meetingId) {
            // Get the selected users
            const selectElement = document.getElementById('userSelect' + meetingId);
            const selectedOptions = Array.from(selectElement.selectedOptions);

            if (selectedOptions.length === 0) {
                alert('Please select at least one user to invite.');
                return;
            }

            // Show the confirmation modal
            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();

            // Set up the confirm button to submit the form
            document.getElementById('confirmInviteBtn').onclick = function() {
                document.getElementById('inviteForm' + meetingId).submit();
            };
        }
    </script>
@endsection
