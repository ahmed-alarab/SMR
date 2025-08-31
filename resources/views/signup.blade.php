@extends('layouts.app')

@section('content')
    <div class="signup-page">
        <div class="signup-container shadow-sm p-4 rounded">
            <h2 class="text-primary mb-3">Create Your Account</h2>
            <p class="text-muted mb-4">Sign up to access the Smart Meeting Room system</p>

            <!-- Display validation errors -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('signup') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required class="form-control" />
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required class="form-control" />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required minlength="6" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required minlength="6" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="role">Select Role</label>
                    <select id="role" name="role" required class="form-control">
                        <option value="" disabled selected>Choose your role</option>
                        <option value="admin">Admin</option>
                        <option value="employee">Employee</option>
                        <option value="guest">Guest</option>
                    </select>
                </div>

                <button type="submit" class="signup-btn btn btn-primary w-100">Sign Up</button>
            </form>

            <p class="mt-3 text-center">
                Already have an account? <a href="{{ route('login') }}">Log in here</a>.
            </p>
        </div>
    </div>

    <style>
        .signup-page {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .signup-container {
            background: #fff;
            max-width: 400px;
            width: 100%;
            border-radius: 12px;
            padding: 32px 24px;
            text-align: center;
        }

        .signup-container h2 {
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }

        .form-group label {
            font-weight: 500;
            color: #34495e;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 15px;
            background: #fff;
        }

        .signup-btn {
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            transition: 0.2s;
        }

        .signup-btn:hover {
            opacity: 0.9;
        }

        .alert {
            text-align: left;
            font-size: 14px;
        }

        p.mt-3 a {
            color: #007bff;
            text-decoration: none;
        }
        p.mt-3 a:hover {
            text-decoration: underline;
        }
    </style>
@endsection
