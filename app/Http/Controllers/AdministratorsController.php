<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministratorsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can.access'])->except('login', 'store');
    }

    public function login()
    {
        return view('pages.login', [
            'branches' => Branch::all(),
            'departments' => Department::all(),
            'positions' => Position::all(),
        ]);
    }
    public function index()
    {
        return view('administrators.index');
    }

    public function show()
    {
        return view('administrators.show');
    }
}
