<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TeacherLoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        // If already logged in as teacher, redirect to dashboard
        if (Auth::check() && Auth::user()->role === 'teacher') {
            return redirect('/teacher');
        }
        
        return view('auth.teacher-login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Check if user is a teacher
            if (Auth::user()->role === 'teacher') {
                return redirect()->intended('/teacher');
            }
            
            // Not a teacher - log out and show error
            Auth::logout();
            return back()->withErrors([
                'email' => 'You do not have permission to access the teacher portal.',
            ])->withInput($request->only('email'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }
}
