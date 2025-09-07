@extends('layouts.app')

@section('title', 'Guest Profile')

@section('content')
    <div class="max-w-3xl mx-auto mt-10 bg-white shadow-lg rounded-2xl p-6">

        <!-- Header + Logout -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Guest Profile</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                    Logout
                </button>
            </form>
        </div>

        <!-- Profile Info -->
        <div class="flex items-center gap-6 mb-8">
            <div>
                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.png') }}"
                     alt="Profile Picture"
                     class="rounded-full w-32 h-32 object-cover border-2 border-blue-500">
            </div>
            <div class="space-y-2">
                <div>
                    <p class="text-gray-600 text-sm">Full Name</p>
                    <p class="text-lg font-semibold">{{ $user->name }}</p>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">Email</p>
                    <p class="text-lg font-semibold">{{ $user->email }}</p>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">Phone</p>
                    <p class="text-lg font-semibold">{{ $user->phone ?? 'Not provided' }}</p>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">Address</p>
                    <p class="text-lg font-semibold">{{ $user->address ?? 'Not provided' }}</p>
                </div>
            </div>
        </div>

        <!-- Bookings Section -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">My Bookings</h2>

            @if($bookings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-50 border border-gray-200 rounded-lg">
                        <thead>
                        <tr class="bg-gray-200 text-gray-700 text-left text-sm">
                            <th class="py-2 px-4">Room</th>
                            <th class="py-2 px-4">Status</th>
                            <th class="py-2 px-4">Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bookings as $booking)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-2 px-4">{{ $booking->room->name ?? 'Unknown' }}</td>
                                <td class="py-2 px-4">
                                    @if($booking->status === 'booked')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">Booked</span>
                                    @elseif($booking->status === 'canceled')
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">Canceled</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">Pending</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4">{{ $booking->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-sm mt-2">You haven’t booked any rooms yet.</p>
            @endif
        </div>
    </div>
@endsection
