@extends('layouts.app')

@section('title', 'Employee Profile')

@section('content')
    <div class="container my-5">
        <div class="card shadow-lg rounded-4 p-4">

            <!-- Header + Logout -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2 fw-bold text-primary">Employee Profile</h1>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-info px-4 text-white" data-bs-toggle="modal" data-bs-target="#dashboardModal">View Dashboard</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4">Logout</button>
                    </form>
                </div>
            </div>

            <!-- Employee Info --> <div class="card shadow-sm border-0 mb-4"> <div class="card-body d-flex align-items-center"> <div class="me-4"> <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.png') }}" alt="Profile Picture" class="rounded-circle" width="120" height="120" style="object-fit: cover; border: 2px solid #007bff;"> </div> <div class="flex-grow-1"> <h4 class="mb-3 text-primary">My Information</h4> <p><strong>Name:</strong> {{ $user->name }}</p> <p><strong>Email:</strong> {{ $user->email }}</p> <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p> @if($user->dob) <p><strong>DOB:</strong> {{ \Carbon\Carbon::parse($user->dob)->format('d M Y') }}</p> @endif @if($user->phone) <p><strong>Phone:</strong> {{ $user->phone }}</p> @endif @if($user->address) <p><strong>Address:</strong> {{ $user->address }}</p> @endif </div> <div> <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal"> Edit Profile </button> </div> </div> </div> <!-- Edit Profile Modal --> <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> </div> <div class="modal-body"> <form action="{{ route('employee.updateProfile') }}" method="POST" enctype="multipart/form-data"> @csrf @method('PUT') <div class="mb-3"> <label>Name</label> <input type="text" name="name" class="form-control" value="{{ $user->name }}" required> </div> <div class="mb-3"> <label>Email</label> <input type="email" name="email" class="form-control" value="{{ $user->email }}" required> </div> <div class="mb-3"> <label>Profile Picture</label> <input type="file" name="profile_picture" class="form-control"> </div> <div class="text-end"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> <button type="submit" class="btn btn-primary">Save Changes</button> </div> </form> </div> </div> </div> </div>

            <!-- Meeting Invitations -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0 text-secondary">Invitations</h4>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#calendarModal">
                            View Calendar
                        </button>
                    </div>
                    @if($invitations->isEmpty())
                        <p class="text-muted">You haven't been invited to any meetings yet.</p>
                    @else
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>Meeting ID</th>
                                <th>Booking ID</th>
                                <th>Title</th>
                                <th>Agenda</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invitations as $meeting)
                                <tr>
                                    <td>{{ $meeting->id }}</td>
                                    <td>{{ $meeting->booking_id }}</td>
                                    <td>{{ $meeting->title }}</td>
                                    <td>{{ $meeting->agenda ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($meeting->booking->booking_date ?? now())->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
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
                                    <td> @if($room->bookings->where('status', 'booked')->where('booking_date', now()->toDateString())->isNotEmpty())
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
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="mb-3 text-secondary">My Bookings</h4>
                    @if($bookings->isEmpty())
                        <p class="text-muted">You haven't made any bookings yet.</p>
                    @else
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>Booking ID</th>
                                <th>Room</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->room->name }}</td>
                                    <td>{{ $booking->booking_date }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status == 'booked' ? 'success' : 'danger' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#rescheduleModal{{ $booking->id }}">Reschedule</button>
                                        <button class="btn btn-sm btn-danger cancel-btn" data-id="{{ $booking->id }}">Cancel</button>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#scheduleMeetingModal{{ $booking->id }}">Schedule Meeting</button>
                                    </td>
                                </tr>

                                <!-- Reschedule Modal -->
                                <div class="modal fade" id="rescheduleModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning">
                                                <h5 class="modal-title">Reschedule Booking #{{ $booking->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('employee.rescheduleBooking', $booking->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>New Date</label>
                                                        <input type="date" name="booking_date" class="form-control" required value="{{ $booking->booking_date }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>New Start Time</label>
                                                        <input type="time" name="start_time" class="form-control" required value="{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>New End Time</label>
                                                        <input type="time" name="end_time" class="form-control" required value="{{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-warning">Reschedule</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Schedule Meeting Modal -->
                                <div class="modal fade" id="scheduleMeetingModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">Schedule Meeting for Booking #{{ $booking->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('meetings.store', ['booking' => $booking->id]) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Meeting Title</label>
                                                        <input type="text" name="title" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Agenda</label>
                                                        <textarea name="agenda" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Schedule</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Cancel Booking Confirmation Modal (single modal for all rows) -->
    <div class="modal fade" id="cancelConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirm Cancellation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- form uses POST and Laravel spoofing for DELETE -->
                <form id="cancelBookingForm" method="POST" action="">
                    <div class="modal-body">
                        @csrf
                        @method('DELETE')
                        <p>Are you sure you want to cancel this booking?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes, Cancel</button>
                    </div>
                </form>
            </div>
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
                        <th>Date</th>
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
                            <td>{{ \Carbon\Carbon::parse($meeting->booking->booking_date ?? now())->format('d M Y') }}</td>
                            <td>
                                @if($meeting->attendees && $meeting->attendees->count() > 0)
                                    @foreach($meeting->attendees as $attendee)
                                        <span class="badge bg-info me-1">{{ $attendee->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No attendees</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <form action="{{ route('meetings.delete', $meeting->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>

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
                                                        @php
                                                            $attendeeIds = $meeting->attendees ? $meeting->attendees->pluck('id')->toArray() : [];
                                                        @endphp
                                                        <select class="form-select" id="userSelect{{ $meeting->id }}" name="users[]" multiple size="5">
                                                            @foreach($users as $potentialUser)
                                                                @if(!in_array($potentialUser->id, $attendeeIds) && $potentialUser->id != Auth::id())
                                                                    <option value="{{ $potentialUser->id }}">{{ $potentialUser->name }} ({{ $potentialUser->email }})</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <div class="form-text">Hold Ctrl/Cmd to select multiple users</div>
                                                    </div>
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


    <!-- Confirmation Modal -->
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

    <!-- Calendar Modal -->
    <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="calendarModalLabel">Meeting Calendar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Modal -->

    <!-- Dashboard Modal -->
    <div class="modal fade" id="dashboardModal" tabindex="-1" aria-labelledby="dashboardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="dashboardModalLabel">Employee Dashboard</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <!-- Card: Total Meetings -->
                        <div class="col-md-4">
                            <div class="card shadow-sm p-3 text-center">
                                <h6 class="text-muted">Total Meetings</h6>
                                <h2 class="fw-bold text-success">{{ $meetings->count() }}</h2>
                            </div>
                        </div>

                        <!-- Card: Invitations -->
                        <div class="col-md-4">
                            <div class="card shadow-sm p-3 text-center">
                                <h6 class="text-muted">Invitations Received</h6>
                                <h2 class="fw-bold text-primary">{{ $invitations->count() }}</h2>
                            </div>
                        </div>

                        <!-- Card: Bookings -->
                        <div class="col-md-4">
                            <div class="card shadow-sm p-3 text-center">
                                <h6 class="text-muted">Rooms Booked</h6>
                                <h2 class="fw-bold text-warning">{{ $bookings->count() }}</h2>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <canvas id="meetingsPerMonth"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="meetingsStatus"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Meetings per month (example data from backend)
            var ctx1 = document.getElementById('meetingsPerMonth').getContext('2d');
            var meetingsPerMonthChart = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($meetings->groupBy(fn($m) => \Carbon\Carbon::parse($m->booking->booking_date)->format('F'))->keys()) !!},
                    datasets: [{
                        label: 'Meetings',
                        data: {!! json_encode($meetings->groupBy(fn($m) => \Carbon\Carbon::parse($m->booking->booking_date)->format('F'))->map->count()->values()) !!},
                        backgroundColor: '#198754'
                    }]
                }
            });

            // Meeting status pie chart
            var ctx2 = document.getElementById('meetingsStatus').getContext('2d');
            var meetingsStatusChart = new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: ['Booked', 'Cancelled'],
                    datasets: [{
                        data: [
                            {{ $bookings->where('status', 'booked')->count() }},
                            {{ $bookings->where('status', 'cancelled')->count() }}
                        ],
                        backgroundColor: ['#0d6efd', '#dc3545']
                    }]
                }
            });
        });
    </script>


    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [
                        @foreach($invitations as $meeting)
                    {
                        title: '{{ $meeting->title }}',
                        start: '{{ $meeting->booking->booking_date ?? now() }}T{{ $meeting->booking->start_time ?? '00:00:00' }}',
                        end: '{{ $meeting->booking->booking_date ?? now() }}T{{ $meeting->booking->end_time ?? '00:00:00' }}',
                        url: '#'
                    },
                    @endforeach
                ],
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    alert('Meeting: ' + info.event.title + '\nStarts: ' + info.event.start.toLocaleString() + '\nEnds: ' + info.event.end.toLocaleString());
                }
            });

            var calendarModal = document.getElementById('calendarModal');
            calendarModal.addEventListener('shown.bs.modal', function () {
                calendar.render();
            });
        });
    </script>

    <script>
        function confirmInvite(meetingId) {
            const selectElement = document.getElementById('userSelect' + meetingId);
            const selectedOptions = Array.from(selectElement.selectedOptions);

            if (selectedOptions.length === 0) {
                alert('Please select at least one user to invite.');
                return;
            }

            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();

            document.getElementById('confirmInviteBtn').onclick = function() {
                document.getElementById('inviteForm' + meetingId).submit();
            };
        }
    </script>

    <!-- Cancel Booking Script -->
    <script>
        document.querySelectorAll('.cancel-btn').forEach(button => {
            button.addEventListener('click', function () {
                const bookingId = this.getAttribute('data-id');
                const form = document.getElementById('cancelBookingForm');
                form.action = `/employee/bookings/${bookingId}/cancel`;
                new bootstrap.Modal(document.getElementById('cancelConfirmModal')).show();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // base URL for the cancel route (no trailing slash)
            const cancelUrlBase = "{{ url('/cancel-booking') }}";
            const cancelModalEl = document.getElementById('cancelConfirmModal');
            const cancelForm = document.getElementById('cancelBookingForm');
            const bsModal = new bootstrap.Modal(cancelModalEl);

            document.querySelectorAll('.cancel-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const bookingId = this.getAttribute('data-id');
                    // set the form action to /cancel-booking/{id}
                    cancelForm.action = `${cancelUrlBase}/${bookingId}`;
                    // show the modal
                    bsModal.show();
                });
            });
        });
    </script>

    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e9ecef 100%);
        }
        .card {
            border: none;
        }
        .rounded-4 {
            border-radius: 1.5rem;
        }
        .gap-4 {
            gap: 1.5rem;
        }
        @media (max-width: 768px) {
            .d-flex.align-items-center.gap-4 {
                flex-direction: column !important;
                gap: 1rem !important;
            }
        }
    </style>
@endsection
