<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // ✅ Validate login inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // ✅ Attempt to authenticate the user
        if (auth()->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // ✅ Get the authenticated user
            $user = auth()->user();

            // ✅ Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.profile')->with('success', 'Welcome back, Admin!');
            } elseif ($user->role === 'employee') {
                return redirect()->route('employee.profile')->with('success', 'Welcome back, Employee!');
            } else {
                return redirect()->route('guest.profile')->with('success', 'Welcome back, Guest!');
            }
        }

        // ❌ If authentication fails
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }


    public function signup(Request $request)
    {
        // ✅ Validate inputs + role + password confirmation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // password_confirmation required in form
            'role' => 'nullable|in:guest,admin,employee', // ✅ validate allowed roles
        ]);

        // ✅ Create the user and set role (default to guest if not provided)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'] ?? 'guest', // ✅ default guest
        ]);

        // ✅ Log the user in automatically after signup
        auth()->login($user);

        // ✅ Redirect to login with success message
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
    // ✅ Log the user out
    Auth::logout();

    // ✅ Invalidate the session
    $request->session()->invalidate();

    // ✅ Regenerate the CSRF token for security
    $request->session()->regenerateToken();

    // ✅ Redirect to login page
    return redirect()->route('login')->with('success', 'You have been logged out successfully!');
}

}
