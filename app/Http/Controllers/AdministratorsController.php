<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministratorsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can.access'])->except('login', 'store');
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
