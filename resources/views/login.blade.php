@extends('layouts.app')

@section('content')
    <div class="login-page">
        <div class="login-container shadow-sm p-4 rounded">
            <h2 class="text-primary mb-3">Welcome Back!</h2>
            <p class="text-muted mb-4">Log in to access your Smart Meeting Room account</p>

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

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" required autofocus class="form-control" />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required class="form-control" />
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                <button type="submit" class="btn-login btn btn-primary w-100">Login</button>
            </form>

            <p class="mt-3 text-center">
                Don't have an account? <a href="{{ route('signup') }}">Sign up here</a>.
            </p>
        </div>
    </div>

    <style>
        .login-page {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .login-container {
            background: #fff;
            max-width: 400px;
            width: 100%;
            border-radius: 12px;
            padding: 32px 24px;
            text-align: center;
        }

        .login-container h2 {
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

        .btn-login {
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-login:hover {
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
