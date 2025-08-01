
<?php

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\client\GoogleController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ServiceController;
use App\Http\Controllers\Client\QuoteRequestController;
use App\Http\Middleware\CheckIsClient;
use Illuminate\Support\Facades\Route;

// Quote Request Route (Public - không cần authentication)
Route::post('/quote-request', [QuoteRequestController::class, 'store'])->name('client.quote-request.store');

Route::get('google/callback', [GoogleController::class, 'callback'])->name('client.google.callback');

Route::get('client/profile', [ProfileController::class, 'show'])->name('client.profile')->middleware(CheckIsClient::class);
Route::post('client/profile/update', [ProfileController::class, 'update'])->name('client.profile.update')->middleware(CheckIsClient::class);
Route::get('client/orders', [CartController::class, 'orderShow'])->name('client.orders')->middleware(CheckIsClient::class);


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

Route::get('vnpay_return', [CartController::class, 'vnpayReturn']);

Route::get('cart/add-service-to-cart/{service}', [CartController::class, 'addServiceToCart'])->name('cart.add-service-to-cart')->middleware('auth');

Route::get('cart', [CartController::class, 'index'])->name('cart.index')->middleware('auth');
Route::delete('cart/remove/{service}', [CartController::class, 'removeFromCart'])->name('cart.remove')->middleware('auth');
Route::patch('cart/update/{service}', [CartController::class, 'updateQty'])->name('cart.update')->middleware('auth');

// Google OAuth redirect
Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('client.google.redirect');
