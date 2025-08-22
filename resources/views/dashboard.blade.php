<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Meeting Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero {
            background: linear-gradient(to right, #0d6efd, #6610f2);
            color: white;
            padding: 80px 20px;
            text-align: center;
        }
        .feature-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 20px;
            background: white;
        }
        footer {
            background-color: #0d6efd;
            color: white;
            padding: 15px;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Smart Meeting Room</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link btn btn-light text-dark ms-3" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link btn btn-warning text-dark ms-2" href="{{ route('signup') }}">Sign Up</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1 class="display-4 fw-bold">Welcome to Smart Meeting Room</h1>
        <p class="lead mt-3">Easily schedule, manage, and optimize your meetings with our smart system.</p>
        <a href="#features" class="btn btn-warning btn-lg mt-3">Explore Features</a>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="container my-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Our Features</h2>
        <p class="text-muted">Smart tools to make your meetings more efficient</p>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-card text-center">
                <h5 class="fw-bold">🔔 Smart Booking</h5>
                <p>Book your meeting rooms in advance with a few clicks and get instant confirmation.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card text-center">
                <h5 class="fw-bold">📅 Calendar Integration</h5>
                <p>Sync your meetings with Google Calendar or Outlook for seamless scheduling.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card text-center">
                <h5 class="fw-bold">📊 Real-Time Reports</h5>
                <p>Track room usage, optimize time slots, and manage resources effectively.</p>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h3 class="fw-bold">About Our System</h3>
            <p>
                Smart Meeting Room is a modern solution designed to simplify your scheduling process.
                Whether you're managing multiple teams or a single office, our system helps you optimize
                meeting room usage, avoid conflicts, and improve productivity.
            </p>
            <a href="{{ route('signup') }}" class="btn btn-primary">Get Started</a>
        </div>
        <div class="col-md-6 text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png" class="img-fluid" width="300" alt="Smart Meeting">
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <p>© 2025 Smart Meeting Room. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
