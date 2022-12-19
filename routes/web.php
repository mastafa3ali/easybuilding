<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('mobile-detected', function () {
    return view('mobile_detected');
})->name('mobile_detected');

Auth::routes();

Route::middleware(['detect_mobile'])->group(function () {


    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        return 'Storage link created';
    });
    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        return 'Cache cleared';
    });
    Route::get('/install-permissions', function () {
        Artisan::call('install:permissions');
        return 'Permission updated';
    });
});
