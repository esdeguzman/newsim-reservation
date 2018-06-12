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
Route::get('home', function () { return view('layouts.main'); })->name('home');
Route::get('trainee/register', 'TraineesController@register')->name('trainee.register');
Route::get('trainee/login', 'TraineesController@login')->name('trainee.login');
Route::get('trainee/home', 'TraineesController@home')->name('trainee.home');
Route::get('trainee/schedules', 'TraineesController@schedules')->name('trainee.schedules');
Route::get('trainee/schedules/{schedule}', 'TraineesController@showSchedule')->name('trainee.schedule-show');
Route::get('trainee/reservations', 'TraineesController@reservations')->name('trainee.reservations');
Route::get('trainee/reservations/{reservation}', 'TraineesController@showReservation')->name('trainee.reservation-show');

/*
|--------------------------------------------------------------------------
| System Individual POST Routes
|--------------------------------------------------------------------------
*/

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
