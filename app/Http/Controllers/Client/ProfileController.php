<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('client.pages.profile', [
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());
        $validated = $request->validate([
            'phone' => 'required|digits_between:8,20',
            'address' => 'required|string|max:255',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->phone_number = $validated['phone'];
        $user->address = $validated['address'];

        // Nếu có nhập mật khẩu mới thì phải kiểm tra current_password
        if ($request->filled('new_password')) {
            if (!$request->filled('current_password')) {
                return redirect()->route('client.profile')->withErrors(['current_password' => 'Please enter your current password to change password.']);
            }
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return redirect()->route('client.profile')->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $user->password = bcrypt($request->input('new_password'));
            $passwordChanged = true;
        } else {
            $passwordChanged = false;
        }

        try {
            $user->save();
        } catch (\Exception $e) {
            return redirect()->route('client.profile')->with('error', 'Save failed! Please try again.');
        }
        if ($passwordChanged) {
            return redirect()->route('client.profile')->with('success', 'Profile and password updated successfully!');
        }
        return redirect()->route('client.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
