<?php

/*
|--------------------------------------------------------------------------
| Developer Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| System Individual GET Routes
|--------------------------------------------------------------------------
*/
// Admin login route
Route::get('/', function () { return redirect()->route('admin.login'); });
Route::get('admin/login', function () { return view('pages.login'); })->middleware('guest')->name('admin.login');
Route::get('trainee/login', 'TraineesController@login')->middleware('guest')->name('trainee.login');

Route::get('trainee/register', 'TraineesController@register')->name('trainee.register');
Route::get('page-not-found', function () { return view('pages.404'); });

Route::prefix('admin')->middleware('auth', 'can.access')->group(function () {
    Route::get('home', function () { return view('layouts.main'); })->name('admin.home');
});

Route::prefix('trainee')->middleware('auth', 'can.access')->group(function () {
    Route::get('home', 'TraineesController@home')->name('trainee.home');
});

Route::get('trainee/schedules', 'TraineesController@schedules')->name('trainee.schedules');
Route::get('trainee/schedules/{schedule}', 'TraineesController@showSchedule')->name('trainee.schedule-show');
Route::get('trainee/reservations', 'TraineesController@reservations')->name('trainee.reservations');
Route::get('trainee/reservations/{reservation}', 'TraineesController@showReservation')->name('trainee.reservation-show');

/*
|--------------------------------------------------------------------------
| System Individual POST Routes
|--------------------------------------------------------------------------
*/
Route::post('authenticate', 'Auth\LoginController@login')->name('login.authenticate');

Route::prefix('admin')->middleware('auth', 'can.access')->group(function () {
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');
});

Route::prefix('trainee')->middleware('auth', 'can.access')->group(function () {
    Route::post('logout', 'Auth\LoginController@logout')->name('trainee.logout');
});

/*
|--------------------------------------------------------------------------
| System Individual UPDATE Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| System Individual DELETE Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| System Route Resources
|--------------------------------------------------------------------------
*/
Route::resource('administrators', 'AdministratorsController');
Route::resource('reservations', 'ReservationsController');
Route::resource('trainees', 'TraineesController');

Route::prefix('admin')->group(function () {
    Route::resource('branch-courses', 'BranchCoursesController');
    Route::resource('courses', 'CoursesController');
    Route::resource('original-prices', 'OriginalPricesController');
    Route::resource('schedules', 'SchedulesController');
});
