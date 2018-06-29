<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function index(Request $request)
    {
        $view = null;
        $branch = null;

        if ($request->has('branch')) {
            $branch = $request->branch;
            $view = view('reservations.index', compact('branch'));
            // query for all trainees reservation using $request->trainee_id
        } else {
            $view = view('reservations.index', compact('branch'));
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
