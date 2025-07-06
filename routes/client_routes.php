

<?php

use App\Http\Controllers\client\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('client.google.redirect');

Route::get('google/callback', [GoogleController::class, 'callback'])->name('client.google.callback');
?>



