<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TraineesController extends Controller
{
    public function index()
    {
        return view('trainees.index');
    }

    public function show()
    {
        return view('trainees.show');
    }

    public function register()
    {
        return view('trainees.register');
    }

    public function login()
    {
        return view('trainees.login');
    }

    public function home()
    {
        return view('layouts.trainee-main');
    }

    public function schedules()
    {
        return view('trainees.schedules');
    }

    public function showSchedule(Request $request)
    {
        return view('trainees.schedule-show');
    }

    public function reservations()
    {
        return view('trainees.reservations');
    }

    public function showReservation(Request $request)
    {
        return view('trainees.reservation-show');
    }
}
