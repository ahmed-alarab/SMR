@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Edit Room</h2>

        <div class="card shadow p-4">
            <form action="{{ route('rooms.update', $room->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="capacity" class="form-label">Capacity</label>
                    <input type="number" class="form-control" id="capacity" name="capacity" required min="1" value="{{ old('capacity', $room->capacity) }}">
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" required value="{{ old('location', $room->location) }}">
                </div>

                <button type="submit" class="btn btn-primary">Update Room</button>
                <a href="{{ route('admin.profile') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
