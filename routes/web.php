<?php

/*
|--------------------------------------------------------------------------
| Developer Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| System Route Resources
|--------------------------------------------------------------------------
*/
Route::resource('administrators', 'AdministratorsController');
Route::resource('trainees', 'TraineesController');

Route::prefix('admin')->middleware('auth', 'can.access')->group(function () {
    Route::resource('branch-courses', 'BranchCoursesController');
    Route::resource('courses', 'CoursesController');
    Route::resource('original-prices', 'OriginalPricesController');
    Route::resource('schedules', 'SchedulesController');
});

/*
|--------------------------------------------------------------------------
| System Individual GET Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return redirect()->route('admin.login'); });
Route::get('admin/login', function () { return view('pages.login'); })->middleware('guest')->name('admin.login');
Route::get('trainee/login', 'TraineesController@login')->middleware('guest')->name('trainee.login');
Route::get('trainee/register', 'TraineesController@register')->name('trainee.register');
Route::get('page-not-found', function () { return view('pages.404'); });

Route::prefix('admin')->middleware('auth', 'can.access')->group(function () {
    Route::get('administrators', 'AdministratorsController@index')->name('admin.index');
    Route::get('home', function () { return view('layouts.main'); })->name('admin.home');
    Route::get('trainees', 'TraineesController@index')->name('trainees.index');
    Route::get('trainees/{trainee}', 'TraineesController@show')->name('trainees.show');
    Route::get('reservations', 'ReservationsController@index')->name('reservations.index');
    Route::get('reservations/{reservation}', 'ReservationsController@show')->name('reservations.show');
    Route::get('reservations/{reservation}/all', 'ReservationsController@index')->name('reservations.show-all');
});

Route::prefix('trainee')->middleware('auth', 'can.access')->group(function () {
    Route::get('home', 'TraineesController@home')->name('trainee.home');
    Route::get('schedules', 'TraineesController@schedules')->name('trainee-schedules');
    Route::get('schedules/{schedule}', 'TraineesController@showSchedule')->name('trainee-schedules.show');
    Route::get('reservations', 'TraineesController@reservations')->name('trainee-reservations');
    Route::get('reservations/{reservation}', 'TraineesController@showReservation')->name('trainee-reservations.show');
});

/*
|--------------------------------------------------------------------------
| System Individual POST Routes
|--------------------------------------------------------------------------
*/
Route::post('authenticate', 'Auth\LoginController@login')->name('login.authenticate');
Route::post('trainee/signup', 'TraineesController@signUp')->name('trainee.signup');
Route::post('request-reset-password', 'UsersController@requestPasswordReset')->name('users.request-reset-password');
Route::get('reset-password/{user}', 'UsersController@resetPassword')->name('users.reset-password');

Route::prefix('admin')->middleware('auth', 'can.access')->group(function () {
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');
    Route::post('payment-transactions', 'PaymentTransactionsController@store');
});

Route::prefix('trainee')->middleware('auth', 'can.access')->group(function () {
    Route::post('logout', 'Auth\LoginController@logout')->name('trainee.logout');
    Route::post('reservations/{schedule}', 'ReservationsController@store')->name('trainee-reservations.store');
    Route::post('payment-transactions', 'PaymentTransactionsController@store');
});

/*
|--------------------------------------------------------------------------
| System Individual UPDATE Routes
|--------------------------------------------------------------------------
*/
Route::put('save-new-password/{user}', 'UsersController@saveNewPassword')->name('users.save-new-password');

Route::prefix('trainee')->middleware('auth', 'can.access')->group(function () {
    Route::put('reservations/{reservation}', 'ReservationsController@update');
});

Route::prefix('admin')->middleware('auth', 'can.access')->group(function () {
    Route::put('reservations/{reservation}', 'ReservationsController@update');
    Route::put('reservations/{reservation}/confirm', 'ReservationsController@confirm')->name('reservations.confirm');
    Route::put('reservations/{reservation}/refund', 'ReservationsController@refund')->name('reservations.refund');
    Route::put('reservations/{reservation}/registered', 'ReservationsController@registered')->name('reservations.registered');
    Route::put('courses/{course}/restore', 'CoursesController@restore')->name('courses.restore');
});

/*
|--------------------------------------------------------------------------
| System Individual DELETE Routes
|--------------------------------------------------------------------------
*/
