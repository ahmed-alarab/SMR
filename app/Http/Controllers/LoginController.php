<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected function redirectTo()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return '/admin/profile';
        }

        return '/dashboard';
    }

}
