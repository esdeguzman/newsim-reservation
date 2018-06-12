<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function index(Request $request)
    {
        $view = null;
        if ($request->has('show_all')) {
            // query for all trainees reservation using $request->trainee_id
            $view = view('trainees.reservations');
        } else {
            $view = view('reservations.index');
        }

        return $view;
    }

    public function show(Request $request)
    {
        $view = null;
        if ($request->has('show-all')) {
            $view = view('trainees.reservations-show');
        } else {
            $view = view('reservations.show');
        }

        return $view;
    }
}
