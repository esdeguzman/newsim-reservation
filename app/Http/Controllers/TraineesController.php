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

    public function schedules(Request $request)
    {
        $branch = $request->has('branch')? $request->branch : null;
        $schedules = null;
        $reservations = null;
        $reservedCoursesIds = Reservation::select('course_id')->where('trainee_id', trainee()->id)->get();
        $schedules = Schedule::whereNotIn('course_id', $reservedCoursesIds)->get();

        if($branch) {
            $schedules = Schedule::whereHas('branch', function ($query) use ($request) {
                $query->where('name', $request->branch);
            })->get();
        }

        return view('trainees.schedules', compact('branch', 'schedules', 'reservations'));
    }

    public function showSchedule(Schedule $schedule, Request $request)
    {
        return view('trainees.schedule-show', compact('schedule'));
    }

    public function reservations()
    {
        $reservations = trainee()->hasReservations()? Reservation::where('trainee_id', trainee()->id)
            ->withTrashed()->get()->unique('code')->sortByDesc('created_at')->values()->all() : null;

        return view('trainees.reservations', compact('reservations'));
    }

    public function showReservation($reservation)
    {
        $reservation = Reservation::where('id', $reservation)->withTrashed()->first();

        foreach($reservation->paymentTransactions as $paymentTransaction) {
            if ($paymentTransaction->status == 'confirmed' || $paymentTransaction->status == 'confirmed') {
                $paymentTransaction->seen = 1;
                $paymentTransaction->save();
            }
        }

        if ($reservation->status == 'paid' || $reservation->status == 'registered') {
            $reservation->seen = 1;
            $reservation->save();
        }

        return view('trainees.reservation-show', compact('reservation'));
    }
}
