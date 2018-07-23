<?php

namespace App\Http\Controllers;

use App\Administrator;
use App\Branch;
use App\Department;
use App\HistoryDetail;
use App\Position;
use App\User;
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

    public function store(Request $request)
    {
        $request['username'] = $request->desired_username;
        $request['password'] = $request->desire_password;

        $userDetails = $request->validate([
            'desired_username' => 'required|min:3|unique:users,user',
            'email' => 'required|unique:users',
            'desired_password' => 'required|min:6|confirmed',
        ]);

        $adminInfo = $request->validate([
            'branch_id' => 'required',
            'department_id' => 'required',
            'position_id' => 'required',
            'employee_id' => 'required',
            'full_name' => 'required',
        ]);

        $request->validate([
            'reason' => 'required|min:15'
        ]);

        $userDetails['password'] = bcrypt($userDetails['password']);

        $user = User::create(array_except($userDetails, ['desired_username', 'desired_password']));

        $adminInfo['user_id'] = $user->id; // add user_id to adminInfo to facilitate the use of create method

        $admin = Administrator::create($adminInfo);

        HistoryDetail::create([
            'log' => $request->reason,
            'remarks' => "$request->full_name is requesting an admin account, please see log",
            'updated_by' => 1,
        ]);

        $request->session()->flash('info', [
            'success' => 'Request successfully submitted! You will receive an email that will verification email ' .
                            'after the administrator has confirmed your request.'
        ] );

        return back();
    }
}
