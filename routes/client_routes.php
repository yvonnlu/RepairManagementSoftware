<?php

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\client\GoogleController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ServiceController;

use App\Http\Middleware\CheckIsClient;
use App\Mail\TestEmailTemplate;
use App\Models\Services;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('client.google.redirect');

Route::get('google/callback', [GoogleController::class, 'callback'])->name('client.google.callback');

Route::get('client/profile', function () {
    return view('client.pages.profile');
})->name('client.profile')->middleware(CheckIsClient::class);

Route::get('client/bookservice', function () {
    return view('client.pages.bookservice');
})->name('client.bookservice')->middleware(CheckIsClient::class);

Route::get('client/payment', function () {
    return view('client.pages.payment');
})->name('client.payment')->middleware(CheckIsClient::class);

Route::get('client/trackorder', function () {
    return view('client.pages.trackorder');
})->name('client.trackorder')->middleware(CheckIsClient::class);

Route::get('home', [HomeController::class, 'index'])->name('home.index');
Route::get('services', [ServiceController::class, 'index'])->name('service.index');
Route::get('checkout', [CartController::class, 'checkout'])->name('payment.index')->middleware('auth');
Route::post('place-order', [CartController::class, 'placeOrder'])->name('cart.place-order')->middleware('auth');

Route::get('test-mail', function () {
    $service = Services::find(1);
    Mail::to('lunguyetnghia@gmail.com')->send(new TestEmailTemplate($service));
});

Route::get('cart/add-service-to-cart/{service}', [CartController::class, 'addServiceToCart'])->name('cart.add-service-to-cart')->middleware('auth');

Route::get('cart', [CartController::class, 'index'])->name('cart.index')->middleware('auth');
Route::delete('cart/remove/{service}', [CartController::class, 'removeFromCart'])->name('cart.remove')->middleware('auth');
Route::patch('cart/update/{service}', [CartController::class, 'updateQty'])->name('cart.update')->middleware('auth');



