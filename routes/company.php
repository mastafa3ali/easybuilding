<?php

use Illuminate\Support\Facades\Route;

Route::get('company/login', [App\Http\Controllers\Company\AuthController::class, 'login'])->name('company.login');
Route::post('company/login', [App\Http\Controllers\Company\AuthController::class, 'postLogin'])->name('company.postLogin');
Route::post('company/logout', [App\Http\Controllers\Company\AuthController::class, 'logout'])->name('company.logout');

Route::group([ 'prefix' => 'company','middleware' => 'company','as' => 'company.'], function () {

    Route::get('/', [App\Http\Controllers\Company\CompanyController::class, 'index'])->name('home');
    Route::get('products/select', [App\Http\Controllers\Company\ProductController::class, 'select'])->name('products.select');
    Route::get('products/selectclassroom', [App\Http\Controllers\Company\ProductController::class, 'selectClassroom'])->name('products.selectClassroom');
    Route::get('products/selectsubject', [App\Http\Controllers\Company\ProductController::class, 'selectSubject'])->name('products.selectSubject');
    Route::delete('products/bulk', [App\Http\Controllers\Company\ProductController::class, 'deleteBulk'])->name('products.deleteBulk');
    Route::get('products/list', [App\Http\Controllers\Company\ProductController::class, 'list'])->name('products.list');
    Route::resource('products', App\Http\Controllers\Company\ProductController::class);
    Route::get('categories/select', [App\Http\Controllers\Company\ProductController::class, 'selectcategories'])->name('categories.select');
    Route::get('sub_categories/select', [App\Http\Controllers\Company\ProductController::class, 'selectSubCategory'])->name('sub_categories.select');

    Route::get('orders', [App\Http\Controllers\Company\OrderController::class, 'index'])->name('orders');
    Route::get('list', [App\Http\Controllers\Company\OrderController::class, 'list'])->name('orders.list');
    Route::get('orders/download', [App\Http\Controllers\Company\OrderController::class, 'download'])->name('orders.download');
    Route::post('orders/change-to-confirmed', [App\Http\Controllers\Company\OrderController::class, 'changeToConfirmed'])->name('orders.changeToConfirmed');
    Route::post('orders/change-to-canceled', [App\Http\Controllers\Company\OrderController::class, 'changeToCanceled'])->name('orders.changeToCanceled');
    Route::get('orders/{id}/edit', [App\Http\Controllers\Company\OrderController::class, 'edit'])->name('orders.edit');
    Route::get('orders/show/{id}', [App\Http\Controllers\Company\OrderController::class, 'show'])->name('orders.show');
    Route::delete('orders/{id}', [App\Http\Controllers\Company\OrderController::class, 'destroy'])->name('orders.destroy');

    Route::get('profile', [App\Http\Controllers\Company\ProfileController::class, 'index'])->name('profile.index');
    Route::get('change-password', [App\Http\Controllers\Company\ProfileController::class, 'changePassword'])->name('profile.change_password');
});
