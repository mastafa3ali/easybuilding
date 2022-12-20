<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', [App\Http\Controllers\Site\HomeController::class, 'index'])->name('home');
Route::get('/about', [App\Http\Controllers\Site\HomeController::class, 'about'])->name('about');
Route::post('/contact-us', [App\Http\Controllers\Site\HomeController::class, 'contactus'])->name('contactus');
Route::post('/new-ghaith', [App\Http\Controllers\Site\HomeController::class, 'contactus'])->name('newghaith');
Route::middleware(['auth',])->group(function () {
    Route::get('/students-achievement', [App\Http\Controllers\Site\StudentController::class, 'index'])->name('studentsAchievement')->middleware('permission:site.studentsAchievement');
    Route::get('/achievement-panel', [App\Http\Controllers\Site\StudentController::class, 'achievementPanel'])->name('achievementPanel')->middleware('permission:site.achievementPanel');
    Route::get('getStudents', [App\Http\Controllers\Site\StudentController::class, 'getStudents'])->name('getStudents');
    Route::get('partStore', [App\Http\Controllers\Site\StudentController::class, 'partStore'])->name('partStore');
    Route::get('trackStore', [App\Http\Controllers\Site\StudentController::class, 'trackStore'])->name('trackStore');
    Route::get('partRemove', [App\Http\Controllers\Site\StudentController::class, 'partRemove'])->name('partRemove');
});
