<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnifiedLoginController extends Controller
{
    /**
     * Show the unified login form.
     */
    public function showLoginForm()
    {
        // If already logged in, redirect to appropriate dashboard
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        
        return view('auth.login');
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
            
            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Redirect user based on their role.
     */
    protected function redirectBasedOnRole($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect('/admin');
            case 'teacher':
                return redirect('/teacher');
            case 'student':
                return redirect('/student');
            default:
                return redirect('/');
        }
    }

    /**
     * Log out the user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}
