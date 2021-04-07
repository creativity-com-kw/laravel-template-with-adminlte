<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'admin/login');

// Auth
Route::match(['get', 'head'], 'login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::match(['get', 'head'], 'register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Route::match(['get', 'head'], 'password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::match(['get', 'head'], 'password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::match(['get', 'head'], 'password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');

Route::match(['get', 'head'], 'email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::match(['get', 'head'], 'email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// Basic
Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/my-profile/{user}/edit', 'MyProfileController@edit')->name('my-profile.edit')->middleware('verified:admin.verification.notice');
    Route::match(['put', 'patch', 'post'], '/my-profile/{user}', 'MyProfileController@update')->name('my-profile.update');
    Route::delete('/my-profile/{user}/avatar', 'MyProfileController@destroyAvatar')->name('my-profile.avatar.delete');

    Route::resource('/change-password', 'ChangePasswordController')->only(['edit', 'update'])->parameters(['change-password' => 'user']);

    Route::resource('/cms', 'CmsController')->only(['edit', 'update'])->parameters(['cms' => 'masterCms']);

    Route::resource('/settings', 'SettingController')->only(['edit', 'update'])->middleware(['password.confirm:admin.password.confirm']);
});

// Security
Route::middleware(['auth'])->prefix('security')->name('security.')->group(function () {
    Route::resource('/permissions', 'Security\PermissionController')->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('/roles', 'Security\RoleController')->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

// Users
Route::middleware(['auth'])->prefix('users')->name('users.')->group(function () {
    Route::match(['put', 'patch', 'post'], '/admins/{user}', 'Admin\AdminController@update')->name('admins.update');
    Route::match(['put', 'patch'], '/admins/{user}/restore', 'Admin\AdminController@restore')->name('admins.restore');
    Route::delete('/admins/{user}/avatar', 'Admin\AdminController@destroyAvatar')->name('admins.avatar.delete');
    Route::resource('/admins', 'Admin\AdminController')->only(['index', 'create', 'store', 'edit', 'destroy'])->parameters(['admins' => 'user']);

    Route::match(['put', 'patch', 'post'], '/coaches/{user}', 'Coach\CoachController@update')->name('coaches.update');
    Route::match(['put', 'patch'], '/coaches/{user}/restore', 'Coach\CoachController@restore')->name('coaches.restore');
    Route::delete('/coaches/{user}/avatar', 'Coach\CoachController@destroyAvatar')->name('coaches.avatar.delete');
    Route::resource('/coaches', 'Coach\CoachController')->only(['index', 'create', 'store', 'edit', 'destroy'])->parameters(['coaches' => 'user']);

    Route::match(['put', 'patch', 'post'], '/members/{user}', 'Member\MemberController@update')->name('members.update');
    Route::match(['put', 'patch'], '/members/{user}/restore', 'Member\MemberController@restore')->name('members.restore');
    Route::delete('/members/{user}/avatar', 'Member\MemberController@destroyAvatar')->name('members.avatar.delete');
    Route::resource('/members', 'Member\MemberController')->only(['index', 'create', 'store', 'edit', 'destroy'])->parameters(['members' => 'user']);

    Route::match(['put', 'patch'], '/guests/{user}/restore', 'Guest\GuestController@restore')->name('guests.restore');
    Route::resource('/guests', 'Guest\GuestController')->only(['index', 'edit', 'update', 'destroy'])->parameters(['guests' => 'user']);
});

// M1
Route::middleware(['auth'])->prefix('m1')->name('m1.')->group(function () {
    Route::resource('/configurations', 'M1\ConfigurationController')->only(['edit', 'update'])->parameters(['configurations' => 'setting']);

    Route::match(['put', 'patch', 'post'], '/packages/{package}', 'M1\PackageController@update')->name('packages.update');
    Route::match(['put', 'patch'], '/packages/{package}/restore', 'M1\PackageController@restore')->name('packages.restore');
    Route::delete('/packages/{package}/image', 'M1\PackageController@destroyImage')->name('packages.image.delete');
    Route::resource('/packages', 'M1\PackageController')->only(['index', 'create', 'store', 'edit', 'destroy']);

    Route::match(['put', 'patch'], '/coupons/{coupon}/restore', 'M1\CouponController@restore')->name('coupons.restore');
    Route::resource('/coupons', 'M1\CouponController')->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::match(['get', 'head'], '/calendar', 'M1\CalendarController@index')->name('calendar.index');

    Route::match(['put', 'patch'], '/classes/{class}/restore', 'M1\ClassController@restore')->name('classes.restore');
    Route::resource('/classes', 'M1\ClassController')->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('classes.cycles', 'M1\ClassCycleController')->only(['index', 'update']);

    Route::resource('classes.schedule', 'M1\ScheduleController')->only(['index', 'store', 'edit', 'update', 'destroy']);
});

// M2
Route::middleware(['auth'])->prefix('m2')->name('m2.')->group(function () {
    Route::resource('/configurations', 'M2\ConfigurationController')->only(['edit', 'update'])->parameters(['configurations' => 'setting']);

    Route::match(['get', 'head'], '/calendar', 'M2\CalendarController@index')->name('calendar.index');

    Route::match(['put', 'patch', 'post'], '/packages/{package}', 'M2\PackageController@update')->name('packages.update');
    Route::match(['put', 'patch'], '/packages/{package}/restore', 'M2\PackageController@restore')->name('packages.restore');
    Route::delete('/packages/{package}/image', 'M2\PackageController@destroyImage')->name('packages.image.delete');
    Route::resource('/packages', 'M2\PackageController')->only(['index', 'create', 'store', 'edit', 'destroy']);

    Route::match(['put', 'patch'], '/coupons/{coupon}/restore', 'M2\CouponController@restore')->name('coupons.restore');
    Route::resource('/coupons', 'M2\CouponController')->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('/schedule', 'M2\ScheduleController')->only(['index', 'store', 'edit', 'update', 'destroy']);
});

// M3
Route::middleware(['auth'])->prefix('m3')->name('m3.')->group(function () {
    Route::resource('/configurations', 'M3\ConfigurationController')->only(['edit', 'update'])->parameters(['configurations' => 'setting']);

    Route::match(['get', 'head'], '/calendar', 'M3\CalendarController@index')->name('calendar.index');

    Route::match(['put', 'patch', 'post'], '/packages/{package}', 'M3\PackageController@update')->name('packages.update');
    Route::match(['put', 'patch'], '/packages/{package}/restore', 'M3\PackageController@restore')->name('packages.restore');
    Route::delete('/packages/{package}/image', 'M3\PackageController@destroyImage')->name('packages.image.delete');
    Route::resource('/packages', 'M3\PackageController')->only(['index', 'create', 'store', 'edit', 'destroy']);

    Route::match(['put', 'patch'], '/coupons/{coupon}/restore', 'M3\CouponController@restore')->name('coupons.restore');
    Route::resource('/coupons', 'M3\CouponController')->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::match(['put', 'patch', 'post'], '/classes/{class}', 'M3\ClassController@update')->name('classes.update');
    Route::match(['put', 'patch'], '/classes/{class}/restore', 'M3\ClassController@restore')->name('classes.restore');
    Route::delete('/classes/{class}/image', 'M3\ClassController@destroyImage')->name('classes.image.delete');
    Route::resource('/classes', 'M3\ClassController')->only(['index', 'create', 'store', 'edit', 'destroy']);

    Route::resource('classes.schedule', 'M3\ScheduleController')->only(['index', 'store', 'edit', 'update', 'destroy']);
});

// Mail
Route::middleware(['auth'])->group(function () {
    Route::get('/mail/render', function () {
        return (new \App\Mail\Welcome(auth()->user()))->render();
    });

    Route::get('/mail/mailable', function () {
        return new App\Mail\Welcome(auth()->user());
    });

    Route::get('/mail/send', function () {
        Mail::to(auth()->user())->send(new \App\Mail\Welcome(auth()->user()));

        return 'Ok';
    });
});

// DB Notification
Route::middleware(['auth'])->group(function () {
    Route::get('/notification/db', function () {
        auth()->user()->notify(new \App\Notifications\SimpleDBNotification());

        return 'Ok';
    });

    Route::get('/notification/db/list', function () {
        return auth()->user()->notifications;
    });

    Route::get('/notification/db/unread', function () {
        return auth()->user()->unreadNotifications;
    });
});
