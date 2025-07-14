<?php

use App\Http\Controllers\Admin\ServiceManagementController;
use App\Http\Middleware\CheckIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('admin/dashboard', function () {
    return view('admin.pages.dashboard');
})->name('admin.dashboard')->middleware(CheckIsAdmin::class);



Route::get('admin/customerlist', function () {
    return view('admin.pages.customer_management.list');
})->name('admin.customerlist')->middleware(CheckIsAdmin::class);

Route::prefix('admin/service_management')
    ->controller(ServiceManagementController::class)
    ->name('admin.service_management.')
    ->middleware(CheckIsAdmin::class) // optional: add 'web' if outside web.php
    ->group(function () {
        Route::get('list', 'serviceindex')->name('list');


        Route::get('detail/{serviceList}', 'detail')->name('detail');


        // Bạn có thể thêm các route khác tại đây, ví dụ:
        // Route::get('create', 'create')->name('create');
        // Route::post('store', 'store')->name('store');
        // Route::post('update/{id}', 'update')->name('update');
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
