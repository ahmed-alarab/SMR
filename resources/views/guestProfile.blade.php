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
                    <button type="submit" class="btn btn-danger px-4">
                        Logout
                    </button>
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
                    <div>
                        <small class="text-muted">Address</small>
                        <div class="fs-5 fw-semibold">{{ $user->address ?? 'Not provided' }}</div>
                    </div>
                </div>
            </div>

            <!-- Bookings Section -->
            <div>
                <h2 class="h4 fw-bold text-secondary mb-3">My Bookings</h2>
                @if($bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle rounded-3 overflow-hidden">
                            <thead class="table-light">
                            <tr>
                                <th>Room</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->room->name ?? 'Unknown' }}</td>
                                    <td>
                                        @if($booking->status === 'booked')
                                            <span class="badge bg-success">Booked</span>
                                        @elseif($booking->status === 'canceled')
                                            <span class="badge bg-danger">Canceled</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $booking->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mt-2">You haven’t booked any rooms yet.</p>
                @endif
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
