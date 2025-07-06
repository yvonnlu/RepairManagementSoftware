<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
 public function redirect(){
        return Socialite::driver('google')->redirect();
    }  
    
    public function callback(){
        $googleUser = Socialite::driver('google')->user();

        $user = User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'github_token' => $googleUser->token,
            'password' => Hash::make('password@Password!'),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
