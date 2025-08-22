<div class="signup-container">
    <h2>Smart Meeting Room Signup</h2>
    <form method="POST" action="{{ route('signup') }}">
        @csrf
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required minlength="6">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required minlength="6">
        </div>

        <button type="submit" class="signup-btn">Sign Up</button>
    </form>
</div>

<style>
    .signup-container {
        max-width: 400px;
        margin: 40px auto;
        padding: 32px 24px;
        background: #f8f9fa;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        font-family: 'Segoe UI', Arial, sans-serif;
    }
    .signup-container h2 {
        text-align: center;
        margin-bottom: 24px;
        color: #2c3e50;
    }
    .form-group {
        margin-bottom: 18px;
    }
    .form-group label {
        display: block;
        margin-bottom: 6px;
        color: #34495e;
        font-weight: 500;
    }
    .form-group input {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 15px;
        background: #fff;
    }
    .signup-btn {
        width: 100%;
        padding: 10px 0;
        background: #2980b9;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .signup-btn:hover {
        background: #1c5d99;
    }
</style>
