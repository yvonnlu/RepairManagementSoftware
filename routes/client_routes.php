<?php

use App\Http\Controllers\client\GoogleController;
use App\Http\Middleware\CheckIsClient;
use Illuminate\Support\Facades\Route;

Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('client.google.redirect');

Route::get('google/callback', [GoogleController::class, 'callback'])->name('client.google.callback');

Route::get('/client/profile', function () {
    return view('client.pages.profile');
})->name('client.profile')->middleware(CheckIsClient::class);

Route::get('/client/bookservice', function () {
    return view('client.pages.bookservice');
})->name('client.bookservice')->middleware(CheckIsClient::class);

Route::get('/client/payment', function () {
    return view('client.pages.payment');
})->name('client.payment')->middleware(CheckIsClient::class);

Route::get('/client/trackorder', function () {
    return view('client.pages.trackorder');
})->name('client.trackorder')->middleware(CheckIsClient::class);
?>



