<?php

use Illuminate\Support\Facades\Route;

Route::get('admin/dashboard', function () {
    return view('admin.pages.dashboard');
})->name('admin.dashboard');

Route::get('admin/customerlist', function () {
    return view('admin.pages.customer_management.list');
})->name('admin.customerlist');
