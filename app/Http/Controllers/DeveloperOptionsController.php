<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeveloperOptionsController extends Controller
{
    public function index()
    {
        return view('developer.index');
    }
}
