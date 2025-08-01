<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Debug: Log user info
        Log::info('User login:', [
            'id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'role_type' => gettype($user->role)
        ]);

        // Redirect based on user role
        // role = 1 is admin, role = 0 is regular user
        if ($user->role == 1) {
            Log::info('Redirecting to admin dashboard');
            return redirect()->intended(route('admin.dashboard', absolute: false));
        } else {
            Log::info('Redirecting to client home');
            return redirect()->intended(route('home.index', absolute: false));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'You have been logged out successfully.');
    }
}
