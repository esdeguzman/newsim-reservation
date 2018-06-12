<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    public function index(Request $request)
    {
        $view = null;
        if ($request->has('branch')) {
            $view = view('branches.schedules');
        } else {
            $view = view('schedules.index');
        }

        return $view;
    }

    public function show(Request $request)
    {
        $view = null;
        if ($request->has('branch')) {
            $view = view('branches.schedules-show');
        } else {
            $view = view('schedules.show');
        }

        return $view;
    }
}
