@extends('layouts.app')

@section('title', 'Guest Profile')

@section('content')
    <div class="container my-5">
        <div class="card shadow-lg rounded-4 p-4">

            <!-- Header + Logout -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2 fw-bold text-primary">Guest Profile</h1>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger px-4">Logout</button>
                </form>
            </div>

            <!-- Profile Info -->
            <div class="d-flex align-items-center gap-4 mb-5 flex-wrap">
                <div>
                    <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.png') }}"
                         alt="Profile Picture"
                         class="rounded-circle border border-primary shadow" style="width: 120px; height: 120px; object-fit: cover;">
                </div>
                <div class="ms-2">
                    <div class="mb-2">
                        <small class="text-muted">Full Name</small>
                        <div class="fs-5 fw-semibold">{{ $user->name }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Email</small>
                        <div class="fs-5 fw-semibold">{{ $user->email }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Phone</small>
                        <div class="fs-5 fw-semibold">{{ $user->phone ?? 'Not provided' }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Address</small>
                        <div class="fs-5 fw-semibold">{{ $user->address ?? 'Not provided' }}</div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            Edit Profile
                        </button>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Modal -->
            <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('guest.updateProfile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                                </div>
                                <div class="mb-3">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                                </div>
                                <div class="mb-3">
                                    <label>Profile Picture</label>
                                    <input type="file" name="profile_picture" class="form-control">
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invitations -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="mb-3 text-secondary">Invitations</h4>
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

        </div>
    </div>

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
