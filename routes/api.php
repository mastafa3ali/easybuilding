<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {

    Route::post('login', [App\Http\Controllers\Api\V1\AuthController::class, 'login']);
    Route::post('reset-password', [App\Http\Controllers\Api\V1\AuthController::class, 'resetPassword']);
    Route::post('register', [App\Http\Controllers\Api\V1\AuthController::class, 'register']);
        
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('home', [App\Http\Controllers\Api\V1\PageController::class, 'home']);
        Route::get('sales', [App\Http\Controllers\Api\V1\PageController::class, 'sales']);

        Route::get('contact', [App\Http\Controllers\Api\V1\SettingController::class, 'contact']);
        Route::get('about', [App\Http\Controllers\Api\V1\SettingController::class, 'about']);
        Route::get('terms', [App\Http\Controllers\Api\V1\SettingController::class, 'terms']);
        Route::get('privacy', [App\Http\Controllers\Api\V1\SettingController::class, 'privacy']);
        Route::post('logout', [App\Http\Controllers\Api\V1\AuthController::class, 'logout']);
        Route::delete('delete-account', [App\Http\Controllers\Api\V1\AuthController::class, 'deleteAccount']);

    });
});
