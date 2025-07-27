<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Middleware\CheckIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('admin/dashboard', function () {
    return view('admin.pages.dashboard');
})->name('admin.dashboard')->middleware(CheckIsAdmin::class);


Route::prefix('admin/customer')
    ->controller(CustomerController::class)
    ->name('admin.customer.')
    ->middleware(CheckIsAdmin::class) // optional: add 'web' if outside web.php
    ->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('detail/{customer}', 'detail')->name('detail');
        Route::post('update/{customer}', 'update')->name('update');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::delete('destroy/{customer}', 'destroy')->name('destroy');
        Route::post('restore/{id}', 'restore')->name('restore');

        Route::get('restore/{customer}', 'restore')->name('restore');
    });


Route::prefix('admin/order')
    ->controller(OrderController::class)
    ->name('admin.order.')
    ->middleware(CheckIsAdmin::class) // optional: add 'web' if outside web.php
    ->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('detail/{order}', 'detail')->name('detail');
        Route::post('update/{order}', 'update')->name('update');
        Route::patch('update-service-step/{order}', 'updateServiceStep')->name('updateServiceStep');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
    });

Route::prefix('admin/service')
    ->controller(ServicesController::class)
    ->name('admin.service.')
    ->middleware(CheckIsAdmin::class) // optional: add 'web' if outside web.php
    ->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('detail/{service}', 'detail')->name('detail');
        Route::post('update/{service}', 'update')->name('update');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
    });



Route::get('admin/orderlist', function () {
    return view('admin.pages.order_management.list');
})->name('admin.orderlist')->middleware(CheckIsAdmin::class);

Route::get('admin/technicianlist', function () {
    return view('admin.pages.technician_management.list');
})->name('admin.technicianlist')->middleware(CheckIsAdmin::class);


Route::get('admin/inventorylist', function () {
    return view('admin.pages.inventory_management.list');
})->name('admin.inventorylist')->middleware(CheckIsAdmin::class);
