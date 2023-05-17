<?php

use Illuminate\Support\Facades\Route;

Route::get('company/login', [App\Http\Controllers\Company\AuthController::class, 'login'])->name('company.login');
Route::post('company/login', [App\Http\Controllers\Company\AuthController::class, 'postLogin'])->name('company.postLogin');
Route::post('company/logout', [App\Http\Controllers\Company\AuthController::class, 'logout'])->name('company.logout');

Route::group([ 'prefix' => 'company','middleware' => 'company','as' => 'company.'], function () {
        Route::patch('/fcm-token', [App\Http\Controllers\Company\CompanyController::class, 'updateToken'])->name('fcmToken');

    Route::get('/', [App\Http\Controllers\Company\CompanyController::class, 'index'])->name('home');

    Route::get('products/select', [App\Http\Controllers\Company\ProductController::class, 'select'])->name('products.select');
    Route::get('products/check', [App\Http\Controllers\Company\ProductController::class, 'check'])->name('products.check');
    Route::delete('products/bulk', [App\Http\Controllers\Company\ProductController::class, 'deleteBulk'])->name('products.deleteBulk');
    Route::get('products/list', [App\Http\Controllers\Company\ProductController::class, 'list'])->name('products.list');
    Route::resource('products', App\Http\Controllers\Company\ProductController::class);


    Route::get('product_ssale/select', [App\Http\Controllers\Company\ProductSaleController::class, 'select'])->name('product_ssale.select');
    Route::delete('product_ssale/bulk', [App\Http\Controllers\Company\ProductSaleController::class, 'deleteBulk'])->name('product_ssale.deleteBulk');
    Route::get('product_ssale/list', [App\Http\Controllers\Company\ProductSaleController::class, 'list'])->name('product_ssale.list');
    Route::resource('product_ssale', App\Http\Controllers\Company\ProductSaleController::class);


    Route::get('categories/select', [App\Http\Controllers\Company\ProductController::class, 'selectcategories'])->name('categories.select');
    Route::get('sub_categories/select', [App\Http\Controllers\Company\ProductController::class, 'selectSubCategory'])->name('sub_categories.select');

    Route::get('orders', [App\Http\Controllers\Company\OrderController::class, 'index'])->name('orders');
    Route::get('list', [App\Http\Controllers\Company\OrderController::class, 'list'])->name('orders.list');
    Route::get('user/{id}', [App\Http\Controllers\Company\OrderController::class, 'user'])->name('orders.user');
    Route::get('orders/download', [App\Http\Controllers\Company\OrderController::class, 'download'])->name('orders.download');
    Route::post('orders/change-to-confirmed', [App\Http\Controllers\Company\OrderController::class, 'changeToConfirmed'])->name('orders.changeToConfirmed');
    Route::post('orders/change-to-canceled', [App\Http\Controllers\Company\OrderController::class, 'changeToCanceled'])->name('orders.changeToCanceled');
    Route::get('orders/{id}/edit', [App\Http\Controllers\Company\OrderController::class, 'edit'])->name('orders.edit');
    Route::get('orders/show/{id}', [App\Http\Controllers\Company\OrderController::class, 'show'])->name('orders.show');
    Route::delete('orders/{id}', [App\Http\Controllers\Company\OrderController::class, 'destroy'])->name('orders.destroy');

    Route::post('orders/change-to-progress', [App\Http\Controllers\Company\OrderController::class, 'changeTopRrogress'])->name('orders.changeTopRrogress');
    Route::post('orders/change-to-deliverd', [App\Http\Controllers\Company\OrderController::class, 'changeToDeliverd'])->name('orders.changeToDeliverd');

    Route::get('profile', [App\Http\Controllers\Company\ProfileController::class, 'index'])->name('profile.index');
    Route::get('change-password', [App\Http\Controllers\Company\ProfileController::class, 'changePassword'])->name('profile.change_password');
});
