<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\Admin\QuoteRequestController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\ServiceImageController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Middleware\CheckIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('admin/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard')
    ->middleware(CheckIsAdmin::class);

Route::get('admin/dashboard/revenue-data', [DashboardController::class, 'getRevenueData'])
    ->name('admin.dashboard.revenue-data')
    ->middleware(CheckIsAdmin::class);


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
        Route::patch('update-payment-status/{order}', 'updatePaymentStatus')->name('updatePaymentStatus');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::delete('destroy/{order}', 'destroy')->name('destroy');
        Route::post('restore/{id}', 'restore')->name('restore');
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
        Route::delete('destroy/{service}', 'destroy')->name('destroy');
        Route::post('restore/{id}', 'restore')->name('restore');
    });



// Inventory Management Routes
Route::prefix('admin/inventory')
    ->controller(InventoryController::class)
    ->name('admin.inventory.')
    ->middleware(CheckIsAdmin::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/detail/{part}', 'detail')->name('detail');
        Route::post('/update/{part}', 'update')->name('update');
        Route::delete('/{part}', 'destroy')->name('destroy');
        Route::post('/{part}/add-stock', 'addStock')->name('addStock');
        Route::post('/restore/{id}', 'restore')->name('restore');
    });

// Quote Requests Routes
Route::prefix('admin/quote-requests')
    ->controller(QuoteRequestController::class)
    ->name('admin.quote-requests.')
    ->middleware(CheckIsAdmin::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/detail/{quoteRequest}', 'show')->name('detail');
        Route::put('/{quoteRequest}', 'update')->name('update');
        Route::delete('/{quoteRequest}', 'destroy')->name('destroy');
        Route::post('/restore/{id}', 'restore')->name('restore');
    });

// Service Image Management Routes
Route::prefix('admin/service-images')
    ->controller(ServiceImageController::class)
    ->name('admin.service-images.')
    ->middleware(CheckIsAdmin::class)
    ->group(function () {
        Route::post('/{service}/upload', 'upload')->name('upload');
        Route::delete('/{service}/delete', 'delete')->name('delete');
        Route::get('/{service}', 'show')->name('show');
        Route::post('/{service}/restore', 'restore')->name('restore');
    });
