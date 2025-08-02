<?php

use Illuminate\Support\Facades\Route;

Route::get('/order-success', function () {
    return view('website.pages.orders.order_success');
})->name('order.success');
