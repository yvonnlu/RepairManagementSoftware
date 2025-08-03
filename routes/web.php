<?php

use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

require_once(__DIR__ . '/admin_routes.php');
require_once(__DIR__ . '/client_routes.php');

// SEO Routes - exclude from web middleware to prevent session cookies
Route::get('/sitemap.xml', [SitemapController::class, 'index'])
    ->name('sitemap')
    ->withoutMiddleware(['web']);

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__ . '/order_success.php';
require __DIR__ . '/auth.php';
