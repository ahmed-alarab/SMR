<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (auth()->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Welcome back!');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);

    }

    public function signup(Request $request)
    {
        // ✅ Validate inputs + password confirmation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // password_confirmation field required in form
        ]);

        // ✅ Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // ✅ Log the user in automatically after signup
        auth()->login($user);

        // ✅ Return JSON response
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
}
