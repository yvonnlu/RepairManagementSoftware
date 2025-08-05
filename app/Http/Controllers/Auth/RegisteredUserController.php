<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Check if email exists (including soft deleted users)
        $existingUser = User::withTrashed()->where('email', $request->email)->first();

        if ($existingUser) {
            if ($existingUser->trashed()) {
                // User exists but is soft deleted
                return back()->withErrors([
                    'email' => 'This email address is associated with a deactivated account. Please contact our support team at support@fixicon.com or call (555) 123-4567 to reactivate your account.'
                ])->withInput();
            } else {
                // User exists and is active
                return back()->withErrors([
                    'email' => 'This email address is already registered. Please try logging in instead.'
                ])->withInput();
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('client.profile', absolute: false));
    }
}
