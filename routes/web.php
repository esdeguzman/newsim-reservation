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
Route::get('/', function () { return view('pages.login'); })->name('login');
Route::get('trainee/register', 'TraineesController@register')->name('trainee.register');

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
// Unguarded get routes
Route::post('authenticate', 'Auth\LoginController@login')->name('login.authenticate');

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
Route::resource('courses', 'CoursesController');
Route::resource('reservations', 'ReservationsController');
Route::resource('schedules', 'SchedulesController');
Route::resource('trainees', 'TraineesController');
