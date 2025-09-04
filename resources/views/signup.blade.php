@extends('layouts.app')

@section('content')
    <div class="signup-page">
        <div class="signup-container shadow-sm p-4 rounded">
            <h2 class="text-primary mb-3">Create Your Account</h2>
            <p class="text-muted mb-4">Sign up to access the Smart Meeting Room system</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('signup') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <!-- First Row -->
                    <div class="col-md-4">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" required class="form-control" />
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" required class="form-control" />
                    </div>
                    <div class="col-md-4">
                        <label for="role" class="form-label">Select Role</label>
                        <select id="role" name="role" required class="form-control">
                            <option value="" disabled selected>Choose your role</option>
                            <option value="admin">Admin</option>
                            <option value="employee">Employee</option>
                            <option value="guest">Guest</option>
                        </select>
                    </div>

                    <!-- Second Row -->
                    <div class="col-md-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" required minlength="6" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required minlength="6" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" id="dob" name="dob" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" id="phone" name="phone" class="form-control" />
                    </div>

                    <!-- Third Row -->
                    <div class="col-md-8">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" id="address" name="address" class="form-control" />
                    </div>
                    <div class="col-md-4">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="form-control" />
                        <small class="form-text text-muted">Optional — JPG, PNG, JPEG</small>
                    </div>

                    <div class="col-12 mt-2">
                        <button type="submit" class="signup-btn btn btn-primary w-100">Sign Up</button>
                    </div>
                </div>
            </form>

            <p class="mt-2 text-center">
                Already have an account? <a href="{{ route('login') }}">Log in here</a>.
            </p>
        </div>
    </div>

    <style>
        .signup-page {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .signup-container {
            background: #fff;
            width: 95%;
            max-width: 1200px; /* Increased width */
            border-radius: 12px;
            padding: 24px 32px;
            text-align: center;
        }

        .signup-container h2 {
            font-weight: 700;
        }

        .form-label {
            font-weight: 500;
            color: #34495e;
        }

        .form-control {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            background: #fff;
        }

        .signup-btn {
            padding: 10px;
            font-size: 16px;
            font-weight: 600;
        }

        .alert {
            text-align: left;
            font-size: 14px;
        }
    </style>
@endsection
