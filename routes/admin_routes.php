<?php

use Illuminate\Support\Facades\Route;

Route::get('admin/dashboard', function () {
    return view('admin.pages.dashboard');
})->name('admin.dashboard');

Route::get('admin/customerlist', function () {
    return view('admin.pages.customer_management.list');
})->name('admin.customerlist');

Route::get('admin/servicelist', function () {
    return view('admin.pages.service_management.list');
})->name('admin.servicelist');

Route::get('admin/orderlist', function () {
    return view('admin.pages.order_management.list');
})->name('admin.orderlist');

Route::get('admin/technicianlist', function () {
    return view('admin.pages.technician_management.list');
})->name('admin.technicianlist');


Route::get('admin/inventorylist', function () {
    return view('admin.pages.inventory_management.list');
})->name('admin.inventorylist');