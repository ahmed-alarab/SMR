@extends('layouts.app')

@section('content')
    <div class="login-container">
        <h2>Smart Meeting Room Login</h2>
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
            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
    <style>
        .login-container {
            max-width: 400px;
            margin: 60px auto;
            padding: 32px 24px;
            background: #f8f9fa;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 24px;
            color: #2c3e50;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 18px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #34495e;
            font-size: 15px;
        }
        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 15px;
            background: #fff;
            margin-bottom: 4px;
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-login:hover {
            background: #0056b3;
        }
    </style>
@endsection
