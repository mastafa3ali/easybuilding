<?php

use Illuminate\Support\Facades\Route;

Route::middleware('throttle:60,1')->group(function () {
    Route::get('admin/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login');
    Route::post('admin/login', [App\Http\Controllers\Admin\AuthController::class, 'postLogin'])->name('admin.postLogin');
    Route::post('admin/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');
Route::group(['middleware' => ['language']], function () {

    Route::group(
        ['middleware' => 'authenticate.admin', 'as' => 'admin.'],
        function () {
            Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index']);
        }
    );
    Route::group(['middleware' => 'authenticate.admin', 'as' => 'admin.', 'prefix' => 'admin'], function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('home');

        Route::patch('/fcm-token', [App\Http\Controllers\Admin\AdminController::class, 'updateToken'])->name('fcmToken');
        Route::post('/send-notification', [App\Http\Controllers\Admin\AdminController::class,'notification'])->name('notification');

        Route::get('rates', [App\Http\Controllers\Admin\RateController::class, 'index'])->name('rates.index')->middleware('permission:rates.view');
        Route::get('rates/list', [App\Http\Controllers\Admin\RateController::class, 'list'])->name('rates.list')->middleware('permission:rates.view');

        Route::get('sliders/select', [App\Http\Controllers\Admin\SliderController::class, 'select'])->name('sliders.select');
        Route::delete('sliders/bulk', [App\Http\Controllers\Admin\SliderController::class, 'deleteBulk'])->name('sliders.deleteBulk')->middleware('permission:sliders.delete');
        Route::get('sliders/list', [App\Http\Controllers\Admin\SliderController::class, 'list'])->name('sliders.list')->middleware('permission:sliders.view');
        Route::post('sliders', [App\Http\Controllers\Admin\SliderController::class, 'store'])->name('sliders.store')->middleware('permission:sliders.create');
        Route::delete('sliders/{id}', [App\Http\Controllers\Admin\SliderController::class, 'destroy'])->name('sliders.destroy')->middleware('permission:sliders.delete');
        Route::get('sliders', [App\Http\Controllers\Admin\SliderController::class, 'index'])->name('sliders.index')->middleware('permission:sliders.view');
        Route::get('sliders/create', [App\Http\Controllers\Admin\SliderController::class, 'create'])->name('sliders.create')->middleware('permission:sliders.create');
        Route::match(['PUT', 'PATCH'], 'sliders/{id}', [App\Http\Controllers\Admin\SliderController::class, 'update'])->name('sliders.update')->middleware('permission:sliders.edit');
        Route::get('sliders/{id}/edit', [App\Http\Controllers\Admin\SliderController::class, 'edit'])->name('sliders.edit')->middleware('permission:sliders.edit');

        Route::get('notifications/select', [App\Http\Controllers\Admin\NotificationController::class, 'select'])->name('notifications.select');
        Route::delete('notifications/bulk', [App\Http\Controllers\Admin\NotificationController::class, 'deleteBulk'])->name('notifications.deleteBulk')->middleware('permission:notifications.delete');
        Route::get('notifications/list', [App\Http\Controllers\Admin\NotificationController::class, 'list'])->name('notifications.list')->middleware('permission:notifications.view');
        Route::post('notifications', [App\Http\Controllers\Admin\NotificationController::class, 'store'])->name('notifications.store')->middleware('permission:notifications.create');
        Route::delete('notifications/{id}', [App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy')->middleware('permission:notifications.delete');
        Route::get('notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index')->middleware('permission:notifications.view');
        Route::get('notifications/create', [App\Http\Controllers\Admin\NotificationController::class, 'create'])->name('notifications.create')->middleware('permission:notifications.create');
        Route::match(['PUT', 'PATCH'], 'notifications/{id}', [App\Http\Controllers\Admin\NotificationController::class, 'update'])->name('notifications.update')->middleware('permission:notifications.edit');
        Route::get('notifications/{id}/edit', [App\Http\Controllers\Admin\NotificationController::class, 'edit'])->name('notifications.edit')->middleware('permission:notifications.edit');

        Route::get('categories/select', [App\Http\Controllers\Admin\CategoryController::class, 'select'])->name('categories.select');
        Route::delete('categories/bulk', [App\Http\Controllers\Admin\CategoryController::class, 'deleteBulk'])->name('categories.deleteBulk')->middleware('permission:categories.delete');
        Route::get('categories/list', [App\Http\Controllers\Admin\CategoryController::class, 'list'])->name('categories.list')->middleware('permission:categories.view');
        Route::post('categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store')->middleware('permission:categories.create');
        Route::delete('categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('permission:categories.delete');
        Route::get('categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index')->middleware('permission:categories.view');
        Route::get('categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('categories.create')->middleware('permission:categories.create');
        Route::match(['PUT', 'PATCH'], 'categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update')->middleware('permission:categories.edit');
        Route::get('categories/{id}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('categories.edit')->middleware('permission:categories.edit');

        Route::get('sub_categories/select', [App\Http\Controllers\Admin\SubCategoryController::class, 'select'])->name('sub_categories.select');
        Route::delete('sub_categories/bulk', [App\Http\Controllers\Admin\SubCategoryController::class, 'deleteBulk'])->name('sub_categories.deleteBulk')->middleware('permission:sub_categories.delete');
        Route::get('sub_categories/list', [App\Http\Controllers\Admin\SubCategoryController::class, 'list'])->name('sub_categories.list')->middleware('permission:sub_categories.view');
        Route::post('sub_categories', [App\Http\Controllers\Admin\SubCategoryController::class, 'store'])->name('sub_categories.store')->middleware('permission:sub_categories.create');
        Route::delete('sub_categories/{id}', [App\Http\Controllers\Admin\SubCategoryController::class, 'destroy'])->name('sub_categories.destroy')->middleware('permission:sub_categories.delete');
        Route::get('sub_categories', [App\Http\Controllers\Admin\SubCategoryController::class, 'index'])->name('sub_categories.index')->middleware('permission:sub_categories.view');
        Route::get('sub_categories/create', [App\Http\Controllers\Admin\SubCategoryController::class, 'create'])->name('sub_categories.create')->middleware('permission:sub_categories.create');
        Route::match(['PUT', 'PATCH'], 'sub_categories/{id}', [App\Http\Controllers\Admin\SubCategoryController::class, 'update'])->name('sub_categories.update')->middleware('permission:sub_categories.edit');
        Route::get('sub_categories/{id}/edit', [App\Http\Controllers\Admin\SubCategoryController::class, 'edit'])->name('sub_categories.edit')->middleware('permission:sub_categories.edit');

        Route::get('products/orders', [App\Http\Controllers\Admin\ProductController::class, 'order'])->name('products.orders');
        Route::get('orders/show/{id}', [App\Http\Controllers\Admin\ProductController::class, 'showOrder'])->name('orders.showOrder');
        Route::get('products/orderlist', [App\Http\Controllers\Admin\ProductController::class, 'orderlist'])->name('products.orderlist');
        Route::get('products/select', [App\Http\Controllers\Admin\ProductController::class, 'select'])->name('products.select');
        Route::delete('products/bulk', [App\Http\Controllers\Admin\ProductController::class, 'deleteBulk'])->name('products.deleteBulk')->middleware('permission:products.delete');
        Route::get('products/list', [App\Http\Controllers\Admin\ProductController::class, 'list'])->name('products.list')->middleware('permission:products.view');
        Route::post('products', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store')->middleware('permission:products.create');
        Route::delete('products/{id}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy')->middleware('permission:products.delete');
        Route::get('products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index')->middleware('permission:products.view');
        Route::get('products/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create')->middleware('permission:products.create');
        Route::match(['PUT', 'PATCH'], 'products/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update')->middleware('permission:products.edit');
        Route::get('products/{id}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit')->middleware('permission:products.edit');

        Route::get('sections/select', [App\Http\Controllers\Admin\SectionController::class, 'select'])->name('sections.select');
        Route::delete('sections/bulk', [App\Http\Controllers\Admin\SectionController::class, 'deleteBulk'])->name('sections.deleteBulk')->middleware('permission:sections.delete');
        Route::get('sections/list', [App\Http\Controllers\Admin\SectionController::class, 'list'])->name('sections.list')->middleware('permission:sections.view');
        Route::post('sections', [App\Http\Controllers\Admin\SectionController::class, 'store'])->name('sections.store')->middleware('permission:sections.create');
        Route::delete('sections/{id}', [App\Http\Controllers\Admin\SectionController::class, 'destroy'])->name('sections.destroy')->middleware('permission:sections.delete');
        Route::get('sections', [App\Http\Controllers\Admin\SectionController::class, 'index'])->name('sections.index')->middleware('permission:sections.view');
        Route::get('sections/create', [App\Http\Controllers\Admin\SectionController::class, 'create'])->name('sections.create')->middleware('permission:sections.create');
        Route::match(['PUT', 'PATCH'], 'sections/{id}', [App\Http\Controllers\Admin\SectionController::class, 'update'])->name('sections.update')->middleware('permission:sections.edit');
        Route::get('sections/{id}/edit', [App\Http\Controllers\Admin\SectionController::class, 'edit'])->name('sections.edit')->middleware('permission:sections.edit');

        Route::get('readingcycles/select', [App\Http\Controllers\Admin\ReadingcycleController::class, 'select'])->name('readingcycles.select');
        Route::delete('readingcycles/bulk', [App\Http\Controllers\Admin\ReadingcycleController::class, 'deleteBulk'])->name('readingcycles.deleteBulk')->middleware('permission:readingcycles.delete');
        Route::get('readingcycles/list', [App\Http\Controllers\Admin\ReadingcycleController::class, 'list'])->name('readingcycles.list')->middleware('permission:readingcycles.view');
        Route::post('readingcycles', [App\Http\Controllers\Admin\ReadingcycleController::class, 'store'])->name('readingcycles.store')->middleware('permission:readingcycles.create');
        Route::delete('readingcycles/{id}', [App\Http\Controllers\Admin\ReadingcycleController::class, 'destroy'])->name('readingcycles.destroy')->middleware('permission:readingcycles.delete');
        Route::get('readingcycles', [App\Http\Controllers\Admin\ReadingcycleController::class, 'index'])->name('readingcycles.index')->middleware('permission:readingcycles.view');
        Route::get('readingcycles/create', [App\Http\Controllers\Admin\ReadingcycleController::class, 'create'])->name('readingcycles.create')->middleware('permission:readingcycles.create');
        Route::match(['PUT', 'PATCH'], 'readingcycles/{id}', [App\Http\Controllers\Admin\ReadingcycleController::class, 'update'])->name('readingcycles.update')->middleware('permission:readingcycles.edit');
        Route::get('readingcycles-addstudent/{id}', [App\Http\Controllers\Admin\ReadingcycleController::class, 'addStudent'])->name('readingcycles.addStudent')->middleware('permission:readingcycles.addStudent');
        Route::post('storereadingcycles-addstudent/{id}', [App\Http\Controllers\Admin\ReadingcycleController::class, 'storeReadingStudents'])->name('readingcycles.storeReadingStudents')->middleware('permission:readingcycles.addStudent');
        Route::get('tracks-addstudent/{id}', [App\Http\Controllers\Admin\TrackController::class, 'addStudent'])->name('tracks.addStudent')->middleware('permission:tracks.addStudent');
        Route::post('storetracks-addstudent/{id}', [App\Http\Controllers\Admin\TrackController::class, 'storeTrackStudents'])->name('tracks.storeTrackStudents')->middleware('permission:tracks.addStudent');

        Route::get('readingcycles/{id}/edit', [App\Http\Controllers\Admin\ReadingcycleController::class, 'edit'])->name('readingcycles.edit')->middleware('permission:readingcycles.edit');


        Route::get('tracks/select', [App\Http\Controllers\Admin\TrackController::class, 'select'])->name('tracks.select');
        Route::delete('tracks/bulk', [App\Http\Controllers\Admin\TrackController::class, 'deleteBulk'])->name('tracks.deleteBulk')->middleware('permission:tracks.delete');
        Route::get('tracks/list', [App\Http\Controllers\Admin\TrackController::class, 'list'])->name('tracks.list')->middleware('permission:tracks.view');
        Route::post('tracks', [App\Http\Controllers\Admin\TrackController::class, 'store'])->name('tracks.store')->middleware('permission:tracks.create');
        Route::delete('tracks/{id}', [App\Http\Controllers\Admin\TrackController::class, 'destroy'])->name('tracks.destroy')->middleware('permission:tracks.delete');
        Route::get('tracks', [App\Http\Controllers\Admin\TrackController::class, 'index'])->name('tracks.index')->middleware('permission:tracks.view');
        Route::get('tracks/create', [App\Http\Controllers\Admin\TrackController::class, 'create'])->name('tracks.create')->middleware('permission:tracks.create');
        Route::match(['PUT', 'PATCH'], 'tracks/{id}', [App\Http\Controllers\Admin\TrackController::class, 'update'])->name('tracks.update')->middleware('permission:tracks.edit');
        Route::get('tracks/{id}/edit', [App\Http\Controllers\Admin\TrackController::class, 'edit'])->name('tracks.edit')->middleware('permission:tracks.edit');


        Route::get('teams/select', [App\Http\Controllers\Admin\TeamController::class, 'select'])->name('teams.select');
        Route::delete('teams/bulk', [App\Http\Controllers\Admin\TeamController::class, 'deleteBulk'])->name('teams.deleteBulk')->middleware('permission:teams.delete');
        Route::get('teams/list', [App\Http\Controllers\Admin\TeamController::class, 'list'])->name('teams.list')->middleware('permission:teams.view');
        Route::post('teams', [App\Http\Controllers\Admin\TeamController::class, 'store'])->name('teams.store')->middleware('permission:teams.create');
        Route::delete('teams/{id}', [App\Http\Controllers\Admin\TeamController::class, 'destroy'])->name('teams.destroy')->middleware('permission:teams.delete');
        Route::get('teams', [App\Http\Controllers\Admin\TeamController::class, 'index'])->name('teams.index')->middleware('permission:teams.view');
        Route::get('teams/create', [App\Http\Controllers\Admin\TeamController::class, 'create'])->name('teams.create')->middleware('permission:teams.create');
        Route::match(['PUT', 'PATCH'], 'teams/{id}', [App\Http\Controllers\Admin\TeamController::class, 'update'])->name('teams.update')->middleware('permission:teams.edit');
        Route::get('teams/{id}/edit', [App\Http\Controllers\Admin\TeamController::class, 'edit'])->name('teams.edit')->middleware('permission:teams.edit');

        Route::get('contacts/select', [App\Http\Controllers\Admin\ContactController::class, 'select'])->name('contacts.select');
        Route::delete('contacts/bulk', [App\Http\Controllers\Admin\ContactController::class, 'deleteBulk'])->name('contacts.deleteBulk')->middleware('permission:contacts.delete');
        Route::get('contacts/list', [App\Http\Controllers\Admin\ContactController::class, 'list'])->name('contacts.list')->middleware('permission:contacts.view');
        Route::delete('contacts/{id}', [App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy')->middleware('permission:contacts.delete');
        Route::get('contacts', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index')->middleware('permission:contacts.view');


        Route::get('users/select', [App\Http\Controllers\Admin\UserController::class, 'select'])->name('users.select');
        Route::get('companies/select', [App\Http\Controllers\Admin\UserController::class, 'companiesSelect'])->name('companies.select');
        Route::get('clients/select', [App\Http\Controllers\Admin\UserController::class, 'clientsSelect'])->name('clients.select');
        Route::get('users/list', [App\Http\Controllers\Admin\UserController::class, 'list'])->name('users.list')->middleware('permission:users.view');
        Route::post('users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store')->middleware('permission:users.create');
        Route::post('restore/{id}', [App\Http\Controllers\Admin\UserController::class, 'restore'])->name('users.restore')->middleware('permission:users.create');
        Route::delete('users/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:users.delete');
        Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index')->middleware('permission:users.view');
        Route::get('users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create')->middleware('permission:users.create');
        Route::match(['PUT', 'PATCH'], 'users/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update')->middleware('permission:users.edit');
        Route::get('users/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit')->middleware('permission:users.edit');
        Route::get('users/show/{id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show')->middleware('permission:users.show');

        Route::get('roles/select', [App\Http\Controllers\Admin\RoleController::class, 'select'])->name('roles.select');
        Route::get('roles/list', [App\Http\Controllers\Admin\RoleController::class, 'list'])->name('roles.list')->middleware('permission:roles.view');
        Route::post('roles', [App\Http\Controllers\Admin\RoleController::class, 'store'])->name('roles.store')->middleware('permission:roles.create');
        Route::delete('roles/{id}', [App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:roles.delete');
        Route::get('roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index')->middleware('permission:roles.view');
        Route::get('roles/create', [App\Http\Controllers\Admin\RoleController::class, 'create'])->name('roles.create')->middleware('permission:roles.create');
        Route::match(['PUT', 'PATCH'], 'roles/{id}', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('roles.update')->middleware('permission:roles.edit');
        Route::get('roles/{id}/edit', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:roles.edit');


        Route::get('settings/general', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index')->middleware('permission:settings.general');
        Route::get('settings/about', [App\Http\Controllers\Admin\SettingController::class, 'about'])->name('settings.about')->middleware('permission:settings.about');
        Route::get('settings/privacy', [App\Http\Controllers\Admin\SettingController::class, 'privacy'])->name('settings.privacy')->middleware('permission:settings.privacy');
        Route::get('settings/terms', [App\Http\Controllers\Admin\SettingController::class, 'terms'])->name('settings.terms')->middleware('permission:settings.terms');
        Route::post('settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update')->middleware('permission:settings.edit');

        Route::get('profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
        Route::get('change-password', [App\Http\Controllers\Admin\ProfileController::class, 'changePassword'])->name('profile.change_password');

        Route::get('sall-product-report', [App\Http\Controllers\Admin\ReportController::class, 'sallProductReport'])->name('sallProductReport')->middleware('permission:sallProductReport.view');
        Route::post('sall-product-report-post', [App\Http\Controllers\Admin\ReportController::class, 'sallProductReport'])->name('sallProductReportPost')->middleware('permission:sallProductReport.view');

        Route::get('rent-product-report', [App\Http\Controllers\Admin\ReportController::class, 'rentProductReport'])->name('rentProductReport')->middleware('permission:rentProductReport.view');
        Route::post('rent-product-report-post', [App\Http\Controllers\Admin\ReportController::class, 'rentProductReport'])->name('rentProductReportPost')->middleware('permission:rentProductReport.view');

        Route::get('reports/sale-orders', [App\Http\Controllers\Admin\ReportController::class, 'saleOrders'])->name('reports.saleOrders')->middleware('permission:reports.saleOrders');
        Route::get('reports/rent-orders', [App\Http\Controllers\Admin\ReportController::class, 'rentOrders'])->name('reports.rentOrders')->middleware('permission:reports.rentOrders');

    });
    });
});
