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
    Route::post('confirm-reset', [App\Http\Controllers\Api\V1\AuthController::class, 'confirmReset']);
    Route::post('check-code', [App\Http\Controllers\Api\V1\AuthController::class, 'checkCode']);
    Route::post('register', [App\Http\Controllers\Api\V1\AuthController::class, 'register']);
    Route::post('verify', [App\Http\Controllers\Api\V1\AuthController::class, 'verify']);

    Route::get('home', [App\Http\Controllers\Api\V1\PageController::class, 'home']);
    Route::get('get-companies/{id}', [App\Http\Controllers\Api\V1\PageController::class, 'getCompanies']);
    Route::get('get-company-product/{company_id}/{category_id}', [App\Http\Controllers\Api\V1\PageController::class, 'getCompanyProduct']);
    Route::get('get-sales/{id}', [App\Http\Controllers\Api\V1\PageController::class, 'getSales']);
    Route::get('get-rent/{id}', [App\Http\Controllers\Api\V1\PageController::class, 'getRent']);
    Route::get('products', [App\Http\Controllers\Api\V1\ProductController::class, 'index']);
    Route::get('product/{id}', [App\Http\Controllers\Api\V1\ProductController::class, 'show']);
    Route::get('about', [App\Http\Controllers\Api\V1\SettingController::class, 'about']);
    Route::get('terms', [App\Http\Controllers\Api\V1\SettingController::class, 'terms']);
    Route::get('privacy', [App\Http\Controllers\Api\V1\SettingController::class, 'privacy']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('get-saved-products', [App\Http\Controllers\Api\V1\PageController::class, 'getSavedProduct']);
        Route::get('get-saved-companies', [App\Http\Controllers\Api\V1\PageController::class, 'getSavedCompany']);
        Route::get('sales', [App\Http\Controllers\Api\V1\PageController::class, 'sales']);
        Route::post('save', [App\Http\Controllers\Api\V1\PageController::class, 'makeSaved']);
        Route::post('order', [App\Http\Controllers\Api\V1\OrderController::class, 'store']);

        Route::post('sale-order', [App\Http\Controllers\Api\V1\OrderController::class, 'saleStore']);

        Route::post('order-submit', [App\Http\Controllers\Api\V1\OrderController::class, 'orderSubmit']);
        Route::get('notifications', [App\Http\Controllers\Api\V1\PageController::class, 'notifications']);
        Route::get('profile', [App\Http\Controllers\Api\V1\PageController::class, 'profile']);
        Route::post('update-profile', [App\Http\Controllers\Api\V1\AuthController::class, 'updateProfile']);

        Route::get('contact', [App\Http\Controllers\Api\V1\SettingController::class, 'contact']);
        Route::post('set-saved', [App\Http\Controllers\Api\V1\ProductController::class, 'setSaved']);
        Route::get('get-saved', [App\Http\Controllers\Api\V1\ProductController::class, 'getSaved']);

        Route::post('logout', [App\Http\Controllers\Api\V1\AuthController::class, 'logout']);
        Route::delete('delete-account', [App\Http\Controllers\Api\V1\AuthController::class, 'deleteAccount']);

        Route::post('fcm-token', [App\Http\Controllers\Api\V1\AuthController::class, 'updateToken']);

    });
});
