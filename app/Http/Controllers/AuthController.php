<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            $user = auth()->user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.profile')->with('success', 'Welcome back, Admin!');
            } elseif ($user->role === 'employee') {
                return redirect()->route('employee.profile')->with('success', 'Welcome back, Employee!');
            } else {
                return redirect()->route('guest.profile')->with('success', 'Welcome back, Guest!');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function signup(Request $request)
    {
        // Validate all inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // password_confirmation required
            'role' => 'nullable|in:guest,admin,employee',
            'dob' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB max
        ]);

        // Handle profile picture upload
        $profileImagePath = null;
        if ($request->hasFile('profile_picture')) {
            $profileImagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Create the user
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'] ?? 'guest',
            'dob' => $validated['dob'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'profile_picture' => $profileImagePath,
        ]);

        // Redirect to login page instead of logging in automatically
        return redirect()->route('login')->with('success', 'Signup successful! Please log in.');
    }


    public function showLogin()
    {
        return view('login');
    }

    public function showSignup()
    {
        return view('signup');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have been logged out successfully!');
    }
}
