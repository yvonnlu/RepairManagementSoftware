<?php

use App\Http\Controllers\client\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('client.google.redirect');

Route::get('google/callback', [GoogleController::class, 'callback'])->name('client.google.callback');

Route::get('/client/profile', function () {
    return view('client.pages.profile');
})->name('client.profile');

Route::get('/client/bookservice', function () {
    return view('client.pages.bookservice');
})->name('client.bookservice');

Route::get('/client/payment', function () {
    return view('client.pages.payment');
})->name('client.payment');
?>



